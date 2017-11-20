<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_model extends CI_Model {

    public $project_id;
    public $user_id;
    public $created_tmp;
    public $modified_tmp;
    public $public_status;


    public function get_project($project_id)
    {
        //recuperation des données relative a l'email
        $this->db->select('project_id, user_id, project_type, public_status, created_tmp, modified_tmp');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get('projects');

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
        return 0;
    }

    public function get_projects($user_id)
    {
        //recuperation des données relative a l'email
        $this->db->select('project_id, user_id, project_type, public_status, created_tmp, modified_tmp');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('projects');

        if ( $query->num_rows() > 0 )
        {
            //$rows = $query->row_array();
            return $query->result_array();
        }
        return [];
    }

    public function exist_project($project_id)
    {
        $this->db->where('project_id', $project_id);
        return $this->db->get('projects');
    }


    public function insert_project($project_id="", $user_id=0, $public_status=0, $project_type="")
    {
        $this->project_id = $project_id;
        $this->user_id = $user_id;
        $this->project_type = $project_type;
        //$this->created_tmp = time();
        //$this->modified_tmp = time();
        $this->public_status = $public_status;

        return $this->db->insert('projects', $this);
    }


    public function delete_project($project_id)
    {
        # Suppression d'un projet

        $this->db->where('project_id', $project_id);
        return $this->db->delete('projects');
    }// /delete_project()


    public function delete_projects($user_id)
    {
        # Suppression des projets de l'utilisateur

        $this->db->where('user_id', $user_id);
        return $this->db->delete('projects');
    }// /delete_projects()
}