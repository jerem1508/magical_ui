<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    public $email;
    public $pwd;
    public $salt;
    public $created_tmp;
    public $modified_tmp;
    public $status;

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
        else {
            return false;
        }
    }// /get_user()


    public function exist_user($email)
    {
        if(!$this->get_user($email)){
            return false;
        }
        else {
            return true;
        }
    }// /exist_user()


    public function insert_user($email, $pwd)
    {
        $this->email = $email;
        $this->created_tmp = time();
        $this->modified_tmp = time();
        $this->status = 0;

        // MD5
        $this->salt = uniqid();
        $this->pwd = md5($pwd.$this->salt);

        $ret = $this->db->insert('users', $this);

        // retour des inkos a mettre en session
        return $this->get_user($email);
    }// /insert_user()


    public function update_status($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);

        return $this->db->update('users');
    }// /update_status()


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
        // MD5
        $salt = uniqid();
        $password = md5($password.$salt);

        $this->db->set('modified_tmp', time());
        $this->db->set('salt', $salt);
        $this->db->set('pwd', $password);
        $this->db->where('email', $email);

        $ret = $this->db->update('users', $data_to_write);
    }// /update_pwd()


    public function delete_user($user_id)
    {# Suppression d'un utilisateur

        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }// /delete_user()
}
