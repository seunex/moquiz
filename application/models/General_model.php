<?php

class General_model extends CI_Model
{
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