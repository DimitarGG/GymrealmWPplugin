<?php // ѣ
/**
 * Definition of the GymRealm_Api class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */


class GymRealm_Api {
	
	const URL = 'http://9ecf2e2fb475475aa8898caf29e0d105.cloudapp.net/Api/Public/';
	
	protected $curl = null;
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		$this->curl = curl_init(self::URL);
		
	}
	
	
}

?>
