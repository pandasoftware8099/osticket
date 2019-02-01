<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Open_model');
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
            $default_topic = $this->db->query("SELECT value FROM ost_config_test WHERE id ='102'");

            $data = array(
                'topic' => $this->db->query("SELECT * FROM ost_help_topic_test ORDER BY topic"),
                'default_help_topic' => $default_topic,
                'current_sub' => $this->db->query("SELECT list_item_guid, value FROM ost_list_items_test WHERE topic_guid = '".$default_topic->row('value')."' ORDER BY value"),
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
                $this->load->view('opent/open_main' ,$data);
                $this->load->view('footer');
            }    

        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function create()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $subject = addslashes($this->input->post('topicId'));
            $description = $this->input->post('message');
            $subtopic = addslashes($this->input->post('subtopic'));
            $userid = $_SESSION['userid'];
            $username = $_SESSION['username'];
            $userdepname = $_SESSION['userdepname'];
            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_guid = b.status_guid WHERE a.user_guid = '$userid' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');
            $ticket_autoresponder = $this->db->query("SELECT value FROM ost_config_test WHERE id='36'")->row('value');
            $overlimit_notice_active = $this->db->query("SELECT value FROM ost_config_test WHERE id='68'")->row('value');
            $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');

            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                $result = $this->Open_model->add_process($subject, $subtopic, $description, $userid, $userdepname, $username);

                $ticket_info = $this->db->query("SELECT b.user_name, b.user_email FROM ost_ticket_test AS a
                    INNER JOIN ost_user_test AS b ON a.user_guid = b.user_guid 
                    WHERE number = '$result'");

                if(isset($_POST['submit']))
                {
     
                // Count total files
                $countfiles = count($_FILES['file']['name']);

                // Looping all files
                    for($i=0;$i<$countfiles;$i++){

                        if ($_FILES['file']['name'][0] != "") {

                            $thread_id = $this->db->query("SELECT thread_entry_guid as id FROM ost_thread_entry_test WHERE created = (SELECT max(created) FROM ost_thread_entry_test)")->row('id');


                            $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                                // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                            $this->db->query("INSERT ost_file_test (file_guid, name, created , thread_entry_guid )
                            VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");

                            echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                        }

                        else {

                            echo "<script> alert('Message successfully sent.');</script>"; 

                        }
                    }
                }

                $body = array();
                if ($ticket_autoresponder == '1')
                {
                    $body_ticket_autoresponder = $this->db->query("SELECT REPLACE(subject, '%number%', '$result') AS email_subject,
                        REPLACE(REPLACE(body, '%user_name%', '".$ticket_info->row('user_name')."'), '%number%', '$result') AS email
                        FROM ost_email_template_test WHERE code_name = 'ticket.autoresp' AND tpl_guid = '$default_template_id'");
                    array_push($body, $body_ticket_autoresponder);
                }
                if ($overlimit_notice_active == '1' && $count_user_tickets + 1 == $max_open_tickets)
                {
                    $body_overlimit_notice_active = $this->db->query("SELECT subject AS email_subject, REPLACE(body, '%user_name%', '".$ticket_info->row('user_name')."') AS email FROM ost_email_template_test WHERE code_name = 'ticket.overlimit' AND tpl_guid = '$default_template_id'");
                    array_push($body, $body_overlimit_notice_active);
                }

                if ($ticket_autoresponder == '1' || ($overlimit_notice_active == '1' && $count_user_tickets + 1 == $max_open_tickets))
                {
                    $this->load->library('email');
                    $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test INNER JOIN ost_ticket_test WHERE number = '$result' AND type ='S'")->row('thread_entry_guid');
                    $file_id = $this->db->query("SELECT name FROM ost_file_test WHERE thread_entry_guid='$thread_id'");
                    $email_attach = $this->db->query("SELECT value FROM ost_config_test WHERE id='69'")->row('value');
                    
                    foreach ($body as $email_body)
                    {
                        $data = array(
                            'body' => $email_body,
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

                        $this->email->initialize($config);
                        $this->email->from($sender_email->userid); 
                        $this->email->reply_to($sender_email->userid);    // Optional, an account where a human being reads.
                        $this->email->to($ticket_info->row('user_email'));
                        $this->email->subject($data['body']->row('email_subject'));
                        $this->email->message($bodyContent);
                        if($email_attach == '1' || $ticket_autoresponder == '1')
                        {
                            foreach($file_id->result() as $value1)
                            {
                                $this->email->attach('uploads/'.$value1->name);
                            }
                        }
                        $this->email->send();
                    }
                }

                echo "<script> document.location='" . base_url() . "/index.php/open_controller/ticket_thank_you?number=$result' </script>";
            }
            else
            {
                echo "<script> alert('The number of unsolved tickets has exceeded maximum number allowed for a single user.');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/open_controller/main' </script>";
            }
        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function ticket_thank_you()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $ticket_number = $_REQUEST['number'];
            $ticket_info = $this->db->query("SELECT a.ticket_guid, b.value, a.number FROM ost_ticket_test AS a 
                INNER JOIN ost_list_items_test AS b ON a.subtopic_guid = b.list_item_guid
                WHERE number = '$ticket_number'");

            $data = array(
                'thank_you_page' => $this->db->query("SELECT REPLACE(body, '%ticket_guid%', '".$ticket_info->row('ticket_guid')."') AS content FROM ost_content_test WHERE type = 'thank-you' AND in_use = '1' AND field = 'pages'"),
                'ticket_info' => $ticket_info,
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
                $this->load->view('opent/ticket_thankyou' ,$data);
                $this->load->view('footer');
            }    

        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function sub()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   
            $id= $_REQUEST['id'];
            $data = $this->db->query("SELECT list_item_guid, VALUE FROM ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.`topic_guid` = b.`topic_guid` WHERE b.topic_guid = '$id' ORDER BY value")->result();
            echo json_encode($data);
        }

        else       
        {
           redirect('user_controller/login');
        }
    }
}
?>