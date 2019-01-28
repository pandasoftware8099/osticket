<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_agents_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');
    }


    public function agents_agents()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $deparment_info = $this->db->query("SELECT department_guid FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_info->department_guid."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->department_guid);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

            $data = array(
                'agent' => $this->db->query("SELECT * FROM ost_staff_test INNER JOIN ost_department_test ON ost_staff_test.dept_guid = ost_department_test.department_guid"),
                'department' => $depart_name,
                'role' => $this->db->query("SELECT * FROM ost_role_test"),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_agents', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_agents_process()

    {   $tids = $this->input->post('tids[]');
        $status = $this->input->post('status');
        $perms = $this->input->post('perms[]');
        $perms = implode(", ", $perms);




          if ($status == 0 || $status == 1) {

            foreach ($tids as $value) {

            $this->db->query("UPDATE ost_staff_test
                            SET isactive = '$status'
                            WHERE staff_guid = '$value'");
        }

            echo "<script> alert('Status of agent/s changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($tids as $value) {

            $this->db->query("DELETE FROM ost_staff_test WHERE staff_guid='$value' ");;
            $this->db->query("DELETE FROM ost_staff_dept_access_test WHERE staff_guid='$value' ");

            
        }
            echo "<script> alert('Agent/s deleted');</script>";
        }

        elseif ($status == 3) {
            foreach ($tids as $value) {

            $this->db->query("UPDATE ost_staff_test

                            SET 
                            permissions = '$perms'

                                
                            WHERE staff_guid = '$value' ;");

            
        }
            echo "<script> alert('Agent/s permission changed');</script>";
        }

        elseif ($status == 4) {

            if ($maintaindept == 1) {

                foreach ($tids as $value) 

                    {
                
                $staffdept = $this->db->query("SELECT dept_guid FROM ost_staff_test WHERE staff_guid = '$value' ")->row('dept_guid');
                $roledept = $this->db->query("SELECT role_guid FROM ost_staff_test WHERE staff_guid = '$value' ")->row('role_guid');

                $this->db->query("DELETE FROM ost_staff_dept_access_test WHERE staff_guid='$value' AND dept_guid = '$dept_guid' ");

                $this->db->query("UPDATE ost_staff_test SET dept_guid = '$dept_guid', role_guid = '$role_guid' WHERE staff_guid = '$value';");

                $this->db->query("INSERT INTO ost_staff_dept_access_test (staff_guid, dept_guid, role_guid) VALUES 
                    ('$value', '$staffdept', '$roledept') ");

                    }

            }

            else {

                foreach ($tids as $value) 

                    {

                $this->db->query("UPDATE ost_staff_test

                            SET 
                            dept_guid = '$dept_guid', 
                            role_guid = '$role_guid'
                                
                            WHERE staff_guid = '$value' ;");

            
                    }
                }
            
            echo "<script> alert('Agent/s department changed');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents' </script>";

    }

    public function agents_agents_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $deparment_info = $this->db->query("SELECT department_guid FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_info->department_guid."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->department_guid);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

            $data = array(

                'department' => $depart_name,
                'department_email' => $this->db->query("SELECT email_guid, email FROM ost_email_test"),
                'role' => $this->db->query("SELECT * FROM ost_role_test"),
                'role1' => $this->db->query("SELECT * FROM ost_role_test"),
                'role2' => $this->db->query("SELECT * FROM ost_role_test"),
                'team' => $this->db->query("SELECT * FROM ost_team_test"),

            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_agents_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_agents_add_process()

    {   $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $phone_ext = $this->input->post('phone_ext');
        $mobile = $this->input->post('mobile');

        $sendreset = $this->input->post('_field-checkboxes');
        $password1 = $this->input->post('password1');
        $password2 = $this->input->post('password2');
        $change_passwd = $this->input->post('change_passwd');

        $username = $this->input->post('username');
        $islocked = $this->input->post('islocked');
        $isadmin = $this->input->post('isadmin');
        $assigned_only = $this->input->post('assigned_only');
        $onvacation = $this->input->post('onvacation');
        $notes = $this->input->post('notes');
        $dept_guid = $this->input->post('dept_guid');
        $role_guid = $this->input->post('role_guid');
        $ext_role_guid = $this->input->post('ext_role_guid[]');
        $ext_dept_guid = $this->input->post('ext_dept_guid[]');
        $dept_access_alerts = $this->input->post('dept_access_alerts[]');
        $perms = $this->input->post('perms[]');
        $perms = implode(", ", $perms);
        $passwdreset = $this->db->query("SELECT value FROM ost_config_test WHERE id = '17'")->row('value');
        $getDate = date('Y-m-d');
        $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +".$passwdreset." months");
        $expiry_date = date('Y-m-d',$getDate);

        $team = $this->input->post('teams[]');

        array_shift($ext_role_guid);

        $emailcheck = $this->db->query("SELECT * FROM ost_staff_test WHERE email = '$email' ");
        $namecheck = $this->db->query("SELECT * FROM ost_staff_test WHERE username = '$username' ");

        if ($emailcheck->num_rows() !== 0){

            echo "<script> alert('Email duplicated');</script>";

            echo "<script>
                document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add'
                </script>";
        }

        else if ($namecheck->num_rows() !== 0){

            echo "<script> alert('Username duplicated');</script>";


            echo "<script>
                document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add'
                </script>";
        }

        else if (isset($ext_dept_guid) && in_array($dept_guid, $ext_dept_guid)){

                 echo "<script> alert('Extended department cannot be the same with primary department');</script>";


                echo "<script>
                    document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add'
                    </script>";

            
        }

        else if ($role_guid == '0') {

            echo "<script> alert('Primary Department role cannot leave blank');</script>";


            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add' </script>";

        }

         else if (in_array(0, $ext_role_guid)) {

            echo "<script> alert('Extended Department role cannot leave blank');</script>";


            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add' </script>";

        }

        else if($sendreset == '1') {

            $token_life = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='107'")->row('value');
            $expiretime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$token_life minutes"));
            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $this->db->query("INSERT INTO 
            ost_staff_test (staff_guid, firstname, lastname, email, phone, phone_ext, mobile, username, isactive, isadmin, assigned_only, change_passwd, onvacation, notes, dept_guid, role_guid, user_created, permissions, token, token_expire, updated, passwdreset)
            VALUES 
            (REPLACE(UPPER(UUID()),'-',''), '$firstname', '$lastname', '$email', '$phone', '$phone_ext', '$mobile', '$username', '$islocked', '$isadmin', '$assigned_only', '$change_passwd', '$onvacation', '$notes','$dept_guid', '$role_guid', NOW(), '$perms', '$token', '$expiretime', NOW(), '$expiry_date')");

            $result = $this->db->query("SELECT * FROM ost_staff_test WHERE email = '$email'");

            $data = array(
                'body' => $this->db->query("SELECT REPLACE(REPLACE(REPLACE(body, '%firstname%', '".$result->row('firstname')."'), '%token%', '$token'), '%staff_guid%', '".$result->row('staff_guid')."') AS email, name FROM ost_content_test WHERE type = 'pwreset-staff'"),
                'template' => $this->db->query("SELECT * FROM ost_company_test"),
            );

            $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
            $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$default_email'")->row();

            $config = array(
                
                'smtp_user' => $sender_email->userid,
                'smtp_pass' => $sender_email->userpass,
                'smtp_host' => $sender_email->smtp_host,
                'smtp_port' => $sender_email->smtp_port,
                                
            );

            $bodyContent = $this->load->view('email_template', $data, TRUE);
            $result = $this->email
                ->initialize($config)
                ->from($sender_email->userid)
                ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
                ->to($email)
                ->subject($data['body']->row('name'))
                ->message($bodyContent)
                ->send();

            $staff_guid = $this->db->query("SELECT staff_guid FROM ost_staff_test WHERE user_created = NOW()")->row('staff_guid');

            if (isset($team))
            {
                foreach ($team as $value) {
                    $this->db->query("INSERT INTO 
                    ost_team_member_test (team_guid, staff_guid)
                    VALUES 
                    ('$value', '$staff_guid') ");
                }
            }

            foreach ( $ext_role_guid as $index => $ext_role_guid1 ) 
            {
                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$staff_guid', '$ext_dept_guid[$index]', '$ext_role_guid1') ");
            }

            echo "<script> alert('Successfully add agents');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents' </script>";
        }

        elseif ($sendreset != '1') {

            if ($password1 != $password2){

            echo "<script> alert('Confirm password wrong');</script>";

            echo "<script>
                document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add'
              </script>";
        }

        else {
            $this->db->query("INSERT INTO 
            ost_staff_test (staff_guid, firstname, lastname, passwd,  email, phone, phone_ext, mobile, username, isactive, isadmin, assigned_only, change_passwd, onvacation, notes, dept_guid, role_guid, permissions, user_created, updated, passwdreset)
            VALUES 
            (REPLACE(UPPER(UUID()),'-',''), '$firstname', '$lastname', '$password2', '$email', '$phone', '$phone_ext', '$mobile', '$username', '$islocked', '$isadmin', '$assigned_only', '$change_passwd', '$onvacation', '$notes','$dept_guid', '$role_guid', '$perms', NOW(), NOW(), '$expiry_date')");

            $staff_guid = $this->db->query("SELECT staff_guid FROM ost_staff_test WHERE user_created = NOW()")->row('staff_guid');


            if ($team != '') {
                foreach ($team as $value) {
                    $this->db->query("INSERT INTO 
                    ost_team_member_test (team_guid, staff_guid)
                    VALUES 
                    ('$value', '$staff_guid') ");
                }
            }
                
            foreach ( $ext_role_guid as $index => $ext_role_guid1 ) 

            {
            
                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$staff_guid', '$ext_dept_guid[$index]', '$ext_role_guid1') ");

            }

            echo "<script> alert('Successfully add agents');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents' </script>";
        
            }
        }

    }

    public function agents_agents_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $deparment_info = $this->db->query("SELECT department_guid FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_info->department_guid."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->department_guid);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

           $staffid = $_REQUEST['id'];
            $data = array(

                'department' => $depart_name,
                'department_email' => $this->db->query("SELECT email_guid, email FROM ost_email_test"),
                'role' => $this->db->query("SELECT * FROM ost_role_test"),
                'team' => $this->db->query("SELECT * FROM ost_team_test"),
                'team1' => $this->db->query("SELECT * FROM ost_team_test WHERE team_guid NOT IN (SELECT ost_team_test.team_guid FROM ost_team_test INNER JOIN ost_team_member_test ON ost_team_test.team_guid = ost_team_member_test.team_guid WHERE staff_guid = '$staffid')"),
                'staffinfo' => $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' ")->row(),
                'staffpermissions' => $this->db->query("SELECT * FROM ost_staff_permissions_test WHERE staff_guid = '$staffid' ")->row(),
                'staffextdept' => $this->db->query("SELECT * FROM ost_staff_dept_access_test INNER JOIN ost_department_test ON ost_staff_dept_access_test.dept_guid = ost_department_test.department_guid WHERE staff_guid = '$staffid' "),
                'staffteam' => $this->db->query("SELECT * FROM ost_team_member_test INNER JOIN ost_team_test ON ost_team_member_test.team_guid = ost_team_test.team_guid WHERE staff_guid = '$staffid' "),
                'adduserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%user.add%'")->num_rows(),
                'edituserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%user.edit%'")->num_rows(),
                'deleteuserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%user.delete%'")->num_rows(),
                'activeallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%user.manage%'")->num_rows(),
                'dirallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%user.dir%'")->num_rows(),
                'addorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%org.create%'")->num_rows(),
                'editorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%org.edit%'")->num_rows(),
                'deleteorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%org.delete%'")->num_rows(),
                'managefaqallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%faq.manage%'")->num_rows(),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_agents_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_agents_info_process()
    {   
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $phone_ext = $this->input->post('phone_ext');
        $mobile = $this->input->post('mobile');

        $sendreset = $this->input->post('_field-checkboxes');
        $password1 = $this->input->post('password1');
        $password2 = $this->input->post('password2');
        $change_passwd = $this->input->post('change_passwd');

        $username = $this->input->post('username');
        $islocked = $this->input->post('islocked');
        $isadmin = $this->input->post('isadmin');
        $assigned_only = $this->input->post('assigned_only');
        $onvacation = $this->input->post('onvacation');
        $notes = $this->input->post('notes');
        $dept_guid = $this->input->post('dept_guid');
        $role_guid = $this->input->post('role_guid');
        $ext_role_guid = $this->input->post('ext_role_guid[]');
        $ext_dept_guid = $this->input->post('ext_dept_guid[]');
        $dept_access_alerts = $this->input->post('dept_access_alerts[]');
        $perms = !empty($this->input->post('perms[]'))?"".implode(", ", $this->input->post('perms[]'))."":"";
        $team = $this->input->post('teams[]');
       $staffid = $_REQUEST['id'];

        array_shift($ext_role_guid);

        $emailcheck = $this->db->query("SELECT * FROM ost_staff_test WHERE email = '$email' AND staff_guid != '$staffid' ");
        $namecheck = $this->db->query("SELECT * FROM ost_staff_test WHERE username = '$username' AND staff_guid != '$staffid' ");

        if ($emailcheck->num_rows() != 0){

            echo "<script> alert('Email duplicated');</script>";

            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";

        }

        else if ($namecheck->num_rows() != 0){

            echo "<script> alert('Username duplicated');</script>";

            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";

        }        

        else if (isset($ext_dept_guid) && in_array($dept_guid, $ext_dept_guid))
        {

            echo "<script> alert('Extended department cannot be the same with primary department');</script>";

            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";
        }

        else if (in_array(0, $ext_role_guid)) {

            echo "<script> alert('Extended Department role cannot leave blank');</script>";

            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";

        }

        else if ($role_guid == '0') {

            echo "<script> alert('Primary Department role cannot leave blank');</script>";


            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";

        }

        else if($sendreset == '1') {

        $token_life = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='107'")->row('value');
        $expiretime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$token_life minutes"));
        $token = bin2hex(openssl_random_pseudo_bytes(16));

        $this->db->query("UPDATE ost_staff_test
            SET firstname = '$firstname', 
                lastname = '$lastname', 
                email = '$email', 
                phone = '$phone', 
                phone_ext = '$phone_ext', 
                mobile = '$mobile', 
                username = '$username', 
                isactive = '$islocked',
                isadmin = '$isadmin', 
                change_passwd ='4',
                assigned_only = '$assigned_only', 
                onvacation = '$onvacation', 
                notes = '$notes', 
                dept_guid = '$dept_guid', 
                role_guid = '$role_guid', 
                permissions =  '$perms',
                token = '$token',
                token_expire = '$expiretime',
                updated = NOW()
            WHERE staff_guid = '$staffid';");

        $result = $this->db->query("SELECT * FROM ost_staff_test WHERE email = '$email'");

        $data = array(
            'body' => $this->db->query("SELECT REPLACE(REPLACE(REPLACE(body, '%firstname%', '".$result->row('firstname')."'), '%token%', '$token'), '%staff_guid%', '".$result->row('staff_guid')."') AS email, name FROM ost_content_test WHERE type = 'pwreset-staff'"),
            'template' => $this->db->query("SELECT * FROM ost_company_test"),
        );

        $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
        $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$default_email'")->row();

        $config = array(
            
            'smtp_user' => $sender_email->userid,
            'smtp_pass' => $sender_email->userpass,
            'smtp_host' => $sender_email->smtp_host,
            'smtp_port' => $sender_email->smtp_port,
                            
        );

        $bodyContent = $this->load->view('email_template', $data, TRUE);
        $result = $this->email
            ->initialize($config)
            ->from($sender_email->userid)
            ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
            ->to($email)
            ->subject($data['body']->row('name'))
            ->message($bodyContent)
            ->send();

        $this->db->query("DELETE FROM ost_team_member_test WHERE staff_guid='$staffid' ");

        if (isset($team))
        {
            foreach ($team as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$value', '$staffid') ");
            }
        }

        $this->db->query("DELETE FROM ost_staff_dept_access_test WHERE staff_guid='$staffid' ");
        foreach ( $ext_role_guid as $index => $ext_role_guid1 ) 

            {

                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$staffid', '$ext_dept_guid[$index]', '$ext_role_guid1') ");

            }

            echo "<script> alert('Successfully edit agents');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";
            }

        elseif ($sendreset != '1') {

            if ($password1 != $password2){

             echo "<script> alert('Confirm password wrong');</script>";


        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";

        }

        else if ($password1 == '' || $password2 == ''){

            $this->db->query("UPDATE ost_staff_test
                SET firstname = '$firstname', 
                lastname = '$lastname', 
                email = '$email', 
                phone = '$phone', 
                phone_ext = '$phone_ext', 
                mobile = '$mobile', 
                username = '$username', 
                isactive = '$islocked',
                isadmin = '$isadmin', 
                assigned_only = '$assigned_only', 
                onvacation = '$onvacation', 
                change_passwd ='$change_passwd',
                notes = '$notes', 
                dept_guid = '$dept_guid', 
                role_guid = '$role_guid', 
                permissions =  '$perms',
                updated = NOW()
                WHERE staff_guid = '$staffid';");

            $this->db->query("DELETE FROM ost_team_member_test WHERE staff_guid='$staffid' ");

            if ($team != '') {
                foreach ($team as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$value', '$staffid') ");
            }
            }

            $this->db->query("DELETE FROM ost_staff_dept_access_test WHERE staff_guid='$staffid' ");
            foreach ( $ext_role_guid as $index => $ext_role_guid1 ) 

            {

                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$staffid', '$ext_dept_guid[$index]', '$ext_role_guid1') ");

            }

            echo "<script> alert('Successfully edit agents');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";

        }

            else {

            $this->db->query("UPDATE ost_staff_test
                SET firstname = '$firstname', 
                lastname = '$lastname', 
                passwd = '$password2',
                email = '$email', 
                phone = '$phone', 
                phone_ext = '$phone_ext', 
                mobile = '$mobile', 
                username = '$username', 
                isactive = '$islocked',
                isadmin = '$isadmin', 
                assigned_only = '$assigned_only', 
                onvacation = '$onvacation', 
                change_passwd ='$change_passwd',
                notes = '$notes', 
                dept_guid = '$dept_guid', 
                role_guid = '$role_guid', 
                permissions =  '$perms',
                updated = NOW()
                WHERE staff_guid = '$staffid';");


            $this->db->query("DELETE FROM ost_team_member_test WHERE staff_guid='$staffid' ");

            if ($team != '') {
                foreach ($team as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$value', '$staffid') ");
            }
            }

            $this->db->query("DELETE FROM ost_staff_dept_access_test WHERE staff_guid='$staffid' ");
        foreach ( $ext_role_guid as $index => $ext_role_guid1 ) 

            {

            
                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$staffid', '$ext_dept_guid[$index]', '$ext_role_guid1') ");
                
            }

            echo "<script> alert('Successfully edit agents');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staffid' </script>";
        
            }
        }

    }

    public function agents_teams()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'team' => $this->db->query("SELECT * FROM ost_team_test left JOIN ost_staff_test ON ost_team_test.lead_guid = ost_staff_test.staff_guid"),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_teams', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_teams_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_team_test
                            SET flags = '$status'
                            WHERE team_guid = '$value'");
        }

            echo "<script> alert('Status of Team changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_team_test WHERE team_guid='$value' ");

            
        }
            echo "<script> alert('Team deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams' </script>";


    }

    public function agents_teams_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'staff' => $this->db->query("SELECT * FROM ost_staff_test"),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_teams_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_teams_add_process()

    {  
        $name = $this->input->post('name');
        $isenabled = $this->input->post('isenabled');
        $lead_guid = $this->input->post('lead_guid');
        $notes = $this->input->post('notes');
        $members = $this->input->post('members[]');

        $namecheck = $this->db->query("SELECT * FROM ost_team_test WHERE name = '$name' ");

        if ($namecheck->num_rows() != 0){

             echo "<script> alert('Team name duplicated');</script>";


        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams_add' </script>";

        }

        else {

        if ($lead_guid != '0') {

            $this->db->query("INSERT INTO ost_team_test 
            (team_guid, name, flags, lead_guid, notes, created, updated)
            VALUES (REPLACE(UPPER(UUID()),'-',''), '$name', '$isenabled', '$lead_guid', '$notes', NOW(), NOW() )");

        $team_guid = $this->db->query("SELECT team_guid FROM ost_team_test WHERE created = NOW()")->row('team_guid');

        if ($members != ""){

        foreach ($members as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$team_guid', '$value') ");
            }

        }

        echo "<script> alert('Team added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams' </script>";
        }

        else {

            $this->db->query("INSERT INTO ost_team_test 
            (team_guid, name, flags, notes, created, updated)
            VALUES (REPLACE(UPPER(UUID()),'-',''), '$name', '$isenabled', '$notes', NOW(), NOW() )");

        $team_guid = $this->db->query("SELECT team_guid FROM ost_team_test WHERE created = NOW()")->row('team_guid');

        if ($members != ""){

        foreach ($members as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$team_guid', '$value') ");
            }

        }

        echo "<script> alert('Team added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams' </script>";
        }
        
        }

    }

    public function agents_teams_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   $teamid = $_REQUEST['id'];
            $data = array(

                'team' => $this->db->query("SELECT * FROM ost_team_test WHERE team_guid ='$teamid' ")->row(),

                'notteammember' => $this->db->query("SELECT * FROM ost_staff_test WHERE ost_staff_test.staff_guid NOT IN (SELECT ost_staff_test.staff_guid FROM ost_staff_test INNER JOIN ost_team_member_test ON ost_staff_test.staff_guid = ost_team_member_test.staff_guid WHERE team_guid = '$teamid')"),

                'staff' => $this->db->query("SELECT * FROM ost_staff_test"),

                'teammember' => $this->db->query("SELECT * FROM ost_team_member_test INNER JOIN ost_staff_test ON ost_team_member_test.staff_guid = ost_staff_test.staff_guid WHERE team_guid ='$teamid' "),


                'lead' => $this->db->query("SELECT * FROM ost_staff_test right JOIN ost_team_test ON ost_staff_test.staff_guid = ost_team_test.lead_guid WHERE team_guid ='$teamid' ")->row(),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_teams_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_teams_info_process()

    {  
        $name = $this->input->post('name');
        $isenabled = $this->input->post('isenabled');
        $lead_guid = $this->input->post('lead_guid');
        $notes = $this->input->post('notes');
        $members = $this->input->post('members[]');
        $teamid = $_REQUEST['id'];



        $namecheck = $this->db->query("SELECT * FROM ost_team_test WHERE name = '$name' AND team_guid !='$teamid' ");

        if ($namecheck->num_rows() != 0){

             echo "<script> alert('Team name duplicated');</script>";


        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams_info?id=$teamid' </script>";

        }

        else {

        if ($lead_guid != '0') {

            $this->db->query("UPDATE ost_team_test SET 
            name = '$name', 
            flags = '$isenabled',
            lead_guid = '$lead_guid', 
            notes = '$notes',
            updated = NOW()
            WHERE team_guid = '$teamid' ;");


        $this->db->query("DELETE FROM ost_team_member_test WHERE team_guid='$teamid' ");

        if ($members != ""){

        foreach ($members as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$teamid', '$value') ");
            }

        }

        echo "<script> alert('Team edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams_info?id=$teamid' </script>";
        }

        else {

            $this->db->query("UPDATE ost_team_test SET 
            name = '$name', 
            flags = '$isenabled',
            lead_guid = '$lead_guid',
            notes = '$notes',
            updated = NOW()
            WHERE team_guid = '$teamid' ;");

       $this->db->query("DELETE FROM ost_team_member_test WHERE team_guid='$teamid' ");

        if ($members != ""){

        foreach ($members as $value) {
                $this->db->query("INSERT INTO 
                ost_team_member_test (team_guid, staff_guid)
                VALUES 
                ('$teamid', '$value') ");
            }

        }

        echo "<script> alert('Team edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_teams_info?id=$teamid' </script>";
        }
        
        }

    }

    public function agents_roles()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'roles' => $this->db->query("SELECT * FROM ost_role_test"),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_roles', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

     public function agents_roles_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_role_test
                            SET flags = '$status'
                            WHERE role_guid = '$value'");
        }

            echo "<script> alert('Status of role/s changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_role_test WHERE role_guid='$value' ");

            
        }
            echo "<script> alert('Role/s deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_roles' </script>";


    }

    public function agents_roles_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_roles_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_roles_add_process()

    {  
        

       

        $name = $this->input->post('name');
        $notes = $this->input->post('notes');
        $perms = $this->input->post('perms[]');
        $perms = implode(", ", $perms);


        $namecheck = $this->db->query("SELECT * FROM ost_role_test WHERE name = '$name'");

        if ($namecheck->num_rows() != 0){

             echo "<script> alert('Role name duplicated');</script>";

         echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_roles_add' </script>";

        }

        else{

        //need to do permission


        $this->db->query("INSERT INTO ost_role_test 
            (role_guid, name, permissions, notes, created, updated)
            VALUES (REPLACE(UPPER(UUID()),'-',''), '$name', '$perms', '$notes', NOW(), NOW() )");

        echo "<script> alert('Role added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_roles' </script>";
        
        }

    }

    public function agents_roles_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   

            $roleid = $_REQUEST['id'];
            $data = array(

                'role' => $this->db->query("SELECT * FROM ost_role_test WHERE role_guid = '$roleid' ")->row(),

                'addticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.create%'")->num_rows(),

                'editticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.edit%'")->num_rows(),

                'asgticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.assign%'")->num_rows(),

                'transticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.transfer%'")->num_rows(),

                'replyticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.reply%'")->num_rows(),

                'closeticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.close%'")->num_rows(),

                'deleteticketallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.delete%'")->num_rows(),

                'editthreadallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%thread.edit%'")->num_rows(),

                'addtaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%task.create%'")->num_rows(),

                'edittaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%task.edit%'")->num_rows(),

                'asgtaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%task.assign%'")->num_rows(),

                'transtaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%task.transfer%'")->num_rows(),

                'replytaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%task.reply%'")->num_rows(),

                'closetaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%task.close%'")->num_rows(),

                'deletetaskallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%ticket.delete%'")->num_rows(),

                'managecannedallow' => $this->db->query(" SELECT * FROM ost_role_test WHERE role_guid = '$roleid' AND permissions LIKE '%canned.manage%'")->num_rows(),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_roles_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_roles_info_process()

    {  
        $name = $this->input->post('name');
        $notes = $this->input->post('notes');
        $perms = $this->input->post('perms[]');

        
        if ($perms != '' ) {
            $perms = implode(", ", $perms);
        }
        $roleid = $_REQUEST['id'];
        

        $namecheck = $this->db->query("SELECT * FROM ost_role_test WHERE name = '$name' AND role_guid != '$roleid' ");

        if ($namecheck->num_rows() != 0){

            echo "<script> alert('Role name duplicated');</script>";

         echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_roles_info?id=$roleid' </script>";

        }

        else{


        $this->db->query("UPDATE ost_role_test
                            SET name = '$name',
                            notes = '$notes',
                            permissions = '$perms',
                            updated = NOW()
                            WHERE role_guid = '$roleid'");


        echo "<script> alert('Role edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_roles_info?id=$roleid' </script>";
        
        }

    }

    public function agents_departments()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $deparment_info = $this->db->query("SELECT department_guid FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_info->department_guid."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->department_guid);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

            $data = array(

                'department' => $this->db->query("SELECT a.ispublic, a.manager_guid, a.department_guid, a.name, b.email, b.email_guid, b.name AS emailname, c.firstname, c.lastname,c.staff_guid  FROM ost_department_test AS a LEFT JOIN ost_email_test AS b ON a.email_guid = b.email_guid LEFT JOIN ost_staff_test AS c ON a.manager_guid = c.staff_guid"),
                'depart_name' => $depart_name,
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_departments', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_departments_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_department_test
                            SET ispublic = '$status'
                            WHERE department_guid = '$value'");
        }

            echo "<script> alert('Status of department(s) changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_department_test WHERE department_guid='$value' ");

            
        }
            echo "<script> alert('Department(s) deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_departments' </script>";


    }

    public function agents_departments_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $deparment_info = $this->db->query("SELECT department_guid FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_info->department_guid."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->department_guid);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

            $data = array(

                'department' => $depart_name,
                'sla' => $this->db->query("SELECT * FROM ost_sla_test"),
                'staff' => $this->db->query("SELECT * FROM ost_staff_test"),
                'email' => $this->db->query("SELECT * FROM ost_email_test"),
                'emailtemplate' => $this->db->query("SELECT * FROM ost_email_template_group"),
                'roles' => $this->db->query("SELECT * FROM ost_role_test"),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_departments_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function agents_departments_add_process()

    {  
        $pid = $this->input->post('pid');
        $name = $this->input->post('name');
        $ispublic = $this->input->post('ispublic');
        $sla_guid = $this->input->post('sla_guid');
        $manager_guid = $this->input->post('manager_guid');
        $assign_members_only = $this->input->post('assign_members_only');
        $disable_auto_claim = $this->input->post('disable_auto_claim');
        $email_guid = $this->input->post('email_guid');
        $tpl_guid = $this->input->post('tpl_guid');
        $ticket_auto_response = $this->input->post('ticket_auto_response');
        $message_auto_response = $this->input->post('message_auto_response');
        $autoresp_email_guid = $this->input->post('autoresp_email_guid');
        $group_membership = $this->input->post('group_membership');
        $deptsignature = $this->input->post('deptsignature');
        $members = $this->input->post('members[]');
        $member_role = $this->input->post('member_role[]');

        $parentname = $this->db->query("SELECT name from ost_department_test WHERE department_guid = '$pid' ")->row('name');

        if ($assign_members_only == 0 && $disable_auto_claim == 0) {

        if ($pid == '') {
            $department_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
            $this->db->query("INSERT INTO ost_department_test (department_guid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$department_guid', '$name', '$ispublic', '$sla_guid', '$manager_guid', '0', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");

        } else if ($pid != '') {

            $this->db->query("INSERT INTO ost_department_test (pid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$pid', '$parentname / $name', '$ispublic', '$sla_guid', '$manager_guid', '0', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");
        }
            
        }

        else if ($assign_members_only == 1 && $disable_auto_claim == 0) {

        if ($pid == '') {
            $department_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
            $this->db->query("INSERT INTO ost_department_test (department_guid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$department_guid', '$name', '$ispublic', '$sla_guid', '$manager_guid', '1', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");

        } else if ($pid != '') {

            $this->db->query("INSERT INTO ost_department_test (pid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$pid', '$parentname / $name', '$ispublic', '$sla_guid', '$manager_guid', '1', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");
        }
            
        }

        else if ($assign_members_only == 0 && $disable_auto_claim == 1) {

        if ($pid == '') {
            $department_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
            $this->db->query("INSERT INTO ost_department_test (department_guid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$department_guid', '$name', '$ispublic', '$sla_guid', '$manager_guid', '2', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");

        } else if ($pid != '') {

            $this->db->query("INSERT INTO ost_department_test (pid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$pid', '$parentname / $name', '$ispublic', '$sla_guid', '$manager_guid', '2', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");
        }
            
        }

        else if ($assign_members_only == 1 && $disable_auto_claim == 1) {

        if ($pid == '') {
            $department_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
            $this->db->query("INSERT INTO ost_department_test (department_guid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$department_guid', '$name', '$ispublic', '$sla_guid', '$manager_guid', '3', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");

        } else if ($pid != '') {

            $this->db->query("INSERT INTO ost_department_test (pid, name, ispublic, sla_guid, manager_guid, flags, email_guid, tpl_guid, ticket_auto_response, message_auto_response, autoresp_email_guid, group_membership, signature, created, updated )
            VALUES ('$pid', '$parentname / $name', '$ispublic', '$sla_guid', '$manager_guid', '3', '$email_guid', '$tpl_guid', '$ticket_auto_response', '$message_auto_response', '$autoresp_email_guid', '$group_membership', '$deptsignature',NOW(), NOW() )");
        }
            
        }

        $dept_guid = $this->db->query("SELECT department_guid FROM ost_department_test WHERE created = NOW()")->row('department_guid');

        if ($members != ""){

            foreach ( $members as $index => $members1 ) {

                if ($member_role[$index] == 0) {
                    echo "<script> alert('Cannot add one of the agents because role empty');</script>";
                }

                else{

                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$members1', '$dept_guid', '$member_role[$index]') ");
                }
            }              
        }

        echo "<script> alert('Department added.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_departments_info?id=$dept_guid' </script>";

    }

    public function agents_departments_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $dept_guid = $_REQUEST['id'];
            $deparment_info = $this->db->query("SELECT department_guid FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_info->department_guid."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE department_guid = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->department_guid);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

            $data = array(
                'department' => $depart_name,
                'departmentinfo' => $this->db->query("SELECT * FROM ost_department_test WHERE department_guid = '$dept_guid' ")->row(),
                'sla' => $this->db->query("SELECT * FROM ost_sla_test"),
                'staff' => $this->db->query("SELECT * FROM ost_staff_test"),
                'email' => $this->db->query("SELECT * FROM ost_email_test"),
                'emailtemplate' => $this->db->query("SELECT * FROM ost_email_template_group_test"),
                'roles' => $this->db->query("SELECT * FROM ost_role_test"),
                'primarymember' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$dept_guid' "),
                'extendedmember' => $this->db->query("SELECT a.staff_guid, a.role_guid, b.firstname, b.lastname  FROM ost_staff_dept_access_test as a INNER JOIN ost_staff_test as b ON a.staff_guid = b.staff_guid WHERE a.dept_guid = '$dept_guid' "),
                'staff1' => $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid NOT IN (SELECT a.staff_guid FROM ost_staff_dept_access_test as a INNER JOIN ost_staff_test as b ON a.staff_guid = b.staff_guid WHERE a.dept_guid = '$dept_guid' )"),
            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {   
                //print_r($this->db->query("SELECT * FROM ost_role_test")->result());
                $this->load->view('headeradmin');
                $this->load->view('admin_agents/admin_agents_departments_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }


    public function agents_departments_info_process()

    {  
        $pid = $this->input->post('pid');
        $name = $this->input->post('name');
        $ispublic = $this->input->post('ispublic');
        $sla_guid = $this->input->post('sla_guid');
        $manager_guid = $this->input->post('manager_guid');
        $assign_members_only = $this->input->post('assign_members_only');
        $disable_auto_claim = $this->input->post('disable_auto_claim');
        $email_guid = $this->input->post('email_guid');
        $tpl_guid = $this->input->post('tpl_guid');
        $ticket_auto_response = $this->input->post('ticket_auto_response');
        $message_auto_response = $this->input->post('message_auto_response');
        $autoresp_email_guid = $this->input->post('autoresp_email_guid');
        $group_membership = $this->input->post('group_membership');
        $deptsignature = $this->input->post('deptsignature');
        $members = $this->input->post('members[]');
        $member_role = $this->input->post('member_role[]');

        $primary_members = $this->input->post('primary_members[]');
        $primary_role = $this->input->post('primary_role[]');
        $dept_guid = $_REQUEST['id'];


        if ($ticket_auto_response == '') {
            
            $ticket_auto_response = '1' ;
        }

        if ($message_auto_response == '') {

            $message_auto_response = '1' ;
            
        }

        $parentname = $this->db->query("SELECT name from ost_department_test WHERE department_guid = '$pid' ")->row('name');

 
        if ($assign_members_only == 0 && $disable_auto_claim == 0) {

        if ($pid == '') {

            $this->db->query("UPDATE ost_department_test SET 
                pid = NULL,
                name = '$name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '0', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");




        } else if ($pid != '') {

            $this->db->query("UPDATE ost_department_test SET 
                pid = '$pid', 
                name = '$parentname / $name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '0', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");
        }
            

        }

        else if ($assign_members_only == 1 && $disable_auto_claim == 0) {

        if ($pid == '') {


            $this->db->query("UPDATE ost_department_test SET  
                pid = NULL,
                name = '$name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '1', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");




        } else if ($pid != '') {

           $this->db->query("UPDATE ost_department_test SET 
                pid = '$pid', 
                name = '$parentname / $name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '1', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");
        }
            

        }

        else if ($assign_members_only == 0 && $disable_auto_claim == 1) {

        if ($pid == '') {

            $this->db->query("UPDATE ost_department_test SET  
                pid = NULL,
                name = '$name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '2', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");




        } else if ($pid != '') {

            $this->db->query("UPDATE ost_department_test SET 
                pid = '$pid', 
                name = '$parentname / $name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '2', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");
        }
            

        }

        else if ($assign_members_only == 1 && $disable_auto_claim == 1) {

        if ($pid == '') {
            $this->db->query("UPDATE ost_department_test SET  
                pid = NULL,
                name = '$name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '3', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");




        } else if ($pid != '') {

            $this->db->query("UPDATE ost_department_test SET 
                pid = '$pid', 
                name = '$parentname / $name', 
                ispublic = '$ispublic',
                sla_guid = '$sla_guid', 
                manager_guid = '$manager_guid',
                flags = '3', 
                email_guid = '$email_guid',
                tpl_guid = '$tpl_guid', 
                ticket_auto_response = '$ticket_auto_response',
                message_auto_response = '$message_auto_response', 
                autoresp_email_guid = '$autoresp_email_guid',
                group_membership = '$group_membership', 
                signature = '$deptsignature',
                updated = NOW()

                WHERE department_guid = '$dept_guid' ;");
        }
            

        }

                $this->db->query("DELETE FROM ost_staff_dept_access_test WHERE dept_guid='$dept_guid' ");

                if ($members != ""){

                foreach ( $members as $index => $members1 ) {


                if ($member_role[$index] == 0) {
                    echo "<script> alert('Cannot add one of the agents because role empty');</script>";
                }

                else{

                $this->db->query("INSERT INTO 
                ost_staff_dept_access_test (staff_guid, dept_guid, role_guid)
                VALUES 
                ('$members1', '$dept_guid', '$member_role[$index]') ");
                }

                }

               

                }

                if ($primary_members != ""){

                foreach ( $primary_members as $index => $primary_members1 ) {


                if ($primary_role[$index] == 0) {
                    echo "<script> alert('Cannot change one of the primary agents role because role empty');</script>";
                }

                else{

                $this->db->query("UPDATE ost_staff_test
                        SET role_guid = '$primary_role[$index]', updated = NOW()
                        WHERE staff_guid = '$primary_members1';");
                }

                }
                }

                

                echo "<script> alert('Department edited.');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_departments_info?id=$dept_guid' </script>";
        

            

    }

    



}

    
?>