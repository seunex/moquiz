<?php

class General_model extends CI_Model
{
    function get_stats($type){
        switch ($type){
            case 'user':
                $query = $this->db->select('*')
                    ->from('users')
                    ->order_by('created_at', 'DESC')
                    ->get();
                return count($query->result_array());
                break;
            case 'quiz':
                $query = $this->db->select('*')
                    ->from('quiz_details')
                    ->order_by('time', 'DESC')
                    ->get();
                return count($query->result_array());
                break;

            case 'participants':
                $query = $this->db->select('*')
                    ->from('quiz_result_overall')
                    ->order_by('time', 'DESC')
                    ->get();
                return count($query->result_array());
                break;
        }
    }
    function get_graph_data($type, $year = null){
        switch ($type){
            case 'user':
                $year = ($year) ? $year : date('Y');
                $start = strtotime($year.'-01-01');
                $end = strtotime($year.'-12-31');
                $array = array(1 => 0, 2 => 0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0);
                $query = $this->db->select('created_at')
                    ->from('users')
                    ->where('created_at >= ', $start)
                    ->where('created_at <= ', $end)
                    ->where('created_at <= ', $end)
                    ->order_by('created_at', 'DESC')
                    ->get();
                $users = $query->result_array();
                foreach ($users as $user){
                    $m = date('n',$user['created_at']); //month;
                    if(isset($array[$m])){
                        $array[$m] = $array[$m] + 1;
                    }else{
                        $array[$m] = 1;
                    }
                }
                ksort($array);

                return array_values($array);
                break;

            case 'quiz':
                $year = ($year) ? $year : date('Y');
                $start = strtotime($year.'-01-01');
                $end = strtotime($year.'-12-31');
                $array = array(1 => 0, 2 => 0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0);
                $query = $this->db->select('time')
                    ->from('quiz_details')
                    ->where('time >= ', $start)
                    ->where('time <= ', $end)
                    ->where('time <= ', $end)
                    ->order_by('time', 'DESC')
                    ->get();
                $users = $query->result_array();
                foreach ($users as $user){
                    $m = date('n',$user['time']); //month;
                    if(isset($array[$m])){
                        $array[$m] = $array[$m] + 1;
                    }else{
                        $array[$m] = 1;
                    }
                }
                ksort($array);

                return array_values($array);
                break;

                case 'participants':
                $year = ($year) ? $year : date('Y');
                $start = strtotime($year.'-01-01');
                $end = strtotime($year.'-12-31');
                $array = array(1 => 0, 2 => 0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0);
                $query = $this->db->select('time')
                    ->from('quiz_result_overall')
                    ->where('time >= ', $start)
                    ->where('time <= ', $end)
                    ->where('time <= ', $end)
                    ->order_by('time', 'DESC')
                    ->get();
                $users = $query->result_array();
                foreach ($users as $user){
                    $m = date('n',$user['time']); //month;
                    if(isset($array[$m])){
                        $array[$m] = $array[$m] + 1;
                    }else{
                        $array[$m] = 1;
                    }
                }
                ksort($array);

                return array_values($array);
                break;
        }
    }

    function delete_page($id){
        $this->db->delete('static_pages', array('id' => $id));
    }
    function get_pages()
    {
        $query = $this->db->select('*')
            ->from('static_pages')
            ->get();
        return $query->result_array();
    }

    function save_page($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('static_pages', $data);
    }

    function add_page($data)
    {
        $this->db->insert('static_pages', $data);
        return $this->db->insert_id();
    }

    function get_page($id)
    {
        $this->db->or_where('id', $id);
        $this->db->or_where('slug', $id);
        $query = $this->db->get('static_pages');
        if ($result = $query->result_array()) {
            return $result[0];
        }
        return false;
    }

    function username_exists($str, $update = 0)
    {
        $this->db->where('username', $str);
        if ($update) {
            $this->db->where('id != ', $update);
        }
        return $this->db->get('users')->num_rows();
    }

    function email_exists($email, $update = 0)
    {
        $this->db->where('email_address', $email);
        if ($update) {
            $this->db->where('id != ', $update);
        }
        return $this->db->get('users')->num_rows();
    }

    function setting_exists($key)
    {
        $this->db->where('val', $key);
        $count = $this->db->get('settings')->num_rows();
        if ($count > 0) return true;
        return false;
    }

    function configs()
    {
        $configs = array();
        $query = $this->db->query("SELECT * FROM settings");
        foreach ($query->result() as $row) {
            $configs[$row->val] = $row->value;
        }
        return $configs;
    }

    function save_configs($val, $update = true)
    {
        $configs = array();
        foreach ($val as $key => $value) {
            if ($this->setting_exists($key)) {
                if ($update) $this->db->query("UPDATE settings SET `value`='{$value}' WHERE `val`='{$key}'");
            } else {
                $this->db->query("INSERT INTO settings (`val`,`value`) VALUES('{$key}', '{$value}')");
            }
        }
        return $configs;
    }

    function config($key, $default = null)
    {
        $this->db->where('val', $key);
        if ($this->db->get('settings')->num_rows()) {
            $results = $this->db->result();
            return $results->val;
        } else {
            //insert new
            $this->db->insert('settings', array('val' => $key, 'value' => $default));
            return $default;
        }
    }
}