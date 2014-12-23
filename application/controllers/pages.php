<?php

class Pages extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
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
    
    public function do_regist()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
        $this->user_model->regist($userName, $password);
        header('Location:'. base_url(). 'login');
    }
    
    
}
