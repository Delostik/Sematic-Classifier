<?php

class User extends CI_Controller {

    private $userInfo;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        
        if (!$this->session->userdata('uid'))
        {
            header('Location:'. base_url(). 'login\errNoLogin');
        }
        
        $this->userInfo = $this->user_model->getUserInfoById($this->session->userdata('uid'));
    }
    
    public function index()
    {
        $data['page'] = 'index';
        $data['userInfo'] = $this->userInfo; 
        $this->load->view('user/header', $data);
        $this->load->view('user/index');
        $this->load->view('user/footer');
    }
    
    public function logout()
    {
        $this->session->unset_userdata('uid');
        header('Location:'. base_url());
    }
    
    public function marking()
    {
        $this->load->view('user/header', $data);
        $this->load->view('user/marking');
        $this->load->view('user/footer');
    }
    
    public function result()
    {
        $this->load->view('user/header', $data);
        $this->load->view('user/result');
        $this->load->view('user/footer');
    }
    
}
