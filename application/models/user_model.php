<?php

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    } 
    
    public function login($userName, $password)
    {
        $query = $this->db->from('user')->where('userName', $userName)->where('password', sha1($password))->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            return $query[0];
        }
        else
        {
            return null;
        }
    }
    
    public function regist($userName, $password)
    {
        $data = array(
            'uid'       =>  $this->getUid(),
            'userName'  =>  $userName,
            'password'  =>  sha1($password)
        );
        $this->db->insert('user', $data);
    }
    
    public function getUid()
    {
        $result = $this->db->from('user')->order_by("uid DESC")->limit(1,0)->get()->result_array();
        if (!$result) return 1;
        return $result[0]['uid'] + 1;
    }
    
    public function getUserInfoById($uid)
    {
        $query = $this->db->from('user')->where('uid', $uid)->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            return $query[0];
        }
        else 
        {
            return null;
        }
    }
    
    public function isSuperUser($uid)
    {
        $query = $this->db->from('superUser')->where('uid', $uid)->get();
        return $query->num_rows == 1;
    }
    
    public function checkCode($code)
    {
        $query = $this->db->from('system')->where('item', 'security_code')->get()->result_array();
        $query = $query[0];
        return ($query['val'] == $code);
    }
    
    public function checkUsernameAvaliable($username)
    {
        $query = $this->db->from('user')->where('userName', $username)->get();
        return $query->num_rows == 0;
    }
    
    public function getUserContribution($user = '')
    {
        if (!$user)
        {
            $query = $this->db->from('user')->get();
        }
        else 
        {
            $query = $this->db->from('user')->where('uid', $user)->get();
        }
        if ($query->num_rows)
        {
            $query = $query->result_array();
            for ($i = 0; $i < count($query); $i++)
            {
                $query[$i]['contribution'] = 0;
                $this->db->flush_cache();
                $eids = $this->db->from('markRecord')->where('uid', $query[$i]['uid'])->get();
                if ($eids->num_rows)
                {
                    $eids = $eids->result_array();
                    foreach ($eids as $item)
                    {
                        $this->db->flush_cache();
                        $comp = $this->db->from('example')->where('eid', $item['eid'])->get();
                        $comp = $comp->result_array();
                        $comp = $comp[0]['comp'];
                        $query[$i]['contribution'] = $query[$i]['contribution'] + $comp;
                    }
                }
                //$query[$i]['contribution'] = $this->db->from('markRecord')->where('uid', $query[$i]['uid'])->count_all_results();
            }
            for ($i = 0; $i < count($query) - 1; $i++)
                for ($j = $i + 1; $j < count($query); $j++)
                    if ($query[$i]['contribution'] < $query[$j]['contribution']) {
                        $temp = $query[$i];
                        $query[$i] = $query[$j];
                        $query[$j] = $temp;
                    }
            return $query;
        }
     
        else
        {
            return null;
        }
    }
    
    private function getSummaryContentByEid($eid, $len)
    {
        $query = $this->db->from('example')->where('eid', $eid)->get()->result_array();
        return mb_substr($query[0]['example'], 0, $len);
    }
    
    public function getMarkRecordByUid($uid)
    {
        $query = $this->db->from('markRecord')->where('uid', $uid)->order_by('time', 'DESC')->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            for ($i = 0; $i < count($query); $i++)
            {
                $query[$i]['content'] = $this->getSummaryContentByEid($query[$i]['eid'], 100);
            }
            return $query;
        }    
        else
        {
            return null;
        }
    }
    
}
