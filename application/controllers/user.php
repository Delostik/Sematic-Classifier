<?php

class User extends CI_Controller {

    private $userInfo;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model', 'corpus_model'));
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'form'));
        
        if (!$this->session->userdata('uid'))
        {
            header('Location:'. base_url(). 'login\2');
            return;
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
        
        if (!$this->session->userdata('uid')) {
            header('Location:'. base_url(). 'login\2');
            return;
        }
        
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
        if (!$this->user_model->isSuperUser($this->session->userdata('uid')))
        {
            header('Location:'.base_url(). 'user/error/deny');
            return;
        }
        
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
            $text = str_replace('**********EXAMPLE END**********', '', $text);
            $text = str_replace('**********EXAMPLE START**********', '', $text);
            if ($this->corpus_model->addExample($text))
            {
                header('Location:'. base_url(). 'user/success/addexample');
                return;
            }
            else 
            {
                header('Location:'. base_url(). 'user/error/exist');
                return;
            }
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
            case 'fileErr': $data['errMsg'] = 'Batch add file failed. Unknow file format.'; break;
            case 'exist': $data['errMsg'] = 'This example already exists!'; break;
            default:        $data['errMsg'] = 'Please login again.';
        }
        $this->load->view('user/header', $data);
        $this->load->view('user/error', $data);
        $this->load->view('user/footer');
    }
    
    public function success($type = '?')
    {
        $data['page'] = 'error';
        $data['userInfo'] = $this->userInfo;
        switch ($type)
        {
            case 'fileOk':    $data['errMsg'] = 'Batch add successfully!'; break;
            case 'addexample':    $data['errMsg'] = 'Example added successfully!'; break;
        }
        $this->load->view('user/header', $data);
        $this->load->view('user/success', $data);
        $this->load->view('user/footer');
    }
    
    public function userlist()
    {
        $data['page'] = 'userlist';
        $data['userInfo'] = $this->userInfo;
        
        // 暂时不引入超级权限管理
        // $data['super'] = $this->user_model->isSuperUser($this->session->userdata('uid'));
        
        $data['users'] = $this->user_model->getUserContribution();
        
        $this->load->view('user/header', $data);
        $this->load->view('user/userlist', $data);
        $this->load->view('user/footer');
    }
    
    public function account()
    {
        $data['page'] = 'account';
        $data['userInfo'] = $this->userInfo;
        
        //$data['markRecord'] = $this->user_model->getMarkRecordByUid($this->session->userdata('uid'));
        
        $this->load->view('user/header', $data);
        $this->load->view('user/account', $data);
        $this->load->view('user/footer');
    }
    
    public function mymark()
    {
        $data['page'] = 'account';
        $data['userInfo'] = $this->userInfo;
        
        $data['markRecord'] = $this->user_model->getMarkRecordByUid($this->session->userdata('uid'));
        $data['contribution'] = $this->user_model->getUserContribution($data['userInfo']['uid']);
        $data['contribution'] = $data['contribution'][0]['contribution'];
        
        $this->load->view('user/header', $data);
        $this->load->view('user/mymark', $data);
        $this->load->view('user/footer');
    }
    
    public function batch()
    {
        $config['upload_path'] = './tmp/';
        $config['encrypt_name'] = true;
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        
        $this->load->library('upload', $config);
        
        if ( !$this->upload->do_upload())
        {
            header('Location:'. base_url(). 'user/error/fileErr');
            return;
        }
        else
        {
            $data = $this->upload->data();
            $data = $this->process_batch($data['full_path']);
             
            header('Location:'. base_url(). 'user/success/fileOk');
        }
    }
    
    private function process_batch($path)
    {
        $cnt = 0;
        $data = file($path);
        $example = '';
        foreach ($data as $line)
        {
            if ($cnt >= 220) break;
            $line = rtrim($line);
            if (strcmp($line, "**********EXAMPLE END**********") == 0)
            {
                $cnt += $this->corpus_model->addExample($example);
            }
            else if (strcmp($line, '**********EXAMPLE START**********') == 0)
            {
                $example = '';
            }
            else
            {
                $example .= $line;
            }
        }
        
    }
    
}
