<?php
/**
 * @copyright 2008-2011 沪ICP备09009673号 
 * @todo Eclass Platform PHP5 client
 * @author Huping
 * @version 1.0
 * @created 15:10 2011/6/14
 * For help with this library, contact huping@21campus.cn.
 * 
 * Redistribution and use in source and binary forms, with or without       
 * modification, are permitted provided that the following conditions        
 * are met:                                                                  
 *                                                                           
 * 1. Redistributions of source code must retain the above copyright         
 *    notice, this list of conditions and the following disclaimer.          
 * 2. Redistributions in binary form must reproduce the above copyright      
 *    notice, this list of conditions and the following disclaimer in the    
 *    documentation and/or other materials provided with the distribution. 
 */

if (!function_exists('curl_init')) {
  throw new Exception('Eclass needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Eclass needs the JSON PHP extension.');
}

class Eclass {
	public $api_key;
	public $secret;
	public $session_key;
	public $v;
	public $server_addr;
	public $method;
	public $format = 'json';  //default format

	const TIME_OUT = 5;

	public function __construct($api_key, $secret, $session_key = null) {
		$this->api_key = $api_key;
		$this->secret = $secret;
		$this->v = '1.0';
		$this->last_call_id = 0;
		$this->session_key = $session_key;

		$this->server_addr = 'http://www.21campus.cn/restserver/index.php';
	}

	/**
	 * Returns the requested info fields for the requested set of users.
	 * @param array $uids    An array of user ids
	 * @return array  An array of user objects
	 */
	public function users_getInfo($uids) {
		$params = array ('uids' => $uids );
		return $this->call_method ( 'User.getInfo', $params );
	}
	
	/**
	 * Returns uid for the current session user.
	 * 
	 * @return int  current session user's ID
	 */
	public function users_getLoggedInUser(){
		return $this->call_method ( 'User.getLoggedInUser', array() );
	}
	
	/**
	 * Returns whether or not the user corresponding to the current
	 * session object has the give the app basic authorization.
	 *
	 * @return boolean  true if the user has authorized the app
	 */
	public function users_isAppUser($uid) {
		$params = array();
		if ($uid) {
			$params ['uid'] = $uid;
		}

		return $this->call_method ( 'User.isAppUser', $params );
	}
	
   /**
    * Returns the set of friend lists for the current session user.
    *
    * @return array  An array of friend list objects
    */
	public function friends_getLists() {
		return $this->call_method ( 'User.getFriendLists', array ( ) );
	}
	
	/**
     * Returns the friends id of the current session user.
     *
   	 * @param int $uid   (Optional) Return friends for this user.
     *
     * @return array  An array of friends
     */
    public function friends_get() {
	    $params = array();
	    return $this->call_method('User.getFriend', $params);
	}
	
	/**
	 * Returns Whether or not to comparison of two friends
	 *
	 * @return boolean  true if they are friends
	 */
	public function friends_areFriends($uid1, $uid2){
		 $params = array('uid1'=>$uid1, 'uid2'=>$uid2);
		 return $this->call_method('User.areFriends', $params);
	}
  
	/**
	 * Returns the user's avatar
	 * @param int $uid
	 * @param string $size
	 */
	public function users_getPhoto($uid, $size='s'){
		$size = $size == 'b' ? 0 : 1 ;
		return 'http://www.21campus.cn/weibo/eclassimg/head/u/'.$uid.'/s/'.$size;
	}
	
	/**
     * Validates that a given set of parameters match their signature.
     * Parameters all match a given input prefix, such as "yb_sig".
     *
     * @param $fb_params     an array of all Eclass-sent parameters,
     *                       not including the signature itself
     * @param $expected_sig  the expected result to check against
     */
  	public function verify_signature($yb_params, $expected_sig) {
    	return self::generate_sig($yb_params, $this->secret) == $expected_sig;
  	}
  	
	public function set_returnFormat($format = 'json'){
		$this->format = $format;
	}
	
	public function call_method($method, $params) {
		$data = $this->post_request ( $method, $params );
		$result = $this->convert_result ( $data, $method, $params );

		if (is_array ( $result ) && isset ( $result ['error_code'] )) {
			if (isset ( $result ['error_msg'] )) {
				$error_msg = $result ['error_msg'];
			} else {
				$error_msg = '';
			}
			throw new Exception ( $error_msg, $result ['error_code'] );
		}

		return $result;
	}

