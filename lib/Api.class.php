<?php // ѣ
/**
 * Definition of the GymRealm_Api class.
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */


class GymRealm_Api {
	
	const URL = 'http://9ecf2e2fb475475aa8898caf29e0d105.cloudapp.net/Api';
	
	protected $namespace = null;
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
		$this->namespace = get_option(GymRealm_Plugin::OPTION_NAMESPACE, '');
		
	}
	
	
	/**
	 * GET /Private/GetClientServices.
	 * 
	 * @param string The client's email.
	 * @return array The client's services.
	 */
	public function get_client_services($email) {
		
		$response = wp_remote_request(
			self::URL .
			'/Private/GetClientServices?namespace='. $this->namespace .'&json=true'
		);
		
	}
	
	
}

?>
