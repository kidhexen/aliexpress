<?php
/**
 * Author: Vitaly Kukin
 * Date: 13.08.2015
 * Time: 14:05
 */

class Review {

    private $url = '';
    private $params = array(
        'feedbackServer'    => 'http://feedback.aliexpress.com',
        'refreshForm'       => '/display/productEvaluation.htm',
        '_csrf_token_'      => '',
        'ownerMemberId'     => '',
        'memberType'        => '',
        'productId'         => '',
        'companyId'         => '',
        'evaSortValue'      => '',
        'page'              => '',
        'startValidDate'    => '',
        'i18n'              => ''
    );

    function __construct( $id = '' ) {

        $this->url = $this->setUrl( $id );
    }

    /**
     * Set params
     *
     * @param $params
     */
    function setParams( $params ) {
        $this->params = $params;
    }

    /**
     * Set needle page to params for request
     *
     * @param int $page
     */
    function setPage( $page = 1 ) {
        $this->params['page'] = $page;
    }
/**
     * Get list reviews by post ID
     *
     * @param $post_id
     * @return mixed | bool
     */
    function listReviews( $post_id ) {

        global $wpdb;

        return $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM `{$wpdb->review}` WHERE `post_id` = '%d' ORDER BY `date` DESC", $post_id)
        );
    }
    /**
     * Get new params to request from AliExpress
     *
     * @return bool
     */
    function setNewParams() {

        $request = wp_remote_get($this->url);

        if( is_wp_error($request) )
            return false;

        $html = mb_convert_encoding($request['body'], 'HTML-ENTITIES', 'UTF-8');
        //$html 	= htmlspecialchars_decode(utf8_decode(htmlentities($request['body'], ENT_COMPAT, 'UTF-8', false)));
        $domd 	= new DOMDocument();
        libxml_use_internal_errors(true);
        try {
            $domd->loadHTML($html);
        }
        catch(Exception $e){
            return false;
        }
        $domd->preserveWhiteSpace = false;

        $iframe = $domd->getElementsByTagName('iframe');
        $iframe = $iframe->item(0);

        if( !isset($iframe) || !$iframe )
            return false;

        $src = $iframe->getAttribute("thesrc");

        $request = wp_remote_get($src);

        if( is_wp_error($request) )
            return false;

        $html = mb_convert_encoding($request['body'], 'HTML-ENTITIES', 'UTF-8');
        //$html 	= htmlspecialchars_decode(utf8_decode(htmlentities($request['body'], ENT_COMPAT, 'UTF-8', false)));
        libxml_use_internal_errors(true);
        try {
            $domd->loadHTML($html);
        }
        catch(Exception $e){
            return false;
        }
        $domd->preserveWhiteSpace = false;

        $server = $domd->getElementById('feedbackServer');
        if($server)
            $this->params['feedbackServer'] = $server->getAttribute("value");

        $form = $domd->getElementsByTagName('form');
        $childNodes = $form->item(0);

        if( $childNodes ) {

            $this->params['refreshForm'] = $childNodes->getAttribute("action");

            foreach($childNodes->childNodes as $node) {
                if( isset($node->tagName) && $node->tagName == 'input' ){
                    $name = $node->getAttribute("name");

                    if( isset($this->params[$name]) )
                        $this->params[$name] = $node->getAttribute("value");
                }
            }
        }
    }

    /**
     * Get Reviews from AliExpress
     * will returned array:
     * name     - Name customer ("S***h J.")
     * feedback - Feedback which customer write ("Looks exactly like picture!! Thanks")
     * date     - Date of feedback ("01 Aug 2015 05:00" should be convert to DB Date format)
     * flag     - The flag of customer country ("us", "ru", "kz")
     * star     - Rating of product ("5.00")
     *
     * @return array|bool
     */
    function getReviews() {

        $html = $this->request();

        if( !$html ) return false;

        $domd 	= new DOMDocument();
        libxml_use_internal_errors(true);
        try {
            $domd->loadHTML($html);
        }
        catch(Exception $e){
            return false;
        }
        $domd->preserveWhiteSpace = false;
        $tables = $domd->getElementsByTagName('table');
        if( $tables ) {

            foreach( $tables as $table ) {

                if( strpos($table->getAttribute("class"), 'rating-table' ) !== FALSE ) {

                    $tbody = $this->getChildNode( $table->childNodes, 'tbody' );

                    if( $tbody ) {

                        $too = array();

                        foreach( $tbody->childNodes as $node ) {

                            $review = $this->findEl( $node, 'div', 'right feedback');
                            $review = str_replace( 'No Feedback Score', '', $review);
                            $review = str_replace( 'No&nbsp;Feedback&nbsp;Score', '', $review);

                            $pos = strpos($review, "Seller's reply");
                            if( $pos !== FALSE ) {
                                $review = substr($review,0,$pos);
                            }
                            $review = preg_replace('/\s+/', ' ', $review);

                            $star = $this->findStar( $node );
                            $star = $this->mathStar( $star );

                            $too[] = array(
                                'name'      => $this->findName( $node ),
                                'feedback'  => trim($review),
                                'date'      => ae_dbdate( $this->findEl( $node, 'div', 'feedback-date') ),
                                'flag'      => $this->findFlag( $node ),
                                'star'      => $star
                            );
                        }

                        return $too;
                    }
                    else
                        return false;
                }
            }
        }
        else{
            return false;
        }

    }

    /**
     * Find Name of customer into DOM Object
     *
     * @param $dom
     * @param string $foo
     * @return string
     */
    private function findName( $dom, $foo = '' ){

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){

            if( $node->nodeName == 'span' && $this->NodeAttr( $node, 'name vip-level' ) ) {
                $foo = trim($node->nodeValue);
            }
            elseif( $this->hasChild($node) ) {

                $foo = $this->findName( $node, $foo );

            }
        }
        return $foo;
    }

    /**
     * Find Any element into DOM Object
     *
     * @param $dom
     * @param $el - element (div, span, etc)
     * @param $find - the class of element
     * @param string $foo
     * @return string
     */
    private function findEl( $dom, $el, $find, $foo = '' ) {

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){
            if( $node->nodeName == $el && $this->NodeAttr( $node, $find ) ) {
                return trim($node->nodeValue);
            }
            elseif( $this->hasChild($node) ) {
                $foo = $this->findEl( $node, $el, $find, $foo = '' );
            }
        }
        return $foo;
    }

    /**
     * Find flag of country into DOM Object
     *
     * @param $dom
     * @param string $foo
     * @return string
     */
    private function findFlag( $dom, $foo = '' ){

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){

            if( $node->nodeName == 'b' && strpos($node->getAttribute("class"), 'css_flag') !== FALSE ) {
                return trim( str_replace('css_flag css_', '', $node->getAttribute("class") ) );
            }
            elseif( $this->hasChild($node) ) {

                $foo = $this->findFlag( $node, $foo );

            }
        }
        return $foo;
    }

    /**
     * Find Rating of product into DOM Object
     *
     * @param $dom
     * @param string $foo
     * @return string
     */
    private function findStar( $dom, $foo = '' ){

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){

            if( $node->nodeName == 'div' && strpos($node->getAttribute("class"), 'star') !== FALSE ) {
                return $node->childNodes->item(0)->getAttribute("style");
            }
            elseif( $this->hasChild($node) ) {

                $foo = $this->findStar( $node, $foo );

            }
        }
        return $foo;
    }

    /**
     * Convert percent rating to float
     *
     * @param $percent
     * @return float ("5.00")
     */
    private function mathStar( $percent ) {

        $percent = preg_replace("/[^0-9,.]/", "", $percent);

        return ae_floatvalue(5*$percent/100);
    }

    /**
     * Check class of element
     *
     * @param $node
     * @param $attr
     * @return bool
     */
    private function NodeAttr( $node, $attr ) {

        $str = $node->getAttribute('class');

        if($str == $attr)
            return true;

        return false;
    }

    /**
     * Check if DOM element has child
     * @param $p
     * @return bool
     */
    private function hasChild($p) {

        if ($p->hasChildNodes()) {
            foreach ($p->childNodes as $c) {
                if ($c->nodeType == XML_ELEMENT_NODE)
                    return true;
            }
        }
        return false;
    }

    /**
     * Get Child Node by Node name
     *
     * @param $nodes
     * @param $needle
     * @return bool
     */
    private function getChildNode( $nodes, $needle ) {

        foreach( $nodes as $node ) {
            if( $node->tagName == $needle )
                return $node;
        }

        return false;
    }

    /**
     * New Url to request Review
     *
     * @param $id
     * @return string
     */
    private function setUrl( $id ) {

        return "http://www.aliexpress.com/item/-/" . $id . ".html";
    }

    /**
     * Get AliExpress request
     *
     * @return array|bool|mixed
     */
    private function request( ) {

        $url 	= $this->params['feedbackServer'] . $this->params['refreshForm'];

        $params = $this->params;

        unset($params['feedbackServer'], $params['refreshForm']);

        $canonicalized_query = array( );

        foreach ( $params as $param => $value ) {

            $param = str_replace( "%7E", "~", rawurlencode( $param ) );
            $value = str_replace( "%7E", "~", rawurlencode( $value ) );
            $canonicalized_query[] = $param . "=" . $value;
        }

        $canonicalized_query = implode( "&", $canonicalized_query );

        $request = $url . '?' . $canonicalized_query;

        $response = $this->request_data( $request );

        if ( $response === false )
            return false;

        return $response;
    }

    /**
     * Get content by method
     *
     * @param $url
     * @return bool|string
     */
    private function request_data( $url ) {

        $request = Requests::get($url);

        if($request->success) {
            return $request->body;
        }

        return false;
    }
}