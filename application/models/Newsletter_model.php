<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_model extends CI_Model {

    public function insert_email($email='')
    {
        # Insertion d'un email en base
        $data['email'] = $email;

        return $this->db->insert('newsletter', $data);
    }// /insert_email()
}
