<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public $email;
    public $pwd;
    public $salt;
    public $created_tmp;
    public $modified_tmp;

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
    }// /get_user()


    public function exist_user($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users');
    }// /exist_user()


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
    }// /insert_user()


    public function update_user()
    {
        $this->title    = $_POST['title'];
        $this->content  = $_POST['content'];
        $this->date     = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }// /update_user()


    public function set_log_users($id_user)
    {
        $data = array(
            'user_id' => $id_user
        );

        return $this->db->insert('log_users', $data);            
    }// /set_log_users()


    public function pwd_ok($email, $password)
    {# Test le password

        $user = $this->get_user($email);
        $ret = false;

        // si email trouvé, on compare les mdp
        if($user['id'] != 0){
            $pwd = md5($password.$user['salt']);
            if($pwd == $user['pwd']) {
                $ret = true;
            }
        }
        return $ret;
    }// /pwd_ok()


    public function update_pwd($email, $password)
    {# MAJ du mot de passe

        $this->email = $email;
        $this->modified_tmp = time();

        // MD5
        $this->salt = uniqid();
        $this->pwd = md5($password.$this->salt);

        $ret = $this->db->update('users', $this);
    }// /update_pwd()
}