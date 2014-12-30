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
        $data['overall'] = $this->corpus_model->getOverall();
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
        $data['example'] = $this->corpus_model->getMarkNeeded($this->session->userdata('uid'));
        
        if (!$data['example'])
        {
            $data['errMsg'] = 'No more examples :)';
            $this->load->view('user/header', $data);
            $this->load->view('user/error');
            $this->load->view('user/footer');
            return;
        }
        
        $data['sentences'] = $this->corpus_model->getSentenceByEid($data['example']['eid']);
        
        $this->load->view('user/header', $data);
        $this->load->view('user/marking');
        $this->load->view('user/footer');
    }
    
    public function result($type = 0)
    {
        $data['page'] = 'result';
        $data['userInfo'] = $this->userInfo; 
        $data['result'] = $this->corpus_model->getResult($type);
        $data['type'] = $type;
        $data['overall'] = $this->corpus_model->getOverallDetail();
        $this->load->view('user/header', $data);
        $this->load->view('user/result');
        $this->load->view('user/footer');
    }
    
    public function example()
    {
        if (!$this->user_model->isSuperUser($this->session->userdata('uid')))
        {
            header('Location:'.base_url(). 'user/error/deny');
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
            header('Location:'.base_url(). 'user/error');
        }
        else
        {
            $text = $this->input->post('text');
            $this->corpus_model->addExample($text);
            header('Location:'. base_url(). 'user/example');
        }
    }
    
    public function do_marking()
    {
        $data = $this->input->post('data');
        $rid  = $this->input->post('rid');
        $eid  = $this->input->post('eid');
        $uid = $this->session->userdata('uid');
        if (!$this->corpus_model->markedByUid($uid, $eid))
        {
            $this->corpus_model->mark($uid, $eid, $rid, $data);
            echo "done";
        }
        else
        {
            echo 'already';
        }
    }
    
    public function error($type = '?')
    {
        $data['page'] = 'error';
        $data['userInfo'] = $this->userInfo;
        switch ($type)
        {
            case 'deny':    $data['errMsg'] = 'You have no permission to view this page.'; break;
            default:        $data['errMsg'] = 'Unknow error. Please contant administrator.';
        }
        $this->load->view('user/header', $data);
        $this->load->view('user/error', $data);
        $this->load->view('user/footer');
    }
    
    public function userlist()
    {
        $data['page'] = 'userlist';
        $data['userInfo'] = $this->userInfo;
        $data['super'] = $this->user_model->isSuperUser($this->session->userdata('uid'));
        
        $data['users'] = $this->user_model->getUserContribution();
        
        $this->load->view('user/header', $data);
        $this->load->view('user/userlist', $data);
        $this->load->view('user/footer');
    }
    
}
