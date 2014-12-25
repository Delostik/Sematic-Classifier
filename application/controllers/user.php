<?php

class User extends CI_Controller {

    private $userInfo;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model', 'corpus_model'));
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
        $data['page'] = 'marking';
        $data['userInfo'] = $this->userInfo;
        $this->load->view('user/header', $data);
        $this->load->view('user/marking');
        $this->load->view('user/footer');
    }
    
    public function result()
    {
        $data['page'] = 'result';
        $data['userInfo'] = $this->userInfo;
        $this->load->view('user/header', $data);
        $this->load->view('user/result');
        $this->load->view('user/footer');
    }
    
    public function example()
    {
        if (!$this->user_model->isSuperUser($this->session->userdata('uid')))
        {
            header('Location:'.base_url(). 'error');
        }
        else
        {
            $data['page'] = 'example';
            $data['userInfo'] = $this->userInfo;
            $data['overall'] = $this->corpus_model->getOverall();
            $this->load->view('user/header', $data);
            $this->load->view('user/example');
            $this->load->view('user/footer');
        }
    }
    
    public function do_addExample()
    {
        if (!$this->user_model->isSuperUser($this->session->userdata('uid')))
        {
            header('Location:'.base_url(). 'error');
        }
        else
        {
            $text = $this->input->post('text');
            $this->corpus_model->addExample($text);
            header('Location:'. base_url(). 'user/example');
        }
    }
    
}
