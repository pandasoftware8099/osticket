<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_emails_controller extends CI_Controller {
    
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


    public function emails_emails()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   $email_guid = 1;

            $data = array(

                'email' => $this->db->query("SELECT a.email_guid,a.name,a.email,b.priority_desc,c.name as dept_name,a.created,a.updated FROM ost_email_test AS a INNER JOIN ost_ticket_priority_test AS b ON a.priority_guid = b.priority_guid LEFT JOIN ost_department_test AS c ON a.dept_guid = c.department_guid"),
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
                $this->load->view('admin_emails/admin_emails_emails', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_emails_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status == 2) {
            foreach ($check as $value) {
            $this->db->query("DELETE FROM ost_email_test WHERE email_guid='$value' ");

            //have to do delete child list item too
        }
            echo "<script> alert('Email(s) deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_emails' </script>";


    }

    public function emails_emails_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'department' => $this->db->query("SELECT * FROM ost_department_test"),
                'priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                'topic' => $this->db->query("SELECT * FROM ost_help_topic_test"),
                
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
                $this->load->view('admin_emails/admin_emails_emails_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_emails_add_process()

    {  // do priority id and dept id if system default have something wrong and postfetch problem
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $dept_guid = $this->input->post('dept_guid');
        $priority_guid = $this->input->post('priority_guid');
        $topic_guid = $this->input->post('topic_guid');
        $noautoresp = $this->input->post('noautoresp');
        $userid = $this->input->post('userid');
        $passwd = $this->input->post('passwd');
        $mail_active = $this->input->post('mail_active');
        $mail_host = $this->input->post('mail_host');
        $mail_port = $this->input->post('mail_port');
        $mail_proto = $this->input->post('mail_proto');
        $mail_fetchfreq = $this->input->post('mail_fetchfreq');
        $mail_fetchmax = $this->input->post('mail_fetchmax');

        $postfetch = $this->input->post('postfetch');

        $smtp_active = $this->input->post('smtp_active');
        $smtp_host = $this->input->post('smtp_host');
        $smtp_port = $this->input->post('smtp_port');
        $smtp_auth = $this->input->post('smtp_auth');
        $smtp_spoofing = $this->input->post('smtp_spoofing');
        $notes = $this->input->post('notes');
        $default_dept = $this->db->query("SELECT value FROM ost_config_test WHERE id='85'")->row('value');
        $default_prio = $this->db->query("SELECT value FROM ost_config_test WHERE id='9'")->row('value');
        $default_help = $this->db->query("SELECT value FROM ost_config_test WHERE id='102'")->row('value');

        $emailcheck = $this->db->query("SELECT * FROM ost_email_test WHERE email = '$email' ");

        if ($emailcheck->num_rows() !== 0){
            echo "<script> alert('Email duplicated');</script>";
            echo "<script>
                document.location='" . base_url() . "/index.php/admin_emails_controller/emails_emails_add'
              </script>";
        }
        else
        {

        if ($mail_proto == 'IMAP/SSL') {
            $mail_protocol = 'IMAP';
            $mail_encryption = 'SSL';
        }

        else if ($mail_proto == 'IMAP' ) {
            $mail_protocol = 'IMAP';
            $mail_encryption = 'NONE';
        }
        else if ($mail_proto == 'POP/SSL') {
            $mail_protocol = 'POP';
            $mail_encryption = 'SSL';
        }

        else if ($mail_proto == 'POP' ) {
            $mail_protocol = 'POP';
            $mail_encryption = 'NONE';
        }

        else{

            $mail_protocol = 'NONE';
            $mail_encryption = 'NONE';

        }

        if($priority_guid == '0'){
            $priority_guid = $default_prio;
        }

        if($dept_guid == '0'){
            $dept_guid = $default_dept;
        }

        if($topic_guid = '0'){
            $topic_guid = $default_help;
        }

        $email_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
        $this->db->query("INSERT INTO ost_email_test 
            (email_guid, email, name, dept_guid, priority_guid, topic_guid, noautoresp, userid, userpass, mail_active, mail_host, mail_port, mail_protocol, mail_encryption, mail_fetchfreq, mail_fetchmax, mail_delete, smtp_active, smtp_host, smtp_port, smtp_auth, smtp_spoofing, notes, created, updated) 
            VALUES 
            ('$email_guid', '$email', '$name', '$dept_guid', '$priority_guid', '$topic_guid', '$noautoresp', '$userid', '$passwd', '$mail_active', '$mail_host', '$mail_port', '$mail_protocol', '$mail_encryption', '$mail_fetchfreq', '$mail_fetchmax', '$postfetch', '$smtp_active', '$smtp_host', '$smtp_port', '$smtp_auth', '$smtp_spoofing', '$notes', NOW(), NOW() );");

        echo "<script> alert('Email added.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_emails' </script>";

        }
    }

    public function emails_emails_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   $email_guid = $_REQUEST['id'];

            $data = array(

                'email' => $this->db->query("SELECT a.notes, a.smtp_spoofing, a.smtp_auth, a.smtp_host, a.smtp_port, a.smtp_active, a.mail_delete, a.mail_fetchmax, a.mail_fetchfreq, a.mail_encryption, a.mail_protocol, a.mail_port, a.mail_host, a.mail_active, a.userid, a.userpass, a.noautoresp, a.dept_guid , a.priority_guid, a.topic_guid, a.email_guid,a.name,a.email,b.priority_desc,c.name as dept_name,a.created,a.updated FROM ost_email_test AS a INNER JOIN ost_ticket_priority_test AS b ON a.priority_guid = b.priority_guid LEFT JOIN ost_department_test AS c ON a.dept_guid = c.department_guid WHERE a.email_guid= '$email_guid ' ")->row(),

                'department' => $this->db->query("SELECT * FROM ost_department_test"),
                'priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                'topic' => $this->db->query("SELECT * FROM ost_help_topic_test"),
                


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
                $this->load->view('admin_emails/admin_emails_emails_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_emails_info_process()

    { 
        $email_guid = $_REQUEST['id'];
     // do priority id and dept id if system default have something wrong and postfetch problem
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $dept_guid = $this->input->post('dept_guid');
        $priority_guid = $this->input->post('priority_guid');
        $topic_guid = $this->input->post('topic_guid');
        $noautoresp = $this->input->post('noautoresp');
        $userid = $this->input->post('userid');
        $passwd = $this->input->post('passwd');
        $mail_active = $this->input->post('mail_active');
        $mail_host = $this->input->post('mail_host');
        $mail_port = $this->input->post('mail_port');
        $mail_proto = $this->input->post('mail_proto');
        $mail_fetchfreq = $this->input->post('mail_fetchfreq');
        $mail_fetchmax = $this->input->post('mail_fetchmax');

        $postfetch = $this->input->post('postfetch');

        $smtp_active = $this->input->post('smtp_active');
        $smtp_host = $this->input->post('smtp_host');
        $smtp_port = $this->input->post('smtp_port');
        $smtp_auth = $this->input->post('smtp_auth');
        $smtp_spoofing = $this->input->post('smtp_spoofing');
        $notes = $this->input->post('notes');

        $default_dept = $this->db->query("SELECT value FROM ost_config_test WHERE id='85'")->row('value');
        $default_prio = $this->db->query("SELECT value FROM ost_config_test WHERE id='9'")->row('value');
        $default_help = $this->db->query("SELECT value FROM ost_config_test WHERE id='102'")->row('value');

        if ($mail_proto == 'IMAP/SSL') {
            $mail_protocol = 'IMAP';
            $mail_encryption = 'SSL';
        }

        else if ($mail_proto == 'IMAP' ) {
            $mail_protocol = 'IMAP';
            $mail_encryption = 'NONE';
        }
        else if ($mail_proto == 'POP/SSL') {
            $mail_protocol = 'POP';
            $mail_encryption = 'SSL';
        }

        else if ($mail_proto == 'POP' ) {
            $mail_protocol = 'POP';
            $mail_encryption = 'NONE';
        }

        else{

            $mail_protocol = 'NONE';
            $mail_encryption = 'NONE';

        }

        

        if($priority_guid == '0'){
            $priority_guid = $default_prio;
        }

        if($dept_guid == '0'){
            $dept_guid = $default_dept;
        }

        if($topic_guid = '0'){
            $topic_guid = $default_help;
        }


        $this->db->query("
        UPDATE ost_email_test SET 
        email = '$email', 
        name = '$name',
        dept_guid = '$dept_guid', 
        priority_guid = '$priority_guid',
        topic_guid = '$topic_guid', 
        noautoresp = '$noautoresp',
        userid = '$userid', 
        userpass = '$passwd',
        mail_active = '$mail_active', 
        mail_host = '$mail_host',
        mail_port = '$mail_port', 
        mail_protocol = '$mail_protocol',
        mail_encryption = '$mail_encryption', 
        mail_fetchfreq = '$mail_fetchfreq',
        mail_fetchmax = '$mail_fetchmax', 
        mail_delete = '$postfetch',
        smtp_active = '$smtp_active', 
        smtp_host = '$smtp_host',
        smtp_port = '$smtp_port', 
        smtp_auth = '$smtp_auth',
        smtp_spoofing = '$smtp_spoofing', 
        notes = '$notes',
        updated = NOW()

        WHERE email_guid = '$email_guid'");

        echo "<script> alert('Email edited.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_emails_info?id=$email_guid' </script>";


    }

    public function emails_settings()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'templategroup' => $this->db->query("SELECT * FROM ost_email_template_group_test"),
                'default_template' => $this->db->query("SELECT value FROM ost_config_test WHERE id='87'")->row('value'),
                'default_email' => $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value'),
                'email_list' => $this->db->query("SELECT * FROM ost_email_test"),
                'admin_email' => $this->db->query("SELECT value FROM ost_config_test WHERE id='1'")->row('value'),
                'verify_email' => $this->db->query("SELECT value FROM ost_config_test WHERE id='116'")->row('value'),
                'strip_quote_reply' => $this->db->query("SELECT value FROM ost_config_test WHERE id='35'")->row('value'),
                'reply_separator' => $this->db->query("SELECT value FROM ost_config_test WHERE id='11'")->row('value'),
                'email_priority' => $this->db->query("SELECT value FROM ost_config_test WHERE id='25'")->row('value'),
                'accept_unregistered' => $this->db->query("SELECT value FROM ost_config_test WHERE id='117'")->row('value'),
                'email_attach' => $this->db->query("SELECT value FROM ost_config_test WHERE id='69'")->row('value'),
                'default_MTA' => $this->db->query("SELECT b.name,b.email FROM ost_config_test a INNER JOIN ost_email_test b ON a.value=b.email_guid WHERE a.id='24';"),

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
                $this->load->view('admin_emails/admin_emails_settings', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_settings_process()
    {  
        $default_template_id = $this->input->post('default_template_id');
        $default_email_guid = $this->input->post('default_email_guid');
        $alert_email_guid = $this->input->post('alert_email_guid');
        $admin_email = $this->input->post('admin_email');
        $verify_email_addrs = $this->input->post('verify_email_addrs');
        $strip_quoted_reply = $this->input->post('strip_quoted_reply');
        $reply_separator = $this->input->post('reply_separator');
        $use_email_priority = $this->input->post('use_email_priority');
        $accept_unregistered_email = $this->input->post('accept_unregistered_email');
        $default_smtp_id = $this->input->post('default_smtp_id');
        $email_attachments = $this->input->post('email_attachments');

       $this->db->query("UPDATE ost_config_test SET value = '$default_template_id', updated = NOW() WHERE id='87' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_email_guid', updated = NOW() WHERE id='83' ");
        $this->db->query("UPDATE ost_config_test SET value = '$alert_email_guid', updated = NOW() WHERE id='84' ");
        $this->db->query("UPDATE ost_config_test SET value = '$admin_email', updated = NOW() WHERE id='1' ");
        $this->db->query("UPDATE ost_config_test SET value = '$verify_email_addrs', updated = NOW() WHERE id='116' ");
        $this->db->query("UPDATE ost_config_test SET value = '$strip_quoted_reply', updated = NOW() WHERE id='35' ");
        $this->db->query("UPDATE ost_config_test SET value = '$reply_separator', updated = NOW() WHERE id='11' ");
        $this->db->query("UPDATE ost_config_test SET value = '$use_email_priority', updated = NOW() WHERE id='25' ");
        $this->db->query("UPDATE ost_config_test SET value = '$accept_unregistered_email', updated = NOW() WHERE id='117' ");
        $this->db->query("UPDATE ost_config_test SET value = '$default_smtp_id', updated = NOW() WHERE id='24' ");
        $this->db->query("UPDATE ost_config_test SET value = '$email_attachments', updated = NOW() WHERE id='69' ");
        

        
        echo "<script> alert('Successfully Save Changes.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_settings' </script>";


    }


    public function emails_banlist()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'filter' => $this->db->query("SELECT * FROM ost_filter_rule_test WHERE what = 'email' "),
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
                $this->load->view('admin_emails/admin_emails_banlist', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_banlist_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_filter_rule_test
                            SET isactive = '$status'
                            WHERE rule_guid = '$value'");
        }

            echo "<script> alert('Status of banned email changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_filter_rule_test WHERE rule_guid='$value' ");

            
        }
            echo "<script> alert('Banned email remove');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_banlist' </script>";


    }

    public function emails_banlist_add()
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
                $this->load->view('headeradmin');
                $this->load->view('admin_emails/admin_emails_banlist_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_banlist_add_process()
    {
        $isactive = $this->input->post('isactive');
        $val = $this->input->post('val');
        $notes = $this->input->post('notes');

        $this->db->query("INSERT INTO ost_filter_rule_test (what, isactive, val, notes, created, updated) VALUES ('email', '$isactive', '$val', '$notes', NOW(), NOW() )");

        echo "<script> alert('Ban email added into list.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_banlist' </script>";
    }

    public function emails_banlist_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $banid = $_REQUEST['id'];


            $data = array(
                
                'baninfo' => $this->db->query("SELECT * FROM ost_filter_rule_test WHERE what = 'email' AND rule_guid= '$banid' ")->row(),

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
                $this->load->view('admin_emails/admin_emails_banlist_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_banlist_info_process()
    {  
        $isactive = $this->input->post('isactive');
        $val = $this->input->post('val');
        $notes = $this->input->post('notes');
        $banid = $_REQUEST['id'];

        $this->db->query("UPDATE ost_filter_rule_test SET 
            isactive = '$isactive', 
            val = '$val',
            notes = '$notes', 
            updated = NOW()
            WHERE rule_guid = '$banid'");

        echo "<script> alert('Ban email edited.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_banlist_info?id=$banid' </script>";
    }

    public function emails_templates()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'templategroup' => $this->db->query("SELECT * FROM ost_email_template_group_test"),
                'default_template_id' => $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'"),
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
                $this->load->view('admin_emails/admin_emails_templates', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_templates_process()
    {  
        $status = $this->input->post('status');
        $tids = $this->input->post('tids[]');

        foreach ($tids as $check)
        {
            if ($status == 1)
            {
                $this->db->query("UPDATE ost_email_template_group_test SET isactive = 1 WHERE tpl_guid = '$check'");
            }
            else if ($status == 0)
            {
                $this->db->query("UPDATE ost_email_template_group_test SET isactive = 0 WHERE tpl_guid = '$check'");
            }
            else if ($status == 2)
            {
                $this->db->query("DELETE FROM ost_email_template_group_test WHERE tpl_guid = '$check'");
            }
        }

        redirect('admin_emails_controller/emails_templates');
    }

    public function emails_templates_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                'email_template_group' => $this->db->query("SELECT * FROM ost_email_template_group_test"),
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
                $this->load->view('admin_emails/admin_emails_templates_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_templates_add_process()
    {  
        $template_name = addslashes($this->input->post('name'));
        $template_status = $this->input->post('isactive');
        $template_clone = $this->input->post('tpl_guid');
        $template_notes = addslashes($this->input->post('notes'));

        $check_template_name = $this->db->query("SELECT * FROM ost_email_template_group_test WHERE name = '$template_name'");

        if (empty($check_template_name->num_rows()))
        {
            $tpl_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row(guid);
            $this->db->query("INSERT INTO ost_email_template_group_test (tpl_guid, isactive, name, lang, notes, created, updated) VALUES ('$tpl_guid', '$template_status', '$template_name', 'en_US', '$template_notes', now(), now())");

            if (!empty($template_clone))
            {
                $this->db->query("INSERT INTO ost_email_template_test (email_tpl_guid, tpl_guid, code_name, subject, body, notes, created, updated) SELECT REPLACE(UPPER(UUID()),'-',''), '$tpl_guid', code_name, subject, body, notes, now(), now() FROM ost_email_template_test WHERE tpl_guid = '$template_clone'");
            }
        }
        else
        {
            echo "<script> alert('Duplicate email template group name.');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_templates_add' </script>";
        }

        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_templates' </script>";
    }

    public function emails_templates_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $template_group_id = $_REQUEST['id'];

            $data = array(
                
                'emails_templates_group_info' => $this->db->query("SELECT * FROM ost_email_template_group_test WHERE tpl_guid = '$template_group_id'"),
                'ticket_end_user_templates' => $this->db->query("SELECT * FROM ost_email_template_test WHERE tpl_guid = '$template_group_id' AND type = 'ticket_end_user'"),
                'ticket_agent_templates' => $this->db->query("SELECT * FROM ost_email_template_test WHERE tpl_guid = '$template_group_id' AND type = 'ticket_agent'"),
                'task_templates' => $this->db->query("SELECT * FROM ost_email_template_test WHERE tpl_guid = '$template_group_id' AND type = 'task'"),
                'default_template_id' => $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'"),

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
                $this->load->view('admin_emails/admin_emails_templates_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_templates_info_process()
    {  
        $template_name = addslashes($this->input->post('name'));
        $template_status = $this->input->post('isactive');
        $template_notes = addslashes($this->input->post('notes'));
        $template_id = $_REQUEST['id'];

        $check_template_name = $this->db->query("SELECT * FROM ost_email_template_group_test WHERE name = '$template_name'");

        if (empty($check_template_name->num_rows()) || $template_id == $check_template_name->row('tpl_guid'))
        {
            $this->db->query("UPDATE ost_email_template_group_test SET isactive = '$template_status', name = '$template_name', notes = '$template_notes', updated = now() WHERE tpl_guid = '$template_id'");
        }
        else
        {
            echo "<script> alert('Duplicate email template group name.');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_templates_info?id=$template_id' </script>";
        }

        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_templates' </script>";
    }

    public function emails_templates_edit()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $template_id = $_REQUEST['code_name'];
            $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');

            $data = array(
                'ticket_end_user_templates' => $this->db->query("SELECT * FROM ost_email_template_test WHERE tpl_guid = '$default_template_id' AND type = 'ticket_end_user'"),
                'ticket_agent_templates' => $this->db->query("SELECT * FROM ost_email_template_test WHERE tpl_guid = '$default_template_id' AND type = 'ticket_agent'"),
                'task_templates' => $this->db->query("SELECT * FROM ost_email_template_test WHERE tpl_guid = '$default_template_id' AND type = 'task'"),
                'email_template_info' => $this->db->query("SELECT * FROM ost_email_template_test WHERE email_tpl_guid = '$template_id'"),
                'company' => $this->db->query("SELECT * FROM ost_company_test"),
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
                $this->load->view('admin_emails/admin_emails_templates_edit', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_templates_edit_process()
    {   
        $template_id = $_REQUEST['id'];
        $email_subject = addslashes($this->input->post('subject'));
        $email_body = addslashes($this->input->post('body'));

        $this->db->query("UPDATE ost_email_template_test SET subject = '$email_subject', body = '$email_body', updated = now() WHERE email_tpl_guid = '$template_id'");

        echo "<script> alert('Successfully updated this message template.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_templates_edit?id=$template_id' </script>";
    }

    public function emails_diagnostic()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'email_list' => $this->db->query("SELECT * FROM ost_email_test"),

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
                $this->load->view('admin_emails/admin_emails_diagnostic', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function emails_diagnostic_process()
    {  
        $email_guid = $this->input->post('email_guid');
        $email = $this->input->post('email');
        $subject = $this->input->post('subj');
        $message = $this->input->post('message');
        $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$email_guid'")->row();
        $this->load->library('email');

        $config = array(
            
            'smtp_user' => $sender_email->userid,
            'smtp_pass' => $sender_email->userpass,
            'smtp_host' => $sender_email->smtp_host,
            'smtp_port' => $sender_email->smtp_port,
            
        );

        $this->email->initialize($config);
        $this->email->from($sender_email->userid); 
        $this->email->reply_to($sender_email->userid);    // Optional, an account where a human being reads.
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $result = $this->email->send();

        if($result == true){
            echo "<script> alert('Test Email Sent Successfully.');</script>";
        }else{
            echo "<script> alert('Test Email Does Not Sent Out.');</script>";
        }
        echo "<script> document.location='" . base_url() . "/index.php/admin_emails_controller/emails_diagnostic'</script>";
    


    }
    
}
?>