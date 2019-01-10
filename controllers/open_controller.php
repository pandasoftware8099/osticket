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
                'current_sub' => $this->db->query("SELECT id, value FROM ost_list_items_test WHERE topic_id = '".$default_topic->row('value')."' ORDER BY value"),
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
                /*$this->load->view('footer');*/
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
            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_id = b.id WHERE a.user_id = '$userid' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');

            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                $result = $this->Open_model->add_process($subject, $subtopic, $description, $userid, $userdepname, $username);

                $ticket_info = $this->db->query("SELECT ticket_id, value, number FROM ost_ticket_test AS a INNER JOIN ost_list_items_test AS b ON a.subtopic_id = b.id WHERE number = '$result'");

                $data = array(
                    'thank_you_page' => $this->db->query("SELECT REPLACE(body, '%ticket_id%', '".$ticket_info->row('ticket_id')."') AS content FROM ost_content_test WHERE type = 'thank-you' AND in_use = '1' AND field = 'pages'"),
                    'ticket_info' => $ticket_info,
                );

                if(isset($_POST['submit']))
                {
     
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

                        else {

                            echo "<script> alert('Message successfully sent.');</script>"; 

                        }
                    }
                }

                $this->load->view('header');
                $this->load->view('viewt/ticket_thankyou', $data);
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

    public function sub()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   
            $id= $_REQUEST['id'];
            $data = $this->db->query("SELECT id, VALUE FROM ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.`topic_id` = b.`topic_id` WHERE b.topic_id = '$id' ORDER BY value")->result();
            echo json_encode($data);
        }

        else       
        {
           redirect('user_controller/login');
        }
    }
}
?>