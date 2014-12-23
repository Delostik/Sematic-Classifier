<?php

class Pages extends CI_Controller {

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
    }
    
    public function index()
    {
        
    }
    
}
