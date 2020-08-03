<?php

class General_model extends CI_Model
{
    function database_install()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `banned` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `avatar` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `static_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `settings` (
  `val` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `val` (`val`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `image` text,
  `text` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_result_overall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `question_count` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `correct_questions` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_result_by_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `correct` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL DEFAULT '0',
  `correct` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `image` text NOT NULL,
  `text` text NOT NULL,
  `source` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_friend_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `choosen_answer` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '0',
  `featured` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `time` int(11) NOT NULL,
  `category` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `preview_image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");


        $this->db->query("CREATE TABLE IF NOT EXISTS `quiz_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `image` text,
  `txt` text,
  `answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

        //add
        $pages = array(
            array(
                'title' => 'Privacy Policy',
                'content' => 'put disclaimer here',
                'slug' => toAscii('Privacy Policy')),
            array(
                'title' => 'Disclaimer',
                'content' => 'put declaimer here',
                'slug'=>toAscii('Disclaimer'),
            ));
        foreach ($pages as $p) {
            $this->add_page($p);
        }
    }

    function get_stats($type)
    {
        switch ($type) {
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

    function get_graph_data($type, $year = null)
    {
        switch ($type) {
            case 'user':
                $year = ($year) ? $year : date('Y');
                $start = strtotime($year . '-01-01');
                $end = strtotime($year . '-12-31');
                $array = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
                $query = $this->db->select('created_at')
                    ->from('users')
                    ->where('created_at >= ', $start)
                    ->where('created_at <= ', $end)
                    ->where('created_at <= ', $end)
                    ->order_by('created_at', 'DESC')
                    ->get();
                $users = $query->result_array();
                foreach ($users as $user) {
                    $m = date('n', $user['created_at']); //month;
                    if (isset($array[$m])) {
                        $array[$m] = $array[$m] + 1;
                    } else {
                        $array[$m] = 1;
                    }
                }
                ksort($array);

                return array_values($array);
                break;

            case 'quiz':
                $year = ($year) ? $year : date('Y');
                $start = strtotime($year . '-01-01');
                $end = strtotime($year . '-12-31');
                $array = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
                $query = $this->db->select('time')
                    ->from('quiz_details')
                    ->where('time >= ', $start)
                    ->where('time <= ', $end)
                    ->where('time <= ', $end)
                    ->order_by('time', 'DESC')
                    ->get();
                $users = $query->result_array();
                foreach ($users as $user) {
                    $m = date('n', $user['time']); //month;
                    if (isset($array[$m])) {
                        $array[$m] = $array[$m] + 1;
                    } else {
                        $array[$m] = 1;
                    }
                }
                ksort($array);

                return array_values($array);
                break;

            case 'participants':
                $year = ($year) ? $year : date('Y');
                $start = strtotime($year . '-01-01');
                $end = strtotime($year . '-12-31');
                $array = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
                $query = $this->db->select('time')
                    ->from('quiz_result_overall')
                    ->where('time >= ', $start)
                    ->where('time <= ', $end)
                    ->where('time <= ', $end)
                    ->order_by('time', 'DESC')
                    ->get();
                $users = $query->result_array();
                foreach ($users as $user) {
                    $m = date('n', $user['time']); //month;
                    if (isset($array[$m])) {
                        $array[$m] = $array[$m] + 1;
                    } else {
                        $array[$m] = 1;
                    }
                }
                ksort($array);

                return array_values($array);
                break;
        }
    }

    function delete_page($id)
    {
        $this->db->delete('static_pages', array('id' => $id));
    }

    function get_pages()
    {
        $query = $this->db->select('*')
            ->from('static_pages')
            ->get();
        return $query->result_array();
    }

    function save_page($data, $id)
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
        //$query = $this->db->query("SELECT * FROM settings");
        $query = $this->db->select('*')
            ->from('settings')
            ->get();
        //return $query->result_array();
        if($query->result_array()){
            foreach ($query->result_array() as $row) {
                $configs[$row['val']] = $row['value'];
            }
        }
        return $configs;
    }

    function save_configs($val, $update = true)
    {
        $configs = array();
        foreach ($val as $key => $value) {
            if ($this->setting_exists($key)) {
                //if ($update) $this->db->query("UPDATE settings SET `value`='{$value}' WHERE `val`='{$key}'");
                if ($update) {
                    $data = array(
                        'value' => $value,
                    );
                    $this->db->where('val', $key);
                    $this->db->update('settings', $data);
                }
            } else {
                $arr['val'] = $key;
                $arr['value'] = $value;
                $this->db->insert('settings', $arr);
                //$this->db->query("INSERT INTO settings (`val`,`value`) VALUES('{$key}', '{$value}')");
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