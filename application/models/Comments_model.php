<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model {

    public function insert_comment($name='', $email='', $message='', $url='', $project_id=0, $project_type='')
    {
        # Insertion d'un commentaire en base
        $data['name'] = $name;
        $data['email'] = $email;
        $data['message'] = $message;
        $data['url'] = $url;
        $data['project_id'] = $project_id;
        $data['project_type'] = $project_type;

        return $this->db->insert('comments', $data);
    }// /insert_comment()


    public function get_comments()
    {
        //recuperation des données relative a l'email
        $this->db->select('*');
        $query = $this->db->get('comments');

        if ( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        return [];
    }// /get_comments()
}