<?php // ѣ
/**
 * Definition of the GymRealm_Api class.
 * 
 * All the API methods can throw an error, so you better catch them!
 * 
 * @author pavelsof
 * @package GymRealm
 * @since 0.0.1
 */


class GymRealm_Api {
	
	//const URL = 'http://9ecf2e2fb475475aa8898caf29e0d105.cloudapp.net/Api';
	const URL = 'http://gymrealmmanager.cloudapp.net/Api';
	
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
		
		if(wp_remote_retrieve_response_code($response) == 200) {
			$gyms = wp_remote_retrieve_body($response);
			return json_decode($gyms);
		} else {
			throw new Exception(__("You are not connected to GymRealm API.", 'gymrealm'));
		}
		
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
			'&GymID=' . $gym_id
		);
		
		if(wp_remote_retrieve_response_code($response) == 200) {
			$areas = wp_remote_retrieve_body($response);
			return json_decode($areas);
		} else {
			throw new Exception(__("You are not connected to GymRealm API.", 'gymrealm'));
		}
		
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
		
		if(wp_remote_retrieve_response_code($response) == 200) {
			$instructors = wp_remote_retrieve_body($response);
			return json_decode($instructors);
		} else {
			throw new Exception(__("You are not connected to GymRealm API.", 'gymrealm'));
		}
		
	}
	
	
	/**
	 * GET /Public/GetVisits.
	 * 
	 * @return array The namespace's visits.
	 */
	public function get_visits() {
		
		$response = wp_remote_get(
			self::URL .
			'/Public/GetVisits' .
			'?namespace='. $this->namespace .
			'&json=true'
		);
		
		if(wp_remote_retrieve_response_code($response) == 200) {
			$visits = wp_remote_retrieve_body($response);
			return json_decode($visits);
		} else {
			throw new Exception(__("You are not connected to GymRealm API.", 'gymrealm'));
		}
		
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
		
		if(wp_remote_retrieve_response_code($response) == 200) {
			$services = wp_remote_retrieve_body($response);
			return json_decode($services);
		} else {
			$text  = "You have no active services or you are registered with another email in Gym Realm Manager. ";
			$text .= "For any enquiries please contact PHG team. Thank you!";
			throw new Exception(__($text, 'gymrealm'));
		}
		
	}
	
	
	/**
	 * POST /Private/BookSchedule.
	 * 
	 * @param array The arguments needed.
	 * @return bool Successful/unsuccessful.
	 */
	public function post_book_schedule($args) {
		
		$post_data = array();
		$post_data['namespace'] = $this->namespace;
		
		$post_data['AreaID'] = $args['area'];
		$post_data['Datetime'] = $args['datetime'];
		$post_data['Duration'] = $args['duration'];
		$post_data['Email'] = $args['email'];
		$post_data['GymID'] = $args['gym'];
		$post_data['Telephone'] = $args['phone'];
		$post_data['Text'] = isset($args['comment']) ? $args['comment'] : "";
		
		if(isset($args['instructor'])) $post_data['InstructorID'] = $args['instructor'];
		if(isset($args['visit'])) $post_data['VisitID'] = $args['visit'];
		
		$response = wp_remote_post(
			self::URL .
			'/Private/BookSchedule',
			array(
				'body'	=>	$post_data
			)
		);
		
		$code = wp_remote_retrieve_response_code($response);
		
		if($code == 200) {
			return true;
		} else {
			return false;
		}
		
	}
	
	
}

?>
