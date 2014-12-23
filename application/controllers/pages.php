<?php

class Pages extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array());
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        
        if ($this->session->userdata('uid'))
        {
            header('Location:'. base_url(). 'user');
        }
    }
    
    public function index()
    {
        $data['page'] = 'index';
        $this->load->view('pages/header', $data);
        $this->load->view('pages/index');
        $this->load->view('pages/footer');
    }
    
    public function login() 
    {
        $data['page'] = 'login';
        $this->load->view('pages/header', $data);
        $this->load->view('pages/login');
        $this->load->view('pages/footer');
    }
    
    public function register()
    {
        $data['page'] = 'regist';
        $this->load->view('pages/header', $data);
        $this->load->view('pages/register');
        $this->load->view('pages/footer');
    }
    
    public function do_login()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
    
        $query = $this->user_model->login($userName, $password);
    
        if ($query)
        {
            $this->session->set_userdata('uid', $query['uid']);
            header('Location:'. base_url(). "user");
        }
        else
        {
            echo "False";
        }
    }
    
    public function getUid()
    {
        $result = $this->db->from('user')->order_by("uid DESC")->limit(1,0)->get()->result_array();
        if (!$result) return 1;
        return $result[0]['uid'] + 1;
    }
    
    public function do_register()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
    
        $data = array(
            'uid'       =>  $this->getUid(),
            'userName'  =>  $userName,
            'password'  =>  sha1($password),
            'userType'  =>  1
        );
        $this->db->insert('user', $data);
        header('Location:'. base_url(). 'login');
    }
    
}
