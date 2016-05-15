<?php

/***************************************************************
*	Class to call API by AliExpress
*	@author Vitaly Kukin
*	@link http://www.yellowduck.me
* 	@version 1.3
* 	Get data from Amazon Affiliate
****************************************************************/

class AliExpressJSONAPI2 {
	
	/**
	* Access Key Id. When you create the App, the AliExpress open platform will generate an appKey and a secretKey.
	* @access private
	* @var string
	*/
	private $AppKey	= "";
   
	/**
	* Api Parameter. Different APIs have different parameters. You need to fill in the parameters when requesting a connector.
	* You Tracking ID
	* @access private
	* @var string
	*/
	private $trackingId = "";
	
	/**
	* Method of connection with AliExpress
	*/
	public $method = AE_METHOD;

	function AliExpressJSONAPI2( $AppKey = "", $trackingId = "" ) { 
		$this->AppKey = $AppKey;
		$this->trackingId = $trackingId;
	}

	/**
	 * Check Error Codes From AliExpress
	 *
	 * @param $response
	 * @param $type
	 *
	 * @return array
	 * @throws Exception
	 */
	private function verifyResponse( $response, $type ) {
		
		if ( !$response )
			throw new Exception( __( "Could not connect to AliExpress", "ae" ) );
			//throw new Exception( print_r($response, true) ); 
		
		else {
		
			switch ( $type ) {
				
				//API ：api.listPromotionProduct
				case 'Products':
					
					if( isset( $response->result ) && isset( $response->errorCode ) && $response->errorCode == '20010000' )
						return ( $response->result );
						
					elseif( isset( $response->errorCode ) && $response->errorCode == '20010000' )
						return ( array( 'notfound' => __('Not found. Change search parameters and try again', 'ae') ) );
						
					elseif( isset( $response->errorCode ) ) {
						
						$errors = $this->pesponseProductsErrors();
						
						$error = isset( $errors[$response->errorCode]['msg'] ) ? 
									$errors[$response->errorCode]['msg'] : 
									__( 'Error code is: ', 'ae' ) . $response->errorCode;
						
						throw new Exception( $error );
					}
					else
						throw new Exception( __( "Error, please try again", 'ae' ) );
					
				break;
				
				//API ：api.getPromotionProductDetail
				case 'ProductDetail':
				
					if( isset( $response->result ) && isset( $response->errorCode ) && $response->errorCode == '20010000' )
						return ( $response->result );
						
					elseif( isset( $response->errorCode ) && $response->errorCode == '20010000' )
						return ( array( 'notfound' => __('Not found. Change search parameters and try again', 'ae') ) );
						
					elseif( isset( $response->errorCode ) ) {
						
						$errors = $this->pesponseProductDetailErrors( );
						
						$error = isset( $errors[$response->errorCode]['msg'] ) ? 
									$errors[$response->errorCode]['msg'] : 
									__( 'Error code is: ', 'ae' ) . $response->errorCode;
									
						throw new Exception( $error );
					}	
					else
						throw new Exception( __( "Error, please try again", 'ae' ) );
					
				break;
				
				//API ：api.getgetPromotionLinks
				case 'PromotionLinks':
				
					if( isset( $response->result ) && isset( $response->errorCode ) && $response->errorCode == '20010000' )
						return ( $response->result );
						
					elseif( isset( $response->errorCode ) && $response->errorCode == '20010000' )
						return ( array( 'notfound' => __('Not found. Change search parameters and try again', 'ae') ) );
						
					elseif( isset( $response->errorCode ) ) {
						
						$errors = $this->pesponsePromotionLinksErrors( );
						
						$error = isset( $errors[$response->errorCode]['msg'] ) ? 
									$errors[$response->errorCode]['msg'] : 
									__( 'Error code is: ', 'ae' ) . $response->errorCode;
									
						throw new Exception( $error );
					}	
					else
						throw new Exception( __( "Error, please try again", 'ae' ) );
					
				break;
			}
		}
	}

	/**
	* Return details of a categories
	* @param int $category_id general of category
	* @return mixed object
	*/
	public function getAllProductsByCat( $category_id, $page = 1, $args = array(), $page_size = 20 ) {
		
		$defaults = array(
            'categoryId' 			=> '',
            'keywords' 				=> '',
            'originalPriceFrom' 	=> '',
            'originalPriceTo' 		=> '',
            'volumeFrom' 			=> '',
            'volumeTo' 				=> '',
            'pageNo' 				=> 1,
            'pageSize' 				=> '20',
            'sort'					=> 'validTimeDown',
            'startCreditScore'		=> '',
            'endCreditScore'		=> '',
            'bigsale'               => '',
            'fields'				=> 'totalResults,productId,productTitle,productUrl,imageUrl,originalPrice,salePrice,discount,evaluateScore,volume,packageType,lotNum,validTime'
        );
		
		$parameters = wp_parse_args( $args, $defaults );
		
		$page = ( $page > 0 ) ? intval($page) : 1;
		
		$parameters["categoryId"] 	= $category_id;
		$parameters["pageNo"] 		= $page;
		$parameters["pageSize"] 	= ($page_size > 0) ? $page_size : 20;
		
		if( empty($parameters['keywords']) ) unset($parameters['keywords']);
		
		if(
			empty($parameters['startCreditScore']) || 
			empty($parameters['endCreditScore']) 
		) unset($parameters['startCreditScore'], $parameters['endCreditScore']);
		
		if( $parameters['bigsale'] != 'y' )
		    unset($parameters['bigsale']);

		if(
			empty($parameters['volumeFrom']) ||
			empty($parameters['volumeTo'])
		) unset($parameters['volumeFrom'], $parameters['volumeTo']);

		if( 
			empty($parameters['originalPriceFrom']) || 
			empty($parameters['originalPriceTo']) 
		) unset($parameters['originalPriceFrom'], $parameters['originalPriceTo']);
		
		$json_response = $this->queryAliExpress( $parameters, 'api.listPromotionProduct' );
		
		return $this->verifyResponse( $json_response, 'Products' );
	}

