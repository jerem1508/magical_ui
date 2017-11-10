<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public $email;
    public $pwd;
    public $salt;
    public $created_tmp;
    public $modified_tmp;

    // public function get_last_ten_entries()
    // {
    //         $query = $this->db->get('entries', 10);
    //         return $query->result();
    // }

    public function get_user($email)
    {
        //recuperation des données relative a l'email
        $this->db->select('id, pwd, salt, status');
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }


    public function exist_user($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users');
    }


    public function insert_user($email, $pwd)
    {
        $this->email = $email;
        $this->created_tmp = time();
        $this->modified_tmp = time();

        // MD5
        $this->salt = uniqid();
        $this->pwd = md5($pwd.$this->salt);

        $ret = $this->db->insert('users', $this);
    
        // retour des inkfos a mettre en session
        $this->get_user($email);
    }


    public function update_user()
    {
        $this->title    = $_POST['title'];
        $this->content  = $_POST['content'];
        $this->date     = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }


    public function set_log_users($id_user)
    {
        $data = array(
            'user_id' => $id_user
        );

        return $this->db->insert('log_users', $data);            
    }


}