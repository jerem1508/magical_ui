<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model {

    public function insert_comment($data_to_write)
    {
        # Insertion d'un commentaire en base
        $data['comment'] = $data_to_write['comment'];
        $data['user_id'] = $data_to_write['user_id'];

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