	/**
	* Return details of products
	* @param array $ids list of products ID
	* @return mixed object
	*/
	public function getAllProductsByIds( array $ids ) {

		if( count($ids) == 0 )
			return array( "notfound" => __("Not found", "ae") );

		$foo = array();

		foreach($ids as $id){
			$args = intval($id);
			$foo[] = $this->getProductDetails( $args );
		}

		return $foo;
	}

	/**
	* Return Product Detail
	* @param int $productId parent category
	* @return mixed object
	*/
	public function getProductDetails( $productId ) {
		
		$parameters = array( 
			"productId" => $productId,
			"fields"	=> "productId,productTitle,productUrl,imageUrl,originalPrice,salePrice,discount,evaluateScore,volume,packageType,lotNum,validTime,storeName,storeUrl"
		);
		
		$json_response = $this->queryAliExpress( $parameters, 'api.getPromotionProductDetail' );

		return $this->verifyResponse( $json_response, 'ProductDetail' );
	}
	
	/**
	* Return Product All Attributes From old version
	* @param int $productId parent category
	* @return mixed object
	*/
	public function getProductDetailsOld( $productId ) {
		
		$parameters = array( "productId" => $productId );
		
		$json_response = $this->queryAliExpress( $parameters, 'api.getPromotionProductDetail', 1 );

		return $this->verifyResponse( $json_response, 'ProductDetail' );
	}
	
	/**
	* Return Promotion Links
	* @param string $urls - List of URLs need to be converted to promotion URLs (limit 50)
	* @return mixed object
	*/
	public function getPromotionLinks( array $urls ) {
		
		$parameters = array( 
			"urls" => implode(',', $urls)
		);
		
		$json_response = $this->queryAliExpress( $parameters, 'api.getPromotionLinks' );

		return $this->verifyResponse( $json_response, 'PromotionLinks' );
	}
	
	/**
	* Query Amazon with the issued parameters
	* @param array $parameters parameters to query around
	* @return objects query response
	*/
	private function queryAliExpress( $parameters, $ApiName, $ver = 2 ) {
		
		return $this->ae_request( $parameters, $ApiName, $ver, $this->AppKey, $this->trackingId );
	}
	
	/**
	* Get AliExpress request
	*/
	private function ae_request( $params, $ApiName, $ver, $AppKey, $trackingId ) {
	
		$method 	= "GET";
		$host 		= "gw.api.alibaba.com";
		$uri 		= "/openapi/param2/" . $ver . "/portals.open/" . $ApiName . '/' . $AppKey . '?trackingId=' . $trackingId;

		ksort( $params );
    
		$canonicalized_query = array( );

		foreach ( $params as $param => $value ) {
			
			$param = str_replace( "%7E", "~", rawurlencode( $param ) );
			$value = str_replace( "%7E", "~", rawurlencode( $value ) );
			$canonicalized_query[] = $param . "=" . $value;
		}
    
		$canonicalized_query = implode( "&", $canonicalized_query );

		/* create request */
		$request = "http://" . $host . $uri . '&' . $canonicalized_query;
		//pr($request);
		$json_response = $this->request_data( $request );
		
		if ( $json_response === false )
			return false;
			
		else {
			/* parse json */
			$parsed_json = json_decode($json_response);
			return ( !$parsed_json ) ? false : $parsed_json;
		}
	}
	
	/**
	*	get content by method
	*/
	function request_data( $request ) {
		/* CURL */
		if( $this->method == 'curl' ) { 
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $request );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
			
			$json_response = curl_exec($ch);
		}
		else
			$json_response = file_get_contents($request);
		
