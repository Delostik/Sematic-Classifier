<?php

class Corpus_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    private function trimall($str)
    {
        $qian=array(" ","　","\t","\n","\r");
        $hou=array("","","","","");
        return str_replace($qian, $hou, $str);
    }
    
    public function getOverall()
    {
        $data = array(
            'marked'      => 0,
            'processing'  => 0,
            'notyet'      => 0,
            'comments'    => 0
        );
        $data['marked'] = $this->db->from('result')->where('res !=', 0)->count_all_results();
        $this->db->flush_cache();
        $data['processing'] = $this->db->from('result')->where('res =', 0)->where('subj + obj + neutral !=', 0)->count_all_results();
        $this->db->flush_cache();
        $data['notyet'] = $this->db->from('result')->where('subj + obj + neutral =', 0)->count_all_results();
        $this->db->flush_cache();
        $data['comments'] = $this->db->from('example')->get()->num_rows;
        return $data;
    }
    
    public function getOverallDetail()
    {
        $data = array(
            'all'       => 0,
            'subj'      => 0,
            'neutral'   => 0,
            'obj'       => 0,
            'unknow'    => 0
        );
        $data['all'] = $this->db->from('result')->count_all_results();
        $this->db->flush_cache();
        $data['subj'] = $this->db->from('result')->where('res', 1)->count_all_results();
        $this->db->flush_cache();
        $data['neutral'] = $this->db->from('result')->where('res', 2)->count_all_results();
        $this->db->flush_cache();
        $data['obj'] = $this->db->from('result')->where('res', 3)->count_all_results();
        $this->db->flush_cache();
        $data['unknow'] = $this->db->from('result')->where('res', 0)->count_all_results();
        return $data;
    }
    
    public function getEid()
    {
        $query = $this->db->from('example')->limit(1, 0)->order_by('eid', 'DESC')->get();
        if (!$query->num_rows)
        {
            return 1;
        }
        else
        {
            $query = $query->result_array();
            return $query[0]['eid'] + 1;
        }
    }
    
    public function getRid()
    {
        $query = $this->db->from('result')->limit(1, 0)->order_by('rid', 'DESC')->get();
        if (!$query->num_rows)
        {
            return 1;
        }
        else
        {
            $query = $query->result_array();
            return $query[0]['rid'] + 1;
        }
    }
    
    public function addExample($text)
    {
        //$arr = explode('.', str_replace(array('\n'), '.', $text));
        //$temp = explode('.', $text);
        $temp = explode('.', str_replace(array('\n', '?', '...', '!', '~', ':)'), '.', $text));
        if (!$temp) 
        {
            return false;
        }
        $arr = array();
        $j = 0;
        for ($i = 0; $i < count($temp); $i++)
        {
            if ($temp[$i]) {
                $arr[$j] = $temp[$i];
                $j = $j + 1;
            }
        }
        if ($this->checkExampleExist($text))
        {
            return false;
        }
        $eid = $this->getEid();
        $data = array(
            'eid'       => $eid,
            'example'   => $text,
            'comp'      => $j,
            'marked'    => 0,
            'hash'      => md5($this->trimall($text))
        );
        $this->db->insert('example', $data);
        //print_r($data);
        $rid = $this->getRid();
        foreach ($arr as $row)
        {
            $data = array(
                'rid'       => $rid,
                'eid'       => $eid,
                'content'   => $row,
                'obj'       => 0,
                'subj'      => 0,
                'neutral'   => 0,
                'res'       => 0
            );
            $rid = $rid + 1;
            $this->db->insert('result', $data);
            //print_r($data);
        }
        return true;
    }
    
    private function checkExampleExist($text)
    {
        $hash = md5($this->trimall($text));
        $query = $this->db->from('example')->where('hash', $hash)->get()->num_rows;
        return $query != 0;
    }
    
    public function getMarkNeeded($uid)
    {
        $query = $this->db->from('example')->where('eid not in', "(select eid from markRecord where uid=". $uid. ")", false)->limit(1, 0)->order_by('marked', 'ASC')->get();
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
    
    public function getSentenceByEid($eid)
    {
        $query = $this->db->from('result')->where('eid', $eid)->order_by('rid', 'ASC')->get();
        return $query->result_array();
    }
    
    private function addMark($rid, $stat)
    {
        switch ($stat)
        {
            case 'Subjective' : $this->db->set('subj', 'subj+1', false);
                                break;
            case 'Objective' : $this->db->set('obj', 'obj+1', false);
                                break;
            case 'Neutral'   : $this->db->set('neutral', 'neutral+1', false);
        }
        $this->db->where('rid', $rid)->update('result');
        $this->db->flush_cache();
        $query = $this->db->from('result')->where('rid', $rid)->get()->result_array();
        $query = $query[0];
        if ($query['subj']-$query['obj']>1 && $query['subj']-$query['neutral']>1) $query['res']=1;
        else if ($query['neutral']-$query['obj']>1 && $query['neutral']-$query['subj']>1) $query['res']=2;
        else if ($query['obj']-$query['subj']>1 && $query['obj']-$query['neutral']>1) $query['res']=3;
        $this->db->flush_cache();
        $this->db->where('rid', $rid)->update('result', $query);
    }
    
    public function mark($uid, $eid, $rid, $data)
    {
        $statStr = '';
        for ($i = 0; $i < count($data); $i++)
        {
            $this->addMark($rid + $i, $data[$i]);
            switch ($data[$i])
            {
                case 'Subjective' : $statStr .= '1';
                                    break;
                case 'Objective' : $statStr .= '3';
                                    break;
                case 'Neutral'   : $statStr .= '2';
            }
        }
        date_default_timezone_set('Asia/Shanghai');
        $data = array(
            'uid'   => $uid,
            'eid'   => $eid,
            'stat'  => $statStr,
            'time'  => date('Y-m-d H:i:s')
        );
        $this->db->insert('markRecord', $data);
    }
    
    public function markedByUid($uid, $eid)
    {
        $query = $this->db->from('markRecord')->where('uid', $uid)->where('eid', $eid)->get();
        return $query->num_rows > 0;
    }
    
    public function getResult($type)
    {
        $data = array();
        $this->db->from('result');
        if ($type == 4)
        {
            $this->db->where('res', 0);
        }
        else if ($type)
        {
            $this->db->where('res', $type);
        }
        $query = $this->db->get();
        $data = ($query->num_rows)? $query->result_array(): null;
        return $data;
    }
}