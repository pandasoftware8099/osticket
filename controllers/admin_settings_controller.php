<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_settings_controller extends CI_Controller {
    
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

    public function main()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $deparment_info = $this->db->query("SELECT id, ispublic FROM ost_department_test");
            foreach ($deparment_info->result() as $depart_info)
            {
                $depart_child = $this->db->query("SELECT name, pid FROM ost_department_test WHERE id = '".$depart_info->id."'");
                $concat = $depart_child->row('name');
                while (!empty($depart_child->row('pid')))
                {       
                    $depart_main = $this->db->query("SELECT name, pid FROM ost_department_test WHERE id = '".$depart_child->row('pid')."'");
                    $concat = $depart_main->row('name').' / '.$concat;

                    $depart_child = $depart_main;
                }

                $depart_name[] = array('depart_name' => $concat, 'depart_id' => $depart_info->id, 'depart_public' => $depart_info->ispublic);
            }
            usort($depart_name, function($a, $b)
            {
                return strnatcasecmp($a['depart_name'], $b['depart_name']);
            });

            $data = array(
                'isonline' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='12'"),
                'helpdesk_url' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='2'"),
                'helpdesk_title' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='3'")->row(),
                'department' => $depart_name,
                'department_email' => $this->db->query("SELECT email_id, email FROM ost_email_test"),
                'default_dept_id' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='85'")->row(),
                'autolock_minutes' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='23'"),
                'max_page_size' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='21'"),
                'enable_avatars' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='93'"),
                'max_file_size' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='77'"),
                'max_files' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='119'"),
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
                $this->load->view('admin_settings/admin_settings_system', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function main_process()
    {   
        $isonline = $this->input->post('isonline');
        $helpdesk_url = $this->input->post('helpdesk_url');
        $helpdesk_title = $this->input->post('helpdesk_title');
        $default_dept_id = $this->input->post('default_dept_id');
        $autolock_minutes = $this->input->post('autolock_minutes');
        $max_page_size = $this->input->post('max_page_size');
        $enable_avatars = $this->input->post('enable_avatars');
        $max_file_size = $this->input->post('max_file_size');
        $max_files = $this->input->post('max_files');

        $this->db->query("UPDATE ost_config_test SET value = '$isonline', updated = NOW() WHERE id='12' ");
        $this->db->query("UPDATE ost_config_test SET value = '$helpdesk_url', updated = NOW() WHERE id='2' ");
        $this->db->query("UPDATE ost_config_test SET value = '$helpdesk_title', updated = NOW() WHERE id='3' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_dept_id', updated = NOW() WHERE id='85' ");
        $this->db->query("UPDATE ost_config_test SET value = '$autolock_minutes', updated = NOW() WHERE id='23' ");
        $this->db->query("UPDATE ost_config_test SET value = '$max_page_size', updated = NOW() WHERE id='21' ");
        $this->db->query("UPDATE ost_config_test SET value = '$enable_avatars', updated = NOW() WHERE id='93' ");
        $this->db->query("UPDATE ost_config_test SET value = '$max_file_size', updated = NOW() WHERE id='77' ");
        $this->db->query("UPDATE ost_config_test SET value = '$max_files', updated = NOW() WHERE id='119' ");

        echo "<script> alert('Successfully change settings');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/main' </script>";
    }

    public function add_new_department()
    {   
        $main_department = $this->input->post('main_department');
        $department_name = addslashes($this->input->post('department_name'));
        $department_email = $this->input->post('department_email');
        $department_internal = $this->input->post('department_internal');
        $direct = $_REQUEST['direct'];
        $staff_id = $_REQUEST['id'];
        $count_department_name = $this->db->query("SELECT COUNT(*) AS count FROM ost_department_test WHERE name = '$department_name'");

        if (empty($count_department_name->row('count')))
        {
            $this->db->query("INSERT INTO ost_department_test (pid, email_id, name, ispublic, updated, created)
            VALUES ('$main_department', '$department_email', '$department_name', '$department_internal', now(), now())");

            $department_info = $this->db->query("SELECT id, pid FROM ost_department_test WHERE name = '$department_name'");
            $path = '/'.$department_info->row('id').'/';
            while (!empty($department_info->row('pid')))
            {
                $path_pid = '/'.$department_info->row('pid');
                
                $path = $path_pid.$path;

                $department_info = $this->db->query("SELECT id, pid FROM ost_department_test WHERE id = '".$department_info->row('pid')."'");
            }

            $department_id = $this->db->query("SELECT id FROM ost_department_test WHERE name = '$department_name'");        
            $this->db->query("UPDATE ost_department_test SET path = '$path' WHERE id = '".$department_id->row('id')."'");
        }
        else
        {
            echo "<script> alert('Duplicate department name');</script>";
        }

        if ($direct == 'admin_settings_system')
        {
            echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/main' </script>";
        }
        else if ($direct == 'admin_agents_agents_add')
        {
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_add' </script>";
        }
        else if ($direct == 'admin_agents_agents_info')
        {
            echo "<script> document.location='" . base_url() . "/index.php/admin_agents_controller/agents_agents_info?id=$staff_id' </script>";
        }
    }

    public function settings_company()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                'template' => $this->db->query("SELECT * FROM ost_company_test"),
                'landpages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'landing' AND isactive = '1' AND field = 'pages'"),
                'offpages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'offline' AND isactive = '1' AND field = 'pages'"),
                'typages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'thank-you' AND isactive = '1' AND field = 'pages'"),
                'orilandpages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'landing' AND in_use = '1' AND isactive = '1' AND field = 'pages'"),
                'orioffpages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'offline' AND in_use = '1' AND isactive = '1' AND field = 'pages'"),
                'oritypages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'thank-you' AND in_use = '1' AND isactive = '1' AND field = 'pages'"),
                'logo' => $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' ORDER BY id"),
                'defclientlogo' => $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' AND default_client = '1'"),
                'defstafflogo' => $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' AND default_staff = '1'"),
                'backdrop' => $this->db->query("SELECT * FROM ost_file_test WHERE type = 'backdrop' ORDER BY id"),
                'defstaffbackdrop' => $this->db->query("SELECT * FROM ost_file_test WHERE type = 'backdrop' AND default_staff = '1'"),
                'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
                'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
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
                $this->load->view('admin_settings/admin_settings_company', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function company_update()
    {
        $cname = $this->input->post('cname');
        $cwebsite = $this->input->post('cwebsite');
        $cphone = $this->input->post('cphone');
        $caddress = $this->input->post('caddress');
        $landing_page_id = $this->input->post('landing_page_id');
        $offline_page_id = $this->input->post('offline_page_id');
        $ty_page_id = $this->input->post('thank-you_page_id');
        $clientlogo = $this->input->post('selected-logo');
        $stafflogo = $this->input->post('selected-logo-scp');
        $staffbackdrop = $this->input->post('selected-backdrop');
        $dellogo = $this->input->post('dellogo[]');
        $delbackdrop = $this->input->post('delbackdrop[]');

        $this->db->query("UPDATE ost_company_test SET name_template = '$cname', web_template = '$cwebsite', phone_template = '$cphone', address_template = '$caddress', company_updated = now()");
        $this->db->query("UPDATE ost_content_test SET in_use = '1', updated = now() WHERE id IN ($landing_page_id, $offline_page_id, $ty_page_id)");
        $this->db->query("UPDATE ost_content_test SET in_use = '0', updated = now() WHERE field = 'pages' AND id NOT IN ($landing_page_id, $offline_page_id, $ty_page_id)");
        $this->db->query("UPDATE ost_file_test SET default_client = '1' WHERE id = '$clientlogo'");
        $this->db->query("UPDATE ost_file_test SET default_client = '0' WHERE id != '$clientlogo' AND type = 'logo'");
        $this->db->query("UPDATE ost_file_test SET default_staff = '1' WHERE id = '$stafflogo'");
        $this->db->query("UPDATE ost_file_test SET default_staff = '0' WHERE id != '$stafflogo' AND type = 'logo'");
        $this->db->query("UPDATE ost_file_test SET default_staff = '1' WHERE id = '$staffbackdrop'");
        $this->db->query("UPDATE ost_file_test SET default_staff = '0' WHERE id != '$staffbackdrop' AND type = 'backdrop'");

        if(isset($_POST['submit-button'])){
            // Count total files
            $countfiles = count($_FILES['logo']['name']);
            // Looping all files
            for($i=0;$i<$countfiles;$i++)
            {
                $logo_id = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo'")->num_rows() + 1;

                $filename = 'logo'.$logo_id.'_'.$_FILES['logo']['name'][$i];

                if ($_FILES['logo']['name'][0] != "") 
                {
                    // Upload file
                    move_uploaded_file($_FILES['logo']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test ( name, type, created )
                    VALUES ( '$filename', 'logo', NOW() ) ");
                }
            }

            if ($filename != 'logo'."$logo_id".'_')
            {
                echo "<script> alert('$i File(s) uploaded.');</script>";
            }

            // Count total files
            $countfiles = count($_FILES['backdrop']['name']);
            // Looping all files
            for($i=0;$i<$countfiles;$i++)
            {
                $backdrop_id = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'backdrop'")->num_rows() + 1;

                $filename = 'backdrop'.$backdrop_id.'_'.$_FILES['backdrop']['name'][$i];

                if ($_FILES['backdrop']['name'][0] != "") 
                {
                    // Upload file
                    move_uploaded_file($_FILES['backdrop']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test ( name, type, created )
                    VALUES ( '$filename', 'backdrop', NOW() ) ");
                }
            }

            if ($filename != 'backdrop'."$backdrop_id".'_')
            {
                echo "<script> alert('$i File(s) uploaded.');</script>";
            }
        }

        if (!empty($dellogo))
        {
            foreach ($dellogo as $deletelogo)
            {
                $this->db->query("DELETE FROM ost_file_test WHERE id = '$deletelogo'");
            }
        }

        if (!empty($delbackdrop))
        {
            foreach ($delbackdrop as $deletebackdrop)
            {
                $this->db->query("DELETE FROM ost_file_test WHERE id = '$deletebackdrop'");
            }
        }

        echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_company' </script>";
    }

    public function settings_ticket()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                'default_status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                'default_priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                'default_sla' => $this->db->query("SELECT * FROM ost_sla_test"),
                'default_topic' => $this->db->query("SELECT * FROM ost_help_topic_test ORDER BY topic"),
                'ticket_number_format' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='70'"),
                'max_open_tickets' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='22'")->row(),
                'defaultslaid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='86'"),
                'defaultpriorityid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='9'"),
                'defaultstatusid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='103'"),
                'default_help_topic' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='102'"),
                'auto_claim_tickets' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='63'"),
                'show_assigned_tickets' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='65'"),
                'show_answered_tickets' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='66'"),
                'ticket_seq_list' => $this->db->query("SELECT * FROM ost_sequence_test"),
                'ticket_seq' => $this->db->query("SELECT value FROM ost_config_test WHERE id='71'")->row('value'),
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
                $this->load->view('admin_settings/admin_settings_ticket', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function ticket_seq_update() 
    {       
        $name = $this->input->post('name'); 
        $next = $this->input->post('next'); 
        $increment = $this->input->post('increment');   
        $padding = $this->input->post('padding');   
        $id = $this->input->post('id'); 
        $namecheck = end($name);    
        $all_id = $this->db->query("SELECT id FROM ost_sequence_test")->result();   
            
        foreach($id as $key=>$value){  
            if($value != ''){   
            $this->db->query("UPDATE ost_sequence_test SET name='$name[$key]',next='$next[$key]',increment='$increment[$key]',padding='$padding[$key]' WHERE id='$value'"); 
            }   
            else if($value == '' && $name[$key] != $namecheck)  
            {   
                $this->db->query("INSERT INTO ost_sequence_test (name,next,increment,padding) VALUES('$name[$key]','$next[$key]','$increment[$key]','$padding[$key]')");    
            }else if($value != )    
        }   
        echo "<script> alert('Successfully Update settings');</script>";   
            
        echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_ticket' </script>";   
     }  


    public function ticket_update()
    {   
        $ticket_number_format = $this->input->post('ticket_number_format');
        $default_status = $this->input->post('default_ticket_status');
        $default_priority = $this->input->post('default_priority');
        $default_sla = $this->input->post('default_sla');
        $default_help_topic = $this->input->post('default_help_topic');
        $max_open_tickets = $this->input->post('max_open_tickets');
        $auto_claim_tickets = $this->input->post('auto_claim_tickets');
        $show_assigned_tickets = $this->input->post('show_assigned_tickets');
        $show_answered_tickets = $this->input->post('show_answered_tickets');

        $this->db->query("UPDATE ost_config_test SET value = '$ticket_number_format', updated = NOW() WHERE id='70' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_status', updated = NOW() WHERE id='103' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_priority', updated = NOW() WHERE id='9' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_sla', updated = NOW() WHERE id='86' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_help_topic', updated = NOW() WHERE id='102' ");
        $this->db->query("UPDATE ost_config_test SET value = '$max_open_tickets', updated = NOW() WHERE id='22' ");
        $this->db->query("UPDATE ost_config_test SET value = '$auto_claim_tickets', updated = NOW() WHERE id='63' ");
        $this->db->query("UPDATE ost_config_test SET value = '$show_assigned_tickets', updated = NOW() WHERE id='65' ");
        $this->db->query("UPDATE ost_config_test SET value = '$show_answered_tickets', updated = NOW() WHERE id='66' ");

        echo "<script> alert('Successfully change settings');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_ticket' </script>";
    }

    public function settings_task()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                'task_info' => $this->db->query("SELECT * FROM ost_task_test"),
                'default_task_priority_id' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='141'"),
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
                $this->load->view('admin_settings/admin_settings_task', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function settings_agent()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'pw_expire_period' => $this->db->query("SELECT * FROM ost_config_test WHERE id = '17'")->row(),
                'pw_reset_status' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='106'")->row(),
                'pw_reset_window' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='107'")->row(),
                'staff_max_login' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='14'")->row(),
                'staff_login_timeout' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='15'")->row(),
                'staff_sess_timeout' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='16'")->row(),
                'staff_ip_binding' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='13'")->row(),
                'hide_staff_name' => $this->db->query("SELECT * FROM ost_config_test WHERE id = '67'")->row(),
                'agent_template' => $this->db->query("SELECT * FROM ost_content_test WHERE field = 'agent'"),
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
                $this->load->view('admin_settings/admin_settings_agent', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function agent_update()
    {   
        $hide_staff_name = $this->input->post('hide_staff_name');
        $passwd_reset_period = $this->input->post('passwd_reset_period');
        $allow_pw_reset = $this->input->post('allow_pw_reset');
        $pw_reset_window = $this->input->post('pw_reset_window');
        $staff_max_logins = $this->input->post('staff_max_logins');
        $staff_login_timeout = $this->input->post('staff_login_timeout');
        $staff_session_timeout = $this->input->post('staff_session_timeout');
        $staff_ip_binding = $this->input->post('staff_ip_binding');

        $this->db->query("UPDATE ost_config_test SET value = '$hide_staff_name', updated = NOW() WHERE id='67' ");
        $this->db->query("UPDATE ost_config_test SET value = '$passwd_reset_period', updated = NOW() WHERE id='17' ");
        $this->db->query("UPDATE ost_config_test SET value = '$allow_pw_reset', updated = NOW() WHERE id='106' ");
        $this->db->query("UPDATE ost_config_test SET value = '$pw_reset_window', updated = NOW() WHERE id='107' ");
        $this->db->query("UPDATE ost_config_test SET value = '$staff_max_logins', updated = NOW() WHERE id='14' ");
        $this->db->query("UPDATE ost_config_test SET value = '$staff_login_timeout', updated = NOW() WHERE id='15' ");
        $this->db->query("UPDATE ost_config_test SET value = '$staff_session_timeout', updated = NOW() WHERE id='16' ");
        $this->db->query("UPDATE ost_config_test SET value = '$staff_ip_binding', updated = NOW() WHERE id='13' ");

        if($hide_staff_name == '1'){
            $this->db->query("UPDATE ost_staff_test set defaultname = 'dept'");
        }

        echo "<script> alert('Successfully change settings');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_agent' </script>";
    }

    public function settings_user()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'client_registration' => $this->db->query("SELECT * FROM ost_config_test WHERE id = '76'")->row(),
                'client_max_logins' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='18'")->row(),
                'client_login_timeout' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='19'")->row(),
                'client_session_timeout' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='20'")->row(),
                'allow_auth_tokens' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='112'")->row(),
                'user_template' => $this->db->query("SELECT * FROM ost_content_test WHERE field = 'user'"),
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
                $this->load->view('admin_settings/admin_settings_user', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function user_update()
    {   
        $client_registration = $this->input->post('client_registration');
        $client_max_logins = $this->input->post('client_max_logins');
        $client_session_timeout = $this->input->post('client_session_timeout');
        $allow_auth_tokens = $this->input->post('allow_auth_tokens');
        $client_login_timeout = $this->input->post('client_login_timeout');

        $this->db->query("UPDATE ost_config_test SET value = '$client_registration', updated = NOW() WHERE id='76' ");
        $this->db->query("UPDATE ost_config_test SET value = '$client_max_logins', updated = NOW() WHERE id='18' ");
        $this->db->query("UPDATE ost_config_test SET value = '$client_session_timeout', updated = NOW() WHERE id='20' ");
        $this->db->query("UPDATE ost_config_test SET value = '$allow_auth_tokens', updated = NOW() WHERE id='112' ");
        $this->db->query("UPDATE ost_config_test SET value = '$client_login_timeout', updated = NOW() WHERE id='19' ");

        echo "<script> alert('Successfully change settings');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_user' </script>";
    }

    public function templates_update()
    {   
        $id = $_REQUEST['id'];
        $direct = $_REQUEST['direct'];
        $topic = addslashes($this->input->post('topic'));
        $body = addslashes($this->input->post('body'));

        $this->db->query("UPDATE ost_content_test SET name = '$topic', updated = NOW(), body = '$body' WHERE id='$id' ");
       
        echo "<script> alert('Successfully update template.');</script>";

        if ($direct == 'agent')
        {
            echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_agent#templates' </script>";
        }
        else if ($direct == 'user')
        {
            echo "<script> document.location='" . base_url() . "/index.php/admin_settings_controller/settings_user#templates' </script>";
        }
    }
}
?>