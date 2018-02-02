<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Private_functions {

	public function __construct()
	{
	    $this->CI =& get_instance();
	}

	public function test_server_API($value='')
	{
		# Test du serveur API
		# S'il ne répond pas, affichage de la vue d'erreur
		$ch = curl_init(BASE_API_URL.'/api/ping');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if(curl_exec($ch) === FALSE){
		    //echo 'Erreur Curl : ' . curl_error($ch);
			curl_close($ch);
		    return FALSE;
		}
		else{
			curl_close($ch);
			return TRUE;
		}
	}// /test_server_api()


	public function get_metadata_api($project_type, $project_id)
	{
		# Récupération des métadata d'un projet
		$curl = curl_init();
		$url = BASE_API_URL.'/api/metadata/'.$project_type.'/'.$project_id;

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];

		curl_setopt_array($curl, $opts);

		$response = json_decode(curl_exec($curl), true);

		return $response['metadata'];
	}// /get_metadata_api()


	public function set_tab_steps_by_filename($log)
	{
		$tab = [];
		foreach ($log as $filename => $steps) {
			$t_steps = [];
			foreach ($steps as $step => $values) {
				$t_steps[$step] = ($values['completed'] || $values['skipped']);
			}
			$tab[$filename] = $t_steps;
		}

		return $tab;
	}// /set_tab_steps_by_filename()


	public function get_status($status=0)
	{
		switch ($status) {
			case PROJECT_INACTIVE:
				return 'Inactif';
			case PROJECT_USER_PRIVATE:
				return 'Privé';
			case PROJECT_USER_PUBLIC:
				return 'Public demandé';
			case PROJECT_ADMIN_PUBLIC_KO:
				return 'En cours';
			case PROJECT_ADMIN_PUBLIC_OK:
				return 'Public';
		}
	}// /get_status()


	public function skip_step_api($project_type, $project_id, $file_name, $module_name)
	{
		# Passe a TRUE la variable skipped d'une étape

		// Test du filename, on ne doit pas ecrire sur le MINI
		$file_name_temp = $file_name;
		if(substr($file_name,0,6) === 'MINI__' ){
			$file_name_temp = substr($file_name, 6);
		}

		// Appel cURL
		$url = BASE_API_URL.'/api/set_skip/'.$project_type.'/'.$project_id;

		$postfields = array(
		    'data_params' => array(
				"module_name" => $module_name,
		    	"file_name" => $file_name_temp
			),
			'module_params' => array(
				"skip_value" => true
			)
		);

		// Transformation json
		$postfields = json_encode($postfields);

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-Type: application/json; charset=utf-8"));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

		$return = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($return, true);

		// Test de la reponse
		if(!empty($response["error"])){
			return true;
		}
		return false;
	}// /skip_step()


	public function is_completed_step($step_name, $project_steps, $has_mini)
	{
		$filename = str_replace('MINI__', '', key($project_steps));

	    if($project_steps[$filename]['concat_with_init']==1){
	      	return true;
	    }

		switch ($step_name) {
			case 'INIT':
				return true;
				break;

			case 'add_selected_columns':
			case 'replace_mvs':
			case 'recode_types':
				if($has_mini){
					return $project_steps['MINI__'.$filename][$step_name];
				}
				else{
					return $project_steps[$filename][$step_name];
				}

				break;
			default :
				return false;
		}
	} // /is_completed_step()


	public function get_internal_projects()
	{
		# Récupération des projets internes

		$curl = curl_init();

		$url = BASE_API_URL.'/api/public_projects/normalize';

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];

		curl_setopt_array($curl, $opts);

		$response = json_decode(curl_exec($curl), true);

		return $response;
	}// /get_internal_projects()


	public function delete_project_API($project_type = '', $project_id = '')
	{
		# Suppression d'un projet

		if($project_type == '' || $project_id == ''){
			return false;
		}

		$curl = curl_init();

		$url = BASE_API_URL.'/api/delete/'.$project_type.'/'.$project_id;

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];

		curl_setopt_array($curl, $opts);

		$response = json_decode(curl_exec($curl), true);

		return $response;

	}// /delete_project_API()
}// /Class
