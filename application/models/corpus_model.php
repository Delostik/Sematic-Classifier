<?php

class Corpus_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
        $arr = array();
        $j = 0;
        for ($i = 0; $i < count($temp); $i++)
        {
            if ($temp[$i]) {
                $arr[$j] = $temp[$i];
                $j = $j + 1;
            }
        }
        $eid = $this->getEid();
        $data = array(
            'eid'       => $eid,
            'example'   => $text,
            'comp'      => $j,
            'marked'    => 0
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
    
}