<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Private_functions {

	public function get_metadata_api($project_type, $project_id)
	{		
		$curl = curl_init();
		 
		$url = BASE_API_URL.'/api/metadata/'.$project_type.'/'.$project_id;

		$opts = [
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		];
		 
		curl_setopt_array($curl, $opts);
		 
		$response = json_decode(curl_exec($curl), true);

		return $response['metadata'];
	}

	public function set_tab_steps_by_filename($log)
	{
		$tab = [];

		foreach ($log as $filename => $steps) {
			$t_steps = [];	
			foreach ($steps as $step => $values) {
				$t_steps[$step] = $values['completed'];
			}
			$tab[$filename] = $t_steps;
		}
		return $tab;
	}

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
	}

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
	}





}