		return $json_response;
	}
	
	/**
	* Return status of a Products errors
	* @return array
	*/
	private function pesponseProductsErrors( ) {
		
		return array(
			'20010000' 		=> array( 'msg' => __('Call succeeds', 'ae'), 'status' => 'success' ),
			'20020000' 		=> array( 'msg' => __('System Error', 'ae'), 'status' => 'fail' ),
			'20030000' 		=> array( 'msg' => __('Unauthorized transfer request', 'ae'), 'status' => 'fail' ),
			'20030010' 		=> array( 'msg' => __('Required parameters', 'ae'), 'status' => 'fail' ),
			'20030020' 		=> array( 'msg' => __('Invalid protocol format', 'ae'), 'status' => 'fail' ),
			'20030030' 		=> array( 'msg' => __('API version input parameter error', 'ae'), 'status' => 'fail' ),
			'20030040' 		=> array( 'msg' => __('API name space input parameter error', 'ae'), 'status' => 'fail' ),
			'20030050' 		=> array( 'msg' => __('API name input parameter error', 'ae'), 'status' => 'fail' ),
			'20030060' 		=> array( 'msg' => __('Fields input parameter error', 'ae'), 'status' => 'fail' ),
			'20030070' 		=> array( 'msg' => __('Keyword input parameter error', 'ae'), 'status' => 'fail' ),
			'20030080' 		=> array( 'msg' => __('Category ID input parameter error', 'ae'), 'status' => 'fail' ),
			'20030090' 		=> array( 'msg' => __('Tracking ID input parameter error', 'ae'), 'status' => 'fail' ),
			'20030100' 		=> array( 'msg' => __('Commission rate input parameter error', 'ae'), 'status' => 'fail' ),
			'20030110' 		=> array( 'msg' => __('Original Price input parameter error', 'ae'), 'status' => 'fail' ),
			'20030120' 		=> array( 'msg' => __('Discount input parameter error', 'ae'), 'status' => 'fail' ),
			'20030130' 		=> array( 'msg' => __('Volume input parameter error', 'ae'), 'status' => 'fail' ),
			'20030140' 		=> array( 'msg' => __('Page number input parameter error', 'ae'), 'status' => 'fail' ),
			'20030150' 		=> array( 'msg' => __('Page size input parameter error', 'ae'), 'status' => 'fail' ),
			'20030160' 		=> array( 'msg' => __('Sort input parameter error', 'ae'), 'status' => 'fail' ),
			'20030170' 		=> array( 'msg' => __('Credit Score input parameter error', 'ae'), 'status' => 'fail' )
		);
	}
	
	/**
	* Return status of a ProductDetail errors
	* @return array
	*/
	private function pesponseProductDetailErrors( ) {
		
		return array(
			'20010000' 		=> array( 'msg' => __('Call succeeds', 'ae'), 'status' => 'success' ),
			'20020000' 		=> array( 'msg' => __('System Error', 'ae'), 'status' => 'fail' ),
			'20030000' 		=> array( 'msg' => __('Unauthorized transfer request', 'ae'), 'status' => 'fail' ),
			'20030010' 		=> array( 'msg' => __('Required parameters', 'ae'), 'status' => 'fail' ),
			'20030020' 		=> array( 'msg' => __('Invalid protocol format', 'ae'), 'status' => 'fail' ),
			'20030030' 		=> array( 'msg' => __('API version input parameter error', 'ae'), 'status' => 'fail' ),
			'20030040' 		=> array( 'msg' => __('API name space input parameter error', 'ae'), 'status' => 'fail' ),
			'20030050' 		=> array( 'msg' => __('API name input parameter error', 'ae'), 'status' => 'fail' ),
			'20030060' 		=> array( 'msg' => __('Fields input parameter error', 'ae'), 'status' => 'fail' ),
			'20030070' 		=> array( 'msg' => __('Product ID input parameter error', 'ae'), 'status' => 'fail' ),
		);
	}
	
	/**
	* Return status of a PromotionLinks errors
	* @return array
	*/
	private function pesponsePromotionLinksErrors( ) {
		
		return array(
			'20010000' 		=> array( 'msg' => __('Call succeeds', 'ae'), 'status' => 'success' ),
			'20020000' 		=> array( 'msg' => __('System Error', 'ae'), 'status' => 'fail' ),
			'20030000' 		=> array( 'msg' => __('Unauthorized transfer request', 'ae'), 'status' => 'fail' ),
			'20030010' 		=> array( 'msg' => __('Required parameters', 'ae'), 'status' => 'fail' ),
			'20030020' 		=> array( 'msg' => __('Invalid protocol format', 'ae'), 'status' => 'fail' ),
			'20030030' 		=> array( 'msg' => __('API version input parameter error', 'ae'), 'status' => 'fail' ),
			'20030040' 		=> array( 'msg' => __('API name space input parameter error', 'ae'), 'status' => 'fail' ),
			'20030050' 		=> array( 'msg' => __('API name input parameter error', 'ae'), 'status' => 'fail' ),
			'20030060' 		=> array( 'msg' => __('Fields input parameter error', 'ae'), 'status' => 'fail' ),
			'20030070' 		=> array( 'msg' => __('Tracking ID input parameter error', 'ae'), 'status' => 'fail' ),
			'20030080' 		=> array( 'msg' => __('URL input parameter error or beyond the maximum number of the URLs', 'ae'), 'status' => 'fail' ),
		);
	}
}