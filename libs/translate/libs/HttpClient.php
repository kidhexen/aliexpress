<?php

class HttpClient 
{
	public function __construct(){}

	/**
	*	This function http get request
	*	@param: String $url - url address;
	*	@param: Array $params - url params;
	*	@return: String || false;
	*/
	public function get($url, $params = array()) 
	{	
		$headers = array();
		$options = array('useragent' => '');
		$request = Requests::post($url, $headers, $params, $options);

		if($request->success) {
			$request = json_decode($request->body);

			if(isset($request->sentences[0])) {
				return $request->sentences[0]->trans;
			}			
		}

		return false;
	}
}