<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_manage_controller extends CI_Controller {
    
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


    public function manage_helptopics()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'helptopic' => $this->db->query("SELECT * FROM ost_help_topic_test"),
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
                $this->load->view('admin/admin_manage_helptopics', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_helptopics_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_help_topic_test
                            SET isactive = '$status'
                            WHERE topic_guid = '$value'");
        }

            echo "<script> alert('Status of help topic changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_help_topic_test WHERE topic_guid='$value' ");

            //have to do delete child list item too
        }
            echo "<script> alert('Help topic deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_helptopics' </script>";


    }

    public function manage_helptopics_add()
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
                $this->load->view('admin/admin_manage_helptopics_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

     public function manage_helptopics_add_process()

    {  
         $topic = $this->input->post('topic');
         $isactive = $this->input->post('isactive');
         $ispublic = $this->input->post('ispublic');
         $notes = $this->input->post('notes');

         $this->db->query("INSERT ost_help_topic_test ( topic_guid, topic, isactive , ispublic, notes, created, updated )
                        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$topic', '$isactive', '$ispublic', '$notes', NOW(), NOW() ) ");

         echo "<script> alert('Help topic added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_helptopics' </script>";

    }

    public function manage_helptopics_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $helptopicid = $_REQUEST['id'];
            $data = array(

                'helptopic' => $this->db->query("SELECT * FROM ost_help_topic_test WHERE topic_guid = '$helptopicid' " )->row(),
                


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
                $this->load->view('admin/admin_manage_helptopics_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_helptopics_info_process()

    {  
         $topic = $this->input->post('topic');
         $isactive = $this->input->post('isactive');
         $ispublic = $this->input->post('ispublic');
         $notes = $this->input->post('notes');
         $topicid = $_REQUEST['id'];

         $this->db->query("UPDATE ost_help_topic_test
                            SET topic = '$topic', 
                            isactive = '$isactive', 
                            ispublic = '$ispublic',
                            notes = '$notes'
                            WHERE topic_guid = '$topicid';");

         echo "<script> alert('Help topic edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_helptopics_info?id=$topicid' </script>";

    }

     public function manage_subtopics()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'listitem' => $this->db->query("SELECT * FROM ost_list_items_test WHERE topic_guid != '' "),
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
                $this->load->view('admin/admin_manage_subtopics', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_subtopics_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_list_items_test WHERE list_item_guid='$value' ");

            
        }
            echo "<script> alert('subtopics deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_subtopics' </script>";


    }

    public function manage_subtopics_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                
                'topic' => $this->db->query("SELECT * FROM ost_help_topic_test ORDER BY topic"),

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
                $this->load->view('admin/admin_manage_subtopics_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_subtopics_add_process()

    {    $name = $this->input->post('name');
         $helptopic = addslashes($this->input->post('topicId'));
         $notes = $this->input->post('notes');

     

         $this->db->query("INSERT ost_list_items_test ( list_item_guid, value, topic_guid, notes ,created ,updated)
                        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$name', '$helptopic', '$notes',NOW(),NOW()) ");

         echo "<script> alert('Subtopics added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_subtopics' </script>";

    }

    public function manage_subtopics_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $subtopicid = $_REQUEST['id'];
            $data = array(

                'subtopic' => $this->db->query("SELECT * FROM ost_list_items_test WHERE list_item_guid = '$subtopicid' " )->row(),
                'topic' => $this->db->query("SELECT * FROM ost_help_topic_test ORDER BY topic"),
                


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
                $this->load->view('admin/admin_manage_subtopics_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_subtopics_info_process()

    {  
         $name = $this->input->post('name');
         $topic = $this->input->post('topicId');
         $notes = $this->input->post('notes');
         $subtopicid = $_REQUEST['id'];
         
         $this->db->query("UPDATE ost_list_items_test
                            SET value = '$name', 
                            topic_guid = '$topic',
                            notes = '$notes'
                            WHERE list_item_guid = '$subtopicid';");

         echo "<script> alert('Sub Topic edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_subtopics_info?id=$subtopicid' </script>";

    }

    public function manage_sla()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'sla' => $this->db->query("SELECT * FROM ost_sla_test"),
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
                $this->load->view('admin/admin_manage_sla', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_sla_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_sla_test
                            SET isactive = '$status'
                            WHERE sla_guid = '$value'");
        }

            echo "<script> alert('Status of SLA changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_sla_test WHERE sla_guid='$value' ");

            
        }
            echo "<script> alert('SLA deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_sla' </script>";


    }

    public function manage_sla_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'sla' => $this->db->query("SELECT * FROM ost_sla_test"),
                


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
                $this->load->view('admin/admin_manage_sla_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_sla_add_process()

    {  
         $name = $this->input->post('name');
         $grace_period = $this->input->post('grace_period');
         $isactive = $this->input->post('isactive');
         $notes = $this->input->post('notes');

         $this->db->query("INSERT ost_sla_test ( sla_guid, sla_name, grace_period , isactive, notes, created, updated )
                        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$name', '$grace_period', '$isactive', '$notes', NOW(), NOW() ) ");

         echo "<script> alert('SLA added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_sla' </script>";

    }

     public function manage_sla_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $subtopicid = $_REQUEST['id'];
            $data = array(

                'sla' => $this->db->query("SELECT * FROM ost_sla_test WHERE sla_guid = '$subtopicid' " )->row(),
                


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
                $this->load->view('admin/admin_manage_sla_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_sla_info_process()

    {  
         $name = $this->input->post('name');
         $grace_period = $this->input->post('grace_period');
         $isactive = $this->input->post('isactive');
         $notes = $this->input->post('notes');
         $slaid = $_REQUEST['id'];

         
         $this->db->query("UPDATE ost_sla_test
                            SET sla_name = '$name', 
                            grace_period = '$grace_period',
                            isactive = '$isactive',
                            notes = '$notes'
                            WHERE sla_guid = '$slaid';");

         echo "<script> alert('SLA edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_sla_info?id=$slaid' </script>";

    }

    public function manage_api()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

                'api' => $this->db->query("SELECT * FROM ost_api_key_test"),
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
                $this->load->view('admin/admin_manage_api', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_api_process()

    {  
        $status = $this->input->post('status');
        $check = $this->input->post('tids[]');


        if ($status != 2) {

            foreach ($check as $value) {

            $this->db->query("UPDATE ost_api_key_test
                            SET isactive = '$status'
                            WHERE api_key_id = '$value'");
        }

            echo "<script> alert('Status of API key changed');</script>";
        }
            

        elseif ($status == 2) {
            foreach ($check as $value) {

            $this->db->query("DELETE FROM ost_api_key_test WHERE api_key_id='$value' ");

            
        }
            echo "<script> alert('API key deleted');</script>";
        }
        

        
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_api' </script>";


    }

    public function manage_api_add()
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
                $this->load->view('admin/admin_manage_api_add', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_api_add_process()

    {    $isactive = $this->input->post('isactive');
         $ipaddr = $this->input->post('ipaddr');
         $can_create_tickets = $this->input->post('can_create_tickets');
         $can_exec_cron = $this->input->post('can_exec_cron');
         $notes = $this->input->post('notes');
         $key = implode(str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

         $api_key_id = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
         $this->db->query("INSERT ost_api_key_test ( api_key_id, isactive, ipaddr , can_create_tickets, can_exec_cron,notes, updated, created, apikey )
                        VALUES ( '$api_key_id', '$isactive', '$ipaddr', '$can_create_tickets','$can_exec_cron', '$notes', NOW(), NOW(), '$key'  ) ");

         echo "<script> alert('API key added');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_api' </script>";

    }

    public function manage_api_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $apiid = $_REQUEST['id'];
            $data = array(

                'api' => $this->db->query("SELECT * FROM ost_api_key_test WHERE api_key_id = '$apiid' " )->row(),
                


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
                $this->load->view('admin/admin_manage_api_info', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function manage_api_info_process()

    {   $isactive = $this->input->post('isactive');
        $can_create_tickets = $this->input->post('can_create_tickets');
        $can_exec_cron = $this->input->post('can_exec_cron');
        $notes = $this->input->post('notes');
        $apiid = $_REQUEST['id'];

         
         $this->db->query("UPDATE ost_api_key_test
                            SET isactive = '$isactive', 
                            can_create_tickets = '$can_create_tickets',
                            can_exec_cron = '$can_exec_cron',
                            notes = '$notes'
                            WHERE api_key_id = '$apiid';");

         echo "<script> alert('API key edited');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_api_info?id=$apiid' </script>";
    }

    public function manage_pages()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                'pages' => $this->db->query("SELECT * FROM ost_content_test WHERE field = 'pages'"),
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
                $this->load->view('admin/admin_manage_pages', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function manage_pages_status_process()
    {   
        $pids = $this->input->post('pids[]');
        $enable = $this->input->post('enable');
        $disable = $this->input->post('disable');
        $delete = $this->input->post('delete');

        foreach ($pids as $pagesid)
        {
            $inuse = $this->db->query("SELECT * FROM ost_content_test WHERE content_guid = '$pagesid'")->row('in_use');

            if ($enable == '1')
            {
                $this->db->query("UPDATE ost_content_test SET isactive = '1' WHERE content_guid = '$pagesid'");
            }
            elseif ($disable == '1')
            {
                if ($inuse == '0')
                {
                    $this->db->query("UPDATE ost_content_test SET isactive = '0' WHERE content_guid = '$pagesid'");
                }
                else
                {
                    echo "<script> alert('One or more of the selected site pages is in-use and CANNOT be disabled');</script>";
                }
            }
            elseif ($delete == '1')
            {
                if ($inuse == '0')
                {
                    $this->db->query("DELETE FROM ost_content_test WHERE content_guid = '$pagesid'");
                }
                else
                {
                    echo "<script> alert('One or more of the selected site pages is in-use and CANNOT be deleted');</script>";
                }
            }
        }

        echo "<script> document.location='" . base_url() . "/index.php/admin_manage_controller/manage_pages' </script>";
    }

    public function manage_pages_addupdate()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $pagesid = $_REQUEST['id'];

            $data = array(
                'pages' => $this->db->query("SELECT * FROM ost_content_test WHERE content_guid = '$pagesid'"),
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
                $this->load->view('admin/admin_manage_pages_addupdate', $data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function manage_pages_addnew_process()
    {   
        $name = addslashes($this->input->post('name'));
        $type = $this->input->post('type');
        $isactive = $this->input->post('isactive');
        $content = addslashes($this->input->post('content'));
        $notes = addslashes($this->input->post('notes'));

        $content_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
        $this->db->query("INSERT INTO ost_content_test (content_guid, isactive, field, type, name, body, notes, created, updated)
        VALUES ('$content_guid', '$isactive', 'pages', '$type', '$name', '$content', '$notes', now(), now())");

        redirect('admin_manage_controller/manage_pages');
    }

    public function manage_pages_update_process()
    {   
        $pagesid = $_REQUEST['id'];
        $name = addslashes($this->input->post('name'));
        $type = $this->input->post('type');
        $isactive = $this->input->post('isactive');
        $content = addslashes($this->input->post('content'));
        $notes = addslashes($this->input->post('notes'));

        $this->db->query("UPDATE ost_content_test SET isactive = '$isactive', type = '$type', name = '$name', body = '$content', notes = '$notes', updated = now() WHERE content_guid = '$pagesid'");

        redirect('admin_manage_controller/manage_pages');
    }
}
?>