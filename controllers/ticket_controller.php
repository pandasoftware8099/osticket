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
            LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$userid'");

        if (($userinfo->row('ticketsharing') == '1' && $userinfo->row('user_primary') == '1') || $userinfo->row('ticketsharing') == '2')
        {
            $orgid = $userinfo->row('user_org_id');

            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                    WHERE d.user_org_id = $orgid AND c.state = 'open' ORDER BY ticket_id DESC"),
                'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.topic_id = b.topic_id
                    LEFT JOIN ost_user_test AS c ON b.user_id = c.user_id
                    WHERE c.user_org_id = $orgid GROUP BY b.topic_id ORDER BY topic"),
                'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                    WHERE d.user_org_id = $orgid AND c.state = 'open' ORDER BY ticket_id DESC"),
                'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                    WHERE d.user_org_id = $orgid AND c.state = 'closed' ORDER BY ticket_id DESC"),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            );
        }
        else
        {
            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id 
                    WHERE user_id = $userid AND c.state = 'open' ORDER BY ticket_id DESC"),
                'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test
                    INNER JOIN ost_ticket_test  ON ost_help_topic_test.topic_id = ost_ticket_test.topic_id
                    WHERE user_id = $userid GROUP BY ost_ticket_test.topic_id ORDER BY topic "),
                'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    WHERE user_id = $userid AND c.state = 'open' ORDER BY ticket_id DESC"),
                'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    WHERE user_id = $userid AND c.state = 'closed' ORDER BY ticket_id DESC"),
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
                INNER JOIN ost_help_topic_test  ON ost_help_topic_test.topic_id = ost_ticket_test.topic_id 
                INNER JOIN ost_ticket_status_test  ON ost_ticket_status_test.id = ost_ticket_test.status_id 
                INNER JOIN ost_list_items_test  ON ost_ticket_test.subtopic_id = ost_list_items_test.id 
                WHERE ticket_id = $ticketid"),

            'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test 
                WHERE ticket_id = $ticketid AND type != 'N'"),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test INNER JOIN ost_ticket_test ON ost_user_test.user_id = ost_ticket_test.user_id WHERE ticket_id = '$ticketid'"),

            'editticket' => $this->db->query("SELECT * FROM  ost_ticket_test WHERE ticket_id = $ticketid"),

            'openclose' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = $ticketid")->row(),

            'threadname' => $this->db->query("SELECT * FROM ost_staff_test AS a
                    INNER JOIN ost_thread_entry_test AS b ON a.staff_id = b.staff_id
                    INNER JOIN ost_ticket_test AS c ON b.`ticket_id` = c.`ticket_id`
                    INNER JOIN ost_department_test AS d ON a.dept_id = d.id
                    
                    WHERE c.ticket_id = $ticketid")->row(),

            'departmt' => $this->db->query("SELECT * FROM  ost_department_test AS a INNER JOIN ost_user_test AS b ON a.id = b.user_depart INNER JOIN ost_ticket_test AS c ON b.user_id = c.user_id WHERE ticket_id = $ticketid")->row(),

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

            $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , user_id , type, poster , body , ip_address, created, updated, class, avatar )
            VALUES ('$ticketid' ,'$userid', 'U' ,'$username', '$description', '$ipaddress', now(), now(), 'message', 'right')");

            $solve = $this->input->post('solve');
            $this->db->query("UPDATE ost_ticket_test SET status_id = '$solve', ticket_updated = now(), ticket_updated_by_id = '$userid', ticket_updated_by_role = 'user' WHERE ticket_id = '$ticketid' ");

            $message_autoresponder = $this->db->query("SELECT value FROM ost_config_test WHERE id='37'")->row('value');
            $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
            $user_info = $this->db->query("SELECT * FROM ost_user_test WHERE user_id = '$userid'");
            $ticket_info = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$ticketid'");

            if(isset($_POST['submit'])){
     
                // Count total files
                $countfiles = count($_FILES['file']['name']);

                // Looping all files
                for($i=0;$i<$countfiles;$i++){

                    if ($_FILES['file']['name'][0] != "") {

                        $thread_id = $this->db->query("SELECT id FROM ost_thread_entry_test WHERE created = now() ")->row('id');

                        $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                            // Upload file
                        move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                        $this->db->query("INSERT ost_file_test ( name, created , thread_entry_id )
                        VALUES ( '$filename', NOW(), '$thread_id' ) ");

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
                    'body' => $this->db->query("SELECT REPLACE(REPLACE(body, '%user_name%', '".$user_info->row('user_name')."'), '%number%', '".$ticket_info->row('number')."') AS email, subject FROM ost_email_template_test WHERE code_name = 'message.autoresp' AND tpl_id = '$default_template_id'"),
                    'template' => $this->db->query("SELECT * FROM ost_company_test"),
                );
                
                $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
                $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_id='$default_email'")->row();

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
                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$userid'");

            if (($userinfo->row('ticketsharing') == '1' && $userinfo->row('user_primary') == '1') || $userinfo->row('ticketsharing') == '2')
            {
                $orgid = $userinfo->row('user_org_id');
                
                if($search_value && $search_topic != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                        WHERE d.user_org_id = $orgid AND a.`number` = '$search_value' AND a.`topic_id` = '$search_topic' ORDER BY ticket_id DESC");
                }
                else if($search_value != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a 
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                        WHERE d.user_org_id = $orgid AND `number` = '$search_value' ORDER BY ticket_id DESC");                 
                }
                else if($search_topic != '')
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                        WHERE d.user_org_id = $orgid AND b.`topic_id` = '$search_topic' ORDER BY ticket_id DESC");
                }
                else
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                        WHERE d.user_org_id = $orgid ORDER BY ticket_id DESC");
                }
     
                $data = array(
                    'result' => $filter_data,
                    'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                        INNER JOIN ost_ticket_test AS b ON a.topic_id = b.topic_id
                        LEFT JOIN ost_user_test AS c ON b.user_id = c.user_id
                        WHERE c.user_org_id = $orgid GROUP BY b.topic_id ORDER BY topic"),
                    'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                        LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                        WHERE d.user_org_id = $orgid AND c.state = 'open' ORDER BY ticket_id DESC"),
                    'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                        LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                        WHERE d.user_org_id = $orgid AND c.state = 'closed' ORDER BY ticket_id DESC"),
                );
            }
            else
            {
                if($search_value && $search_topic != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM  ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        WHERE user_id = '$userid' AND a.`number` = '$search_value' AND a.`topic_id` = '$search_topic' ORDER BY ticket_id DESC");
                }
                else if($search_value != '')
                {
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a 
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        WHERE user_id = '$userid' AND `number` = '$search_value' ORDER BY ticket_id DESC");                 
                }
                else if($search_topic != '')
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        WHERE user_id = '$userid' AND b.`topic_id` = '$search_topic' ORDER BY ticket_id DESC");
                }
                else
                {                   
                    $filter_data = $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        WHERE user_id = '$userid' ORDER BY ticket_id DESC");
                }
     
                $data = array(
                    'result' => $filter_data,
                    'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                        INNER JOIN ost_ticket_test AS b ON a.topic_id = b.topic_id
                        WHERE user_id = $userid GROUP BY b.topic_id ORDER BY topic"),
                    'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a 
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        WHERE user_id = $userid AND c.state = 'open' ORDER BY ticket_id DESC"),
                    'closed_count' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                        INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                        INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                        WHERE user_id = $userid AND c.state = 'closed' ORDER BY ticket_id DESC"),
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
            LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$userid'");

        if (($userinfo->row('ticketsharing') == '1' && $userinfo->row('user_primary') == '1') || $userinfo->row('ticketsharing') == '2')
        {
            $orgid = $userinfo->row('user_org_id');

            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                    WHERE d.user_org_id = $orgid AND c.state = 'closed' ORDER BY ticket_id DESC"),
                'helptopic' => $this->db->query("SELECT * FROM  ost_help_topic_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.topic_id = b.topic_id
                    LEFT JOIN ost_user_test AS c ON b.user_id = c.user_id
                    WHERE c.user_org_id = $orgid GROUP BY b.topic_id ORDER BY topic"),
                'open_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                    WHERE d.user_org_id = $orgid AND c.state = 'open' ORDER BY ticket_id DESC"),
                'closed_count' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    LEFT JOIN ost_user_test AS d ON a.user_id = d.user_id
                    WHERE d.user_org_id = $orgid AND c.state = 'closed' ORDER BY ticket_id DESC"),
            );
        }
        else
        {
            $data = array(
                'result' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id
                    WHERE user_id = $userid AND c.state = 'closed' ORDER BY ticket_id DESC"),
                'helptopic' => $this->db->query("SELECT * FROM ost_help_topic_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.topic_id = b.topic_id
                    WHERE user_id = $userid GROUP BY b.topic_id ORDER BY topic "),
                'open_count' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                    WHERE user_id = $userid AND c.state = 'open' ORDER BY ticket_id DESC"),
                'closed_count' => $this->db->query("SELECT * FROM ost_ticket_test AS a 
                    INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                    INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                    WHERE user_id = $userid AND c.state = 'closed' ORDER BY ticket_id DESC"),
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
                INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                WHERE a.ticket_id = $ticketid"),

            'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test WHERE ticket_id = $ticketid"),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test INNER JOIN ost_ticket_test ON ost_user_test.user_id = ost_ticket_test.user_id WHERE ticket_id = '$ticketid'"),
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

                'cinfo' => $this->db->query("SELECT * FROM  ost_ticket_test WHERE ticket_id = $ticketid"),

                'inventory' => $this->db->query("SELECT * FROM  ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.topic_id = b.topic_id INNER JOIN ost_ticket_test AS c ON b.topic_id = c.topic_id WHERE c.ticket_id = $ticketid"),

                'subt' => $this->db->query("SELECT * FROM  ost_list_items_test INNER JOIN ost_ticket_test ON ost_list_items_test.id = ost_ticket_test.subtopic_id WHERE ticket_id = $ticketid"),
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

            $this->db->query("UPDATE ost_ticket_test SET subtopic_id = '$sub_inventory', company_name = '$company_name', issue_summary = '$issue_summary', phone_no = '$phone_no', phone_no_ext = '$phone_no_ext', ticket_updated = now(), ticket_updated_by_id = '$userid', ticket_updated_by_role = 'user' WHERE ticket_id = '$ticketid'");

            redirect('ticket_controller/info?id='.$ticketid);
        }

        else       
        {
           redirect('user_controller/login');
        }
    }
}
?>

