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
    
    public function login($res = 0)
    {
        $data['page'] = 'login';
        if (!$res)
        {
            $data['errMsg'] = '';
        }
        else
        {
            switch ($res)
            {
                case 1: $data['errMsg'] = 'Wrong password!'; break;
                default: $data['errMsg'] = 'Unknown mistake!';
            }
        }
        $this->load->view('pages/header', $data);
        $this->load->view('pages/login');
        $this->load->view('pages/footer');
    }
    
    public function register($res = 0)
    {
        $data['page'] = 'regist';
        if (!$res)
        {
            $data['errMsg'] = '';
        }
        else
        {
            switch ($res)
            {
                case 1: $data['errMsg'] = 'This username has been registed!'; break;
                case 2: $data['errMsg'] = 'Password mismatch!'; break;
                case 3: $data['errMsg'] = 'Security code illegal!'; break;
                default: $data['errMsg'] = 'Unknown mistake!';
            }
        }
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
            return;
        }
        else
        {
            header('Location:'. base_url(). 'login/1');
            return;
        }
    }
    
    public function do_regist()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');
        $code  = $this->input->post('code');
        
        if (!$this->user_model->checkCode($code))
        {
            header('Location:'. base_url(). 'register/3');
            return;
        }

        if ($password !== $password_confirm)
        {
            header('Location:'. base_url(). 'register/2');
            return;
        }
        
        if (!$this->user_model->checkUsernameAvaliable($userName))
        {
            header('Location:'. base_url(). 'register/1');
            return;
        }
        
        $res = $this->user_model->regist($userName, $password);
        if (!$res)
        {
            header('Location:'. base_url(). 'login/');
            return;
        }
        else
        {
            header('Location:'. base_url(). 'register/'. $res);
            return;
        }
    }
    
}
