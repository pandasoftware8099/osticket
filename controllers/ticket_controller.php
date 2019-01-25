<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_controller extends CI_Controller {
    
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
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

        $userid = $_SESSION["userid"];

        $userinfo = $this->db->query("SELECT * FROM ost_organization_test AS a
            LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$userid'");

        if (($userinfo->row('ticketsharing') == '1' && $userinfo->row('user_primary') == '1') || $userinfo->row('ticketsharing') == '2')
        {
            $orgid = $userinfo->row('user_org_guid');

            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                    WHERE d.user_org_guid = $orgid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.topic_guid = b.topic_guid
                    LEFT JOIN ost_user_test AS c ON b.user_guid = c.user_guid
                    WHERE c.user_org_guid = $orgid GROUP BY b.topic_guid ORDER BY topic"),
                'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                    WHERE d.user_org_guid = $orgid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                    WHERE d.user_org_guid = $orgid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            );
        }
        else
        {
            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                    WHERE user_guid = $userid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test
                    INNER JOIN ost_ticket_test  ON ost_help_topic_test.topic_guid = ost_ticket_test.topic_guid
                    WHERE user_guid = $userid GROUP BY ost_ticket_test.topic_guid ORDER BY topic "),
                'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    WHERE user_guid = $userid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    WHERE user_guid = $userid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            );
        }


        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('viewt/ticket_main',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function info()
    {     
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
        $ticketid = $_REQUEST['id'];


        $data = array(
            'result' => $this->db->query("SELECT * FROM  ost_ticket_test  
                INNER JOIN ost_help_topic_test  ON ost_help_topic_test.topic_guid = ost_ticket_test.topic_guid 
                INNER JOIN ost_ticket_status_test  ON ost_ticket_status_test.status_guid = ost_ticket_test.status_guid 
                INNER JOIN ost_list_items_test  ON ost_ticket_test.subtopic_guid = ost_list_items_test.list_item_guid 
                WHERE ticket_guid = '$ticketid'"),

            'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test 
                WHERE ticket_guid = '$ticketid' AND type != 'N' GROUP BY created"),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test INNER JOIN ost_ticket_test ON ost_user_test.user_guid = ost_ticket_test.user_guid WHERE ticket_guid = '$ticketid'"),

            'editticket' => $this->db->query("SELECT * FROM  ost_ticket_test WHERE ticket_guid = '$ticketid'"),

            'openclose' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row(),

            'threadname' => $this->db->query("SELECT * FROM ost_staff_test AS a
                    INNER JOIN ost_thread_entry_test AS b ON a.staff_guid = b.staff_guid
                    INNER JOIN ost_ticket_test AS c ON b.`ticket_guid` = c.`ticket_guid`
                    INNER JOIN ost_department_test AS d ON a.dept_guid = d.department_guid
                    
                    WHERE c.ticket_guid = '$ticketid'")->row(),

            'departmt' => $this->db->query("SELECT * FROM  ost_department_test AS a INNER JOIN ost_user_test AS b ON a.department_guid = b.user_depart INNER JOIN ost_ticket_test AS c ON b.user_guid = c.user_guid WHERE ticket_guid = '$ticketid'")->row(),

            'enable_avatars' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '93'"),

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
                $this->load->view('header');
                $this->load->view('viewt/ticket_info' ,$data);
                /*$this->load->view('footer');*/
            }

        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function StatusUpdate()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $ticketid = $this->input->post('id');
            $description = addslashes($this->input->post('message'));
            $userid = $_SESSION['userid'];
            $username = $_SESSION['username'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];

            $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , user_guid , type, poster , body , ip_address, created, updated, class, avatar )
            VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$userid', 'U' ,'$username', '$description', '$ipaddress', now(), now(), 'message', 'right')");

            $solve = $this->input->post('solve');
            $this->db->query("UPDATE ost_ticket_test SET status_guid = '$solve', ticket_updated = now(), ticket_updated_by_id = '$userid', ticket_updated_by_role = 'user' WHERE ticket_guid = '$ticketid' ");

            $message_autoresponder = $this->db->query("SELECT value FROM ost_config_test WHERE id='37'")->row('value');
            $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
            $user_info = $this->db->query("SELECT * FROM ost_user_test WHERE user_guid = '$userid'");
            $ticket_info = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");

            if(isset($_POST['submit'])){
     
                // Count total files
                $countfiles = count($_FILES['file']['name']);

                // Looping all files
                for($i=0;$i<$countfiles;$i++){

                    if ($_FILES['file']['name'][0] != "") {

                        $thread_id = $this->db->query("SELECT thread_entry_guid as id FROM ost_thread_entry_test WHERE created = (SELECT max(created) FROM ost_thread_entry_test)")->row('id');

                        $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                            // Upload file
                        move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                        $this->db->query("INSERT ost_file_test ( file_guid, name, created , thread_entry_guid )
                        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");

                        echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                    }
                    else
                    {
                        echo "<script> alert('Message successfully sent.');</script>"; 
                    }
                }
            }

            if ($message_autoresponder == '1')
            {
                $data = array(
                    'body' => $this->db->query("SELECT REPLACE(REPLACE(body, '%user_name%', '".$user_info->row('user_name')."'), '%number%', '".$ticket_info->row('number')."') AS email, subject FROM ost_email_template_test WHERE code_name = 'message.autoresp' AND tpl_guid = '$default_template_id'"),
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
                ->to($user_info->row('user_email'))
                ->subject($data['body']->row('subject'))
                ->message($bodyContent)
                ->send();
            }

            redirect('ticket_controller/info?id='.$ticketid);
        }
        else       
        {
           redirect('user_controller/login');
        }
    }


    public function searchticket()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $userid = $_SESSION["userid"];

            $search_value = $this->input->post('keywords');
            $search_topic = $this->input->post('searchtopic');

            $userinfo = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$userid'");

            if (($userinfo->row('ticketsharing') == '1' && $userinfo->row('user_primary') == '1') || $userinfo->row('ticketsharing') == '2')
            {
                $orgid = $userinfo->row('user_org_guid');
                
                if($search_value && $search_topic != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                        WHERE d.user_org_guid = $orgid AND a.`number` = '$search_value' AND a.`topic_guid` = '$search_topic' ORDER BY ticket_guid DESC");
                }
                else if($search_value != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a 
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                        WHERE d.user_org_guid = $orgid AND `number` = '$search_value' ORDER BY ticket_guid DESC");                 
                }
                else if($search_topic != '')
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                        WHERE d.user_org_guid = $orgid AND b.`topic_guid` = '$search_topic' ORDER BY ticket_guid DESC");
                }
                else
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                        WHERE d.user_org_guid = $orgid ORDER BY ticket_guid DESC");
                }
     
                $data = array(
                    'result' => $filter_data,
                    'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                        INNER JOIN ost_ticket_test AS b ON a.topic_guid = b.topic_guid
                        LEFT JOIN ost_user_test AS c ON b.user_guid = c.user_guid
                        WHERE c.user_org_guid = $orgid GROUP BY b.topic_guid ORDER BY topic"),
                    'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                        LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                        WHERE d.user_org_guid = $orgid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                    'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                        LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                        WHERE d.user_org_guid = $orgid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
                );
            }
            else
            {
                if($search_value && $search_topic != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM  ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        WHERE user_guid = '$userid' AND a.`number` = '$search_value' AND a.`topic_guid` = '$search_topic' ORDER BY ticket_guid DESC");
                }
                else if($search_value != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a 
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        WHERE user_guid = '$userid' AND `number` = '$search_value' ORDER BY ticket_guid DESC");                 
                }
                else if($search_topic != '')
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        WHERE user_guid = '$userid' AND b.`topic_guid` = '$search_topic' ORDER BY ticket_guid DESC");
                }
                else
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        WHERE user_guid = '$userid' ORDER BY ticket_guid DESC");
                }
     
                $data = array(
                    'result' => $filter_data,
                    'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                        INNER JOIN ost_ticket_test AS b ON a.topic_guid = b.topic_guid
                        WHERE user_guid = $userid GROUP BY b.topic_guid ORDER BY topic"),
                    'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a 
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        WHERE user_guid = $userid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                    'closed_count' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                        INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                        WHERE user_guid = $userid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
                );
            }

            $browser_id = $_SERVER["HTTP_USER_AGENT"];

            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                {

                    /*$this->load->view('WinCe/header');
                    $this->load->view('WinCe/po/po_main',$data);*/
                    
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('viewt/ticket_main',$data);
                    /*$this->load->view('footer');*/
                }    

            }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function closed()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

        $userid = $_SESSION["userid"];    

        $userinfo = $this->db->query("SELECT * FROM ost_organization_test AS a
            LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$userid'");

        if (($userinfo->row('ticketsharing') == '1' && $userinfo->row('user_primary') == '1') || $userinfo->row('ticketsharing') == '2')
        {
            $orgid = $userinfo->row('user_org_guid');

            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                    WHERE d.user_org_guid = $orgid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
                'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.topic_guid = b.topic_guid
                    LEFT JOIN ost_user_test AS c ON b.user_guid = c.user_guid
                    WHERE c.user_org_guid = $orgid GROUP BY b.topic_guid ORDER BY topic"),
                'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                    WHERE d.user_org_guid = $orgid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    LEFT JOIN ost_user_test AS d ON a.user_guid = d.user_guid
                    WHERE d.user_org_guid = $orgid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
            );
        }
        else
        {
            $data = array(
                'result' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid
                    WHERE user_guid = $userid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
                'helptopic' => $this->db->query("SELECT * FROM ost_help_topic_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.topic_guid = b.topic_guid
                    WHERE user_guid = $userid GROUP BY b.topic_guid ORDER BY topic "),
                'open_count' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                    WHERE user_guid = $userid AND c.state = 'open' ORDER BY ticket_guid DESC"),
                'closed_count' => $this->db->query("SELECT * FROM ost_ticket_test AS a 
                    INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                    INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                    WHERE user_guid = $userid AND c.state = 'closed' ORDER BY ticket_guid DESC"),
            );
        }

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('viewt/ticket_main',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function printpreview()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

        $ticketid = $_REQUEST['id'];
        $userid = $_SESSION["userid"];    
        $data = array(
            
            'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
                INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                WHERE a.ticket_guid = '$ticketid'"),

            'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test WHERE ticket_guid = '$ticketid' GROUP BY created"),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test INNER JOIN ost_ticket_test ON ost_user_test.user_guid = ost_ticket_test.user_guid WHERE ticket_guid = '$ticketid'"),
        );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                /*$this->load->view('header');*/
                $this->load->view('viewt/printpreview',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function ticketedit()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $ticketid = $_REQUEST['id'];

            $data = array(

                'cinfo' => $this->db->query("SELECT * FROM  ost_ticket_test WHERE ticket_guid = '$ticketid'"),

                'inventory' => $this->db->query("SELECT * FROM  ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.topic_guid = b.topic_guid INNER JOIN ost_ticket_test AS c ON b.topic_guid = c.topic_guid WHERE c.ticket_guid = '$ticketid'"),

                'subt' => $this->db->query("SELECT * FROM  ost_list_items_test INNER JOIN ost_ticket_test ON ost_list_items_test.list_item_guid = ost_ticket_test.subtopic_guid WHERE ticket_guid = '$ticketid'"),
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                    
            }
            else
            {
                $this->load->view('header');
                $this->load->view('viewt/ticket_edit', $data);
                    /*$this->load->view('footer');*/
            }    
        }

        else       
        {
            redirect('user_controller/login');
        }

    }

    public function EditUpdate()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $ticketid = $this->input->post('id');
            $company_name = $this->input->post('companyname');
            $issue_summary = $this->input->post('issuesummary');
            $phone_no = $this->input->post('phoneno');
            $phone_no_ext = $this->input->post('phonenoext');
            $sub_inventory = $this->input->post('subinventory');
            $userid = $_SESSION['userid'];

            $this->db->query("UPDATE ost_ticket_test SET subtopic_guid = '$sub_inventory', contact = '$company_name', issue_summary = '$issue_summary', phone_no = '$phone_no', phone_no_ext = '$phone_no_ext', ticket_updated = now(), ticket_updated_by_id = '$userid', ticket_updated_by_role = 'user' WHERE ticket_guid = '$ticketid'");

            redirect('ticket_controller/info?id='.$ticketid);
        }

        else       
        {
           redirect('user_controller/login');
        }
    }
}
?>

