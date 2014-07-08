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
	 * GET /Public/GetGyms.
	 * 
	 * @return array The namespace's gyms.
	 */
	public function get_gyms() {
		
		$response = wp_remote_get(
			self::URL .
			'/Public/GetGyms' .
			'?namespace='. $this->namespace .
			'&json=true'
		);
		
		$gyms = wp_remote_retrieve_body($response);
		
		return $gyms;
		
	}
	
	
	/**
	 * GET /Public/GetAreas.
	 * 
	 * @param int The gym's ID.
	 * @return array The gyms's areas.
	 */
	public function get_areas($gym_id) {
		
		$response = wp_remote_get(
			self::URL .
			'/Public/GetAreas' .
			'?namespace='. $this->namespace .
			'&json=true' .
			'&gym=' . $gym_id
		);
		
		$areas = wp_remote_retrieve_body($response);
		
		return $areas;
		
	}
	
	
	/**
	 * GET /Public/GetInstructors.
	 * 
	 * @return array The namespace's instructors.
	 */
	public function get_instructors() {
		
		$response = wp_remote_get(
			self::URL .
			'/Public/GetInstructors' .
			'?namespace='. $this->namespace .
			'&json=true'
		);
		
		$instructors = wp_remote_retrieve_body($response);
		
		return $instructors;
		
	}
	
	
	/**
	 * GET /Private/GetClientServices.
	 * 
	 * @param string The client's email.
	 * @return array The client's services.
	 */
	public function get_client_services($email) {
		
		$response = wp_remote_get(
			self::URL .
			'/Private/GetClientServices' .
			'?namespace='. $this->namespace .
			'&json=true' .
			'&email=' . $email
		);
		
		$services = wp_remote_retrieve_body($response);
		
		return $services;
		
	}
	
	
}

?>
