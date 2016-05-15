<?php

include_once dirname(__FILE__) . '/libs/HttpClient.php';

class GoogleTranslate extends HttpClient 
{
	private $_service_url = 'http://translate.google.com/translate_a/t';
	private $_params = array(
		'client' => 'x',
		'text'   => '',
		'hl'     => '',
		'sl'     => '',
		'tl'     => '',
		'format' => 'html',
		'ie'     => 'UTF-8',
		'oe'     => 'UTF-8',
	);
	private $_tags = array();
	private $_maxlenght = 540;
	private $_text = array();
	private $_error = array();

	public function __construct($params = array())
	{
		$this->_params = array_merge($this->_params, $params);
		$this->_error['error'] = false;
		$this->_error['message'] = array();
	}

	public function setFromLang($lang) 
	{
		$this->_params['hl'] = $lang;
		$this->_params['sl'] = $lang;

		return $this;
	}

	public function setToLang($lang) 
	{
		$this->_params['tl'] = $lang;

		return $this;
	}

	public function translate($words) 
	{
		return $this->_translate($words);
	}

	public function isError()
	{
		return $this->_error['error'];
	}

	public function getError()
	{
		return $this->_error;
	}

	protected function _translate($words) 
	{
		if(strlen($words) > $this->_maxlenght) {
			$wordwrap = wordwrap($words, $this->_maxlenght, '[break]');
			$this->_text = explode('[break]', $wordwrap);
		} else {
			$this->_text[0] = $words;
		}

		$res = '';
		foreach($this->_text as $word) {
			$this->_params['text'] = $word;
			$T = $this->get($this->_service_url, $this->_params);;

			if($T) {
				$res .= $T;
			} else {
				$res .= '[Error]';
				$this->_error['error'] = true;
				array_push($this->_error['message'], array(
					'string' => $this->_params['text'],
					'error' => 'Response from the server 404 or not valid response json'
				));
			}
		}

		return $res;
	}
}