	protected function convert_result($data, $method, $params) {
		$is_xml = ($this->format == 'xml');
		return ($is_xml) ? $this->convert_xml_to_result ( $data, $method, $params ) : json_decode ( $data, true );
	}

	protected function convert_xml_to_result($xml, $method, $params) {
		$sxml = simplexml_load_string ( $xml, 'SimpleXMLElement', LIBXML_NOCDATA );
		return self::convert_simplexml_to_array ( $sxml );
	}

	public static function convert_simplexml_to_array($sxml) {
		$arr = array ( );
		if ($sxml) {
			foreach ( $sxml as $k => $v ) {
				if ($sxml ['list']) {
					if (isset ( $v ['key'] )) {
						$arr [( string ) $v ['key']] = self::convert_simplexml_to_array ( $v );
					} else {
						$arr [] = self::convert_simplexml_to_array ( $v );
					}
				} else {
					$arr [$k] = self::convert_simplexml_to_array ( $v );
				}
			}
		}
		if (sizeof ( $arr ) > 0) {
			return $arr;
		} else {
			return ( string ) $sxml;
		}
	}

	private function xml_to_array($xml) {
		$array = ( array ) (simplexml_load_string ( $xml, 'SimpleXMLElement', LIBXML_NOCDATA ));
		foreach ( $array as $key => $item ) {
			$array [$key] = $this->struct_to_array ( ( array ) $item );
		}

		return $array;
	}

	private function struct_to_array($item) {
		if (! is_string ( $item )) {
			$item = ( array ) $item;
			foreach ( $item as $key => $val ) {
				$item [$key] = $this->struct_to_array ( $val );
			}
		}

		return $item;
	}

	public static function generate_sig($params_array, $secret) {
		$str = '';
		ksort ( $params_array );
		foreach ( $params_array as $k => $v ) {
			$str .= "$k=$v";
		}
		$str .= $secret;

		return md5 ( $str );
	}

	public function post_request($method, $params) {
		$this->finalize_params ( $method, $params );
		$post_string = $this->create_post_string ( $method, $params );
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $this->server_addr );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_string );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		//max connect time
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, self::TIME_OUT );
		//max curl execute time
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
		//cache dns 1 hour
		curl_setopt ( $ch, CURLOPT_DNS_CACHE_TIMEOUT, 3600 );
		//renren can get and send data encoding by gzip
		curl_setopt ( $ch, CURLOPT_ENCODING, 'gzip' );

		$cURLVersion = curl_version ();
		$ua = 'PHP-cURL/' . $cURLVersion ['version'] . ' HapyFish-Hi5Rest/1.0';
		curl_setopt ( $ch, CURLOPT_USERAGENT, $ua );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$result = @curl_exec ( $ch );
		$errno = @curl_errno ( $ch );
		$error = @curl_error ( $ch );
		curl_close ( $ch );

		if ($errno != CURLE_OK) {
			throw new Exception ( "HTTP Error: " . $error, $errno );
		}
		return $result;
	}

	private function convert_array_values_to_csv(&$params) {
		foreach ( $params as $key => &$val ) {
			if (is_array ( $val )) {
				$val = implode ( ',', $val );
			}
		}
	}

	private function add_standard_params($method, &$params) {
		$params ['method'] = $method;
		$params ['format'] = $this->format;
		$params ['session_key'] = $this->session_key;
		$params ['api_key'] = $this->api_key;
		$params ['call_id'] = microtime ( true );
		if ($params ['call_id'] <= $this->last_call_id) {
			$params ['call_id'] = $this->last_call_id + 0.001;
		}
		$this->last_call_id = $params ['call_id'];
		if (! isset ( $params ['v'] )) {
			$params ['v'] = $this->v;
		}
	}

	private function finalize_params($method, &$params) {
		$this->add_standard_params ( $method, $params );
		//we need to do this before signing the params
		$this->convert_array_values_to_csv ( $params );
		$params ['sig'] = self::generate_sig ( $params, $this->secret );
	}

	private function create_post_string($method, $params) {
		$post_params = array ( );
		foreach ( $params as $key => &$val ) {
			$post_params [] = $key . '=' . urlencode ( $val );
		}
		return implode ( '&', $post_params );
	}

}