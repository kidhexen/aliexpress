<?php

class AECSV{

    private $filename;
    private $filepath;

    function __construct( $filename = '' ) {
        $this->filename = $filename;
    }

    function setFilePath( $path ) {
        $this->filepath = $path;
    }
    function setFileName( $filename = '' ) {
        $this->filename = $filename;
    }

    /**
     *
     * ['error'] - if error
     * ['file'] - full path info
     * ['url'] - url to download
     */
    function create_file() {

        return wp_upload_bits( $this->filename, null, '' );
    }

    /**
     * Write content by line
     */
    function write_content( $content = '' ) {

        $p = fopen( $this->filepath, "a+" );

        fwrite( $p, $content . "\r\n" );
        fclose( $p );
    }

    /**
     * @param int $parent
     *
     * @return array
     */
    function list_taxonomy( $parent = 0 ) {

        global $wpdb;

        $args = array('hide_empty' => false);

        if( !is_null($parent) )
            $args['parent'] = $parent;

        $terms = get_terms( 'shopcategory', $args );

        $foo = array();

        if( !empty( $terms ) && !is_wp_error( $terms )  ) {

            foreach ( $terms as $term ) {

                $option_name = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT `option_name` FROM `{$wpdb->options}`
                        WHERE `option_value` = %d AND
                            (`option_name` LIKE 'term_parent-%' OR `option_name` LIKE 'term_child-%')",
                    $term->term_id )
                );

                $parent = $term->parent > 0 ? get_term_by('id', $term->parent, 'shopcategory') : 0;
                $parent = !empty($parent) ? $parent->slug : 0;

                $foo[] = array(
                    'type'          => 'category',
                    'slug'          => $term->slug,
                    'name'          => $term->name,
                    'parent'        => $parent,
                    'option_name'   => $option_name,
                    'term_id'       => $term->term_id

                );

                $too = $this->list_taxonomy( $term->term_id );

                if( $too && is_array($too))
                    $foo = array_merge( $foo, $too );
            }

            return $foo;
        }

        return false;
    }

    function count_products() {

        global $wpdb;

        $count = $wpdb->get_var("SELECT count(`id`) as `con` FROM `{$wpdb->products}` WHERE `post_id` <> 0");

        return !empty($count) ? $count : 0;
    }

    function count_reviews() {

        global $wpdb;

        $count = $wpdb->get_var("SELECT count(`id`) as `con` FROM `{$wpdb->review}`");

        return !empty($count) ? $count : 0;
    }

    function list_product( $limit, $len ) {

        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM `{$wpdb->products}` WHERE `post_id` <> 0 LIMIT %d, %d", $limit, $len)
        );

        if( !$result ) return false;

        $foo = array();

        foreach( $result as $res ) {

            $post = get_post( $res->post_id );
            $terms = wp_get_post_terms( $res->post_id, 'shopcategory' );

            $cats = array();

            foreach( $terms as $term ) {
                $cats[] = $term->slug;
            }

            $description = htmlentities($post->post_content, ENT_QUOTES);

            $foo[] = array(
                'type'                  => 'product',
                'productId'             => $res->productId,
                'title'                 => $post->post_title,
                'description'           => $description,
                'post_status'           => $post->post_status,
                'guid'                  => $post->guid,
                'categoryAE'            => $res->categoryAE,
                'categoryId'            => $res->categoryId,
                'categoryName'          => $res->categoryName,
                'categories'            => implode('::', $cats),
                'keywords'              => $res->keywords,
                'detailUrl'             => $res->detailUrl,
                'imageUrl'              => $res->imageUrl,
                'subImageUrl'           => $res->subImageUrl,
                'attribute'             => $res->attribute,
                'freeShippingCountry'   => $res->freeShippingCountry,
                'availability'          => $res->availability,
                'lotNum'                => $res->lotNum,
                'promotionVolume'       => $res->promotionVolume,
                'packageType'           => $res->packageType,
                'price'                 => $res->price,
                'salePrice'             => $res->salePrice,
                'validTime'             => $res->validTime,
                'productUrl'            => $res->productUrl,
                'evaluateScore'         => $res->evaluateScore,
                'storeName'             => $res->storeName,
                'storeUrl'              => $res->storeUrl,
                'storeUrlAff'           => $res->storeUrlAff
            );
        }

        return $foo;
    }

    function list_review( $limit ) {

        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM `{$wpdb->review}` LIMIT %d, 50", $limit)
        );

        $foo = array();

        foreach( $result as $res ) {

            $product_id = $wpdb->get_var(
                $wpdb->prepare("SELECT `productId` FROM `{$wpdb->products}` WHERE `post_id` = %d", $res->post_id )
            );

            if( empty($product_id) ) continue;

            $foo[] = array(
                'type'      => 'review',
                'productId' => $product_id,
                'name'      => $res->name,
                'feedback'  => htmlentities($res->feedback, ENT_QUOTES),
                'date'      => $res->date,
                'flag'      => $res->flag,
                'star'      => $res->star
            );
        }

        return $foo;
    }

    /**
     * Read and parse big data file
     *
     * @param $im
     *
     * @return int|void
     */
    function import_big_data( $im ) {

        global $wpdb;

        $i = 0;

        if ( ( $handle_f = fopen( $this->filename, "r" ) ) !== FALSE ) {

            ini_set("auto_detect_line_endings", true);

            $count = 0;

            fseek( $handle_f, $im );

            $publ = new AliExpressPublish();

            while ( !feof( $handle_f ) ) {

                $line = fgets( $handle_f/*, 4096 */);

                $item = json_decode($line);

                if (!empty($item)) {

                    try {

                        if( isset($item->type) ) switch($item->type) {

                            case 'category':
                                $term_current = get_term_by('slug', $item->slug, 'shopcategory');
                                if ( empty($term_current) ){

                                    $parents = 0;

                                    if( $item->parent !== '0' ) {

                                        $term_parent = get_term_by('slug', $item->parent, 'shopcategory');

                                        if ($term_parent) {
                                            $parents = $term_parent->term_id;
                                        }
                                    }

                                    wp_insert_term(
                                         $item->name,
                                         'shopcategory',
                                         array(
                                             'slug' => $item->slug,
                                             'parent' => $parents
                                         )
                                     );
                                     update_site_option( $item->option_name, $item->term_id );
                                }
                                break;
                            case 'product':

                                $product_id = $wpdb->get_var(
                                    $wpdb->prepare(
                                        "SELECT `productId` FROM `{$wpdb->products}` WHERE `productId` = %d",
                                        $item->productId)
                                );

                                if( empty($product_id) ) {
                                    $args = $item;
                                    $publ ->PublishedCSV($args);
                                }
                                break;
                            case 'review':

                                $post_id = $wpdb->get_var(
                                    $wpdb->prepare(
                                        "SELECT `post_id` FROM `{$wpdb->products}` WHERE `productId` = %d",
                                        $item->productId
                                    )
                                );

                                if ( !empty($post_id) ) {

                                    $review_info = $wpdb->get_var(
                                        $wpdb->prepare(
                                            "SELECT `id` FROM `{$wpdb->review}`
                                            WHERE `post_id` = %d AND `name` = %s AND `date` = %s",
                                            $post_id, $item->name, $item->date
                                        )
                                    );

                                    if( empty($review_info) ) {
                                        $wpdb->insert(
                                            $wpdb->review,
                                            array(
                                                'post_id'   => $post_id,
                                                'name'      => $item->name,
                                                'feedback'  => html_entity_decode($item->feedback),
                                                'date'      => $item->date,
                                                'flag'      => $item->flag,
                                                'star'      => $item->star
                                            ),
                                            array(
                                                '%d', '%s', '%s', '%s', '%s', '%f'
                                            )
                                        );
                                    }
                                }
                                break;
                        }
                    }
                    catch (Exception $e) {}
                }

                $i++;

                if( $i >= 20 ) {
                    $count = ftell( $handle_f ); //возвращает текущую позицию
                    break 1;
                }
            }

            fclose( $handle_f );

            return $count;
        }
        else{
            return false;
        }
    }

    /**
     * Get max number of lines to end of file
     *
     * @return int|string|void
     */
    function get_number_lines() {

        $count = 0;

        if ( ( $handle_f = fopen( $this->filename, "r" ) ) !== FALSE ) {

            while( fgets($handle_f) ) {
                $count++;
            }

            fclose($handle_f);
        }

        return $count;
    }
}