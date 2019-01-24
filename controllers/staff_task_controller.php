<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff_task_controller extends CI_Controller {
    
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

        $staff_guid = $_SESSION["staffid"];    
        $userdeptid = $_SESSION['staffdept'];
        
    

        $data = array(
            
            'result' => $this->db->query("SELECT * FROM  ost_task_test 
                INNER JOIN ost_task__cdata_test ON ost_task_test.task_guid = ost_task__cdata_test.tasksub_guid
                INNER JOIN ost_department_test ON ost_task_test.dept_guid = ost_department_test.department_guid WHERE task_status = 1 AND dept_guid IN (SELECT department_guid FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE b.`staff_guid` = '$staff_guid' UNION SELECT department_guid FROM ost_department_test WHERE department_guid = '$userdeptid')"), 

            'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.edit%'")->num_rows(),

            'assignallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.assign%'")->num_rows(),

            'transferallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.transfer%'")->num_rows(),

            'deleteallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.delete%'")->num_rows(),

            'department' => $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%task.transfer%' "), 

            'staff' => $this->db->query("SELECT * FROM  ost_staff_test"),

            'team' => $this->db->query("SELECT * FROM  ost_team_test"),

            'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),

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
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_task',$data);
                $this->load->view('footerstaff');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function close()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $staff_guid = $_SESSION["staffid"]; 
        $userdeptid = $_SESSION['staffdept'];   

        $data = array(
            'result' => $this->db->query("SELECT * FROM  ost_task_test 
                INNER JOIN ost_task__cdata_test ON ost_task_test.task_guid = ost_task__cdata_test.tasksub_guid
                INNER JOIN ost_department_test ON ost_task_test.dept_guid = ost_department_test.department_guid WHERE task_status = 0 AND dept_guid IN (SELECT department_guid FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE b.`staff_guid` = '$staff_guid' UNION SELECT department_guid FROM ost_department_test WHERE department_guid = '$userdeptid')"), 

            'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.edit%'")->num_rows(),

            'assignallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.assign%'")->num_rows(),

            'transferallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.transfer%'")->num_rows(),

            'deleteallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%task.delete%'")->num_rows(),

            'department' => $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%task.transfer%' "), 

            'staff' => $this->db->query("SELECT * FROM  ost_staff_test"), 

            'team' => $this->db->query("SELECT * FROM  ost_team_test"),

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
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_task',$data);
                $this->load->view('footerstaff');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function createtask()
    {

        $title = addslashes($this->input->post('title'));
        $description = addslashes($this->input->post('description'));
        $deparment = $this->input->post('departmentid');
        $assign = $this->input->post('assign');
        $duedatetime = $this->input->post('duedatetime');
        $tasktime = $this->input->post('tasktime');

        $direct = $_REQUEST['direct'];
        $poster_id = $_SESSION["staffid"];
        $ipaddress = $_SERVER['REMOTE_ADDR'];

        $posterfname = $this->db->query("SELECT firstname FROM osticket.ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
        $posterlname = $this->db->query("SELECT lastname FROM osticket.ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');


        $duedatetime = date('Y-m-d H:i', strtotime("$duedatetime"));
        $todaydatetime = date('Y-m-d H:i');
        $todaydate = date('Ymd');
        $todaydate2 = substr($todaydate, 2);
        $number_random_digit = $this->db->query("SELECT * FROM ost_config_test WHERE id = '72'")->row('value');
        $task_seq_id = $this->db->query("SELECT value FROM ost_config_test WHERE id='73'")->row('value');
        $checkstring = str_repeat("_", $number_random_digit);
        $task_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id='143'")->row('value');
        $alluseremail = array();

        if($task_seq_id == '0')
        {
            $number = $this->db->query("SELECT LPAD(FLOOR(RAND() * 999999.99), '$number_random_digit', '0') as randno")->row('randno');

            $checknumber2 = $this->db->query("SELECT * FROM ost_task_test WHERE number ='$todaydate2$number'")->num_rows();

            while($checknumber2 != 0){
                $number = $this->db->query("SELECT LPAD(FLOOR(RAND() * 999999.99), '$number_random_digit', '0') as randno")->row('randno');
                $checknumber2 = $this->db->query("SELECT * FROM ost_task_test WHERE number ='$todaydate2$number'")->num_rows();
            }


        }
        else
        {
            $next = $this->db->query("SELECT next FROM ost_sequence_test WHERE sequence_guid='$task_seq_id'")->row('next');
            $increment = $this->db->query("SELECT increment FROM ost_sequence_test WHERE sequence_guid='$task_seq_id'")->row('increment');
            $padding = $this->db->query("SELECT padding FROM ost_sequence_test WHERE sequence_guid='$task_seq_id'")->row('padding');
            $lastnumber = $this->db->query("SELECT number FROM ost_task_test WHERE number LIKE '$todaydate2$checkstring' AND sequence_guid = '$task_seq_id' ORDER BY number DESC LIMIT 1");

            if($lastnumber->num_rows() != '0')
            {
                $number = $lastnumber->row('number')+$increment;
            }
            else
            {
                $pad = str_repeat($padding,$number_random_digit-1);
                $number = $todaydate2.$pad.$next;
            }

            $checknumber2 = $this->db->query("SELECT * FROM ost_task_test WHERE number ='$number'")->num_rows();

            while($checknumber2 != 0){
                $number += $increment;
                $checknumber2 = $this->db->query("SELECT * FROM ost_task_test WHERE number ='$number'")->num_rows();
            }
            $number = substr($number, 6);
        }


        if ($assign != "")
        {
            if ($assign{0} == 'a') 
            {
                $staff_guid = substr($assign, 1);
                $team_guid = '0';
            }
            else if ($assign{0} == 't') 
            {
                $team_guid = substr($assign, 1);
                $staff_guid = '0';
            }
        }
        else
        {
            $team_guid = '0';
            $staff_guid = '0';
        }

        $this->db->query("INSERT INTO osticket.ost_task_test ( task_guid, task_status, number, sequence_guid, dept_guid , staff_guid, team_guid, task_created, task_updated)
            VALUES ( REPLACE(UPPER(UUID()),'-',''), '1', '$todaydate2$number', '$task_seq_id', '$deparment', '$staff_guid', '$team_guid', now(), now() )");

        $task_guid = $this->db->query("SELECT task_guid FROM ost_task_test WHERE task_created = now()")->row('task_guid');

        if ($duedatetime >= $todaydatetime)
        {
            $this->db->query("UPDATE ost_task_test SET duedate = '$duedatetime' WHERE task_guid = '$task_guid'");
        }

        $this->db->query("INSERT INTO osticket.ost_task__cdata_test ( tasksub_guid,title )
            VALUES ('$task_guid', '$title' )");

        $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class , avatar )
        VALUES (REPLACE(UPPER(UUID()),'-',''), '$task_guid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

        $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
        $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');

        $description = '<b>'.$posterfname.''.$posterlname.'</b> created task ';
                

        $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
        VALUES (REPLACE(UPPER(UUID()),'-',''), '$task_guid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'magic', 'left')");

        if(isset($_POST['submit'])){
            // Count total files
            $countfiles = count($_FILES['file']['name']);
            // Looping all files
            for($i=0;$i<$countfiles;$i++)
            {
                $thread_id = $this->db->query("SELECT thread_entry_guid FROM ost_thread_entry_test WHERE created = now() ")->row('thread_entry_guid');

                $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                if ($_FILES['file']['name'][0] != "") 
                {
                    // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test (file_guid, name, created , thread_entry_guid )
                    VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");
                }
            }

            if ($filename != "$thread_id".'_')
                echo "<script> alert('$i File(s) and message succesfully sent.');</script>";
            else
                echo "<script> alert('Task succesfully created.');</script>"; 
        }

        if($task_alert_active == '1')
        {
            $task_alert_admin = $this->db->query("SELECT value FROM ost_config_test WHERE id='144'")->row('value');
            $task_alert_dept_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='145'")->row('value');
            $task_alert_dept_members = $this->db->query("SELECT value FROM ost_config_test WHERE id='146'")->row('value');

            if($task_alert_admin == '1')
            {
                $admin_email = $this->db->query("SELECT value FROM ost_config_test WHERE id = '1' ")->row('value');

                if (!in_array($admin_email, $alluseremail))
                {
                    array_push($alluseremail, $admin_email);
                }
            }

            if($task_alert_dept_manager == '1')
            {
                $dept_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b ON b.manager_guid = a.staff_guid WHERE b.department_guid = '$deparment' ")->row('email');

                if (!in_array($dept_manager_email, $alluseremail))
                {
                    array_push($alluseremail, $dept_manager_email);
                }
                
            }

            if($task_alert_dept_members == '1')
            {
                $dept_members_email = $this->db->query("SELECT b.email FROM ost_staff_test a WHERE a.dept_guid = '$deparment'")
                
                foreach($dept_members_email->result() as $value1)
                {
                    if (!in_array($value1->email, $alluseremail))
                    {
                        array_push($alluseremail, $value->email);
                    }
                }
            }
        }

        foreach ($alluseremail as $value)
        {
            $this->load->library('email');

            $user_name = $this->db->query("SELECT user_name FROM ost_user_test WHERE user_email = '$value'")->row('user_name');
            $emailinfo = $this->db->query("SELECT * FROM ost_user_test AS a
                INNER JOIN ost_ticket_test AS b ON a.user_guid = b.user_guid
                INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                WHERE ticket_guid = '$result'");
            $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');

            $data = array(
                'body' => $this->db->query("SELECT REPLACE(REPLACE(subject, '%subject%', '".$emailinfo->row('value')."'), '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '$user_name'), '%login%', '$login'), '%number%', '".$emailinfo->row('number')."'), '%topic%', '".$emailinfo->row('topic')."'), '%subtopic%', '".$emailinfo->row('value')."') AS email
                    FROM ost_email_template_test WHERE code_name = 'ticket.notice' AND tpl_guid = '$default_template_id'"),
                'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                    INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                    WHERE staff_guid = '$poster_id'"),
                'signature' => $signature,
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
            $this->email->to($value);
            $this->email->subject($data['body']->row('email_subject'));
            $this->email->message($bodyContent);
            $this->email->send();
        }

        if ($direct == 'ticket')
        {
            $ticketid = $_REQUEST['id'];

            $this->db->query("UPDATE ost_task_test SET ticket_guid = '$ticketid' WHERE task_guid = '$task_guid'");

            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }

        else if ($direct == 'task')
        {
            echo "<script> document.location='" . base_url() . "/index.php/staff_task_controller/taskinfo?id=$task_guid' </script>";
        }
    }

    public function changetaskstatus()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $check = $this->input->post('tids[]');
            $status = $this->input->post('status_guid');
            $depart = $this->input->post('departmentid');
            $assignto = $this->input->post('assignto');
            $delete = $this->input->post('delete');
            $title = $_REQUEST['title'];
            $direct = $_REQUEST['direct'];
            $poster_id = $_SESSION["staffid"];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            
            $notearr = array(
                'closenote' => addslashes($this->input->post('closenote')),
                'assignnote' => addslashes($this->input->post('assignnote')),
                'transfernote' => addslashes($this->input->post('transfernote')),
                'deletenote' => addslashes($this->input->post('deletenote')),
            );

            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');

            foreach ($check as $value) {
                $number = $this->db->query("SELECT task_guid FROM osticket.ost_task_test WHERE task_guid = '$value'")->row('task_guid');

                if ($status != "" ){

                        $primarystatuspermscheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_task_test d ON C.`department_guid` = d.`dept_guid` WHERE a.staff_guid = '$poster_id' AND b.permissions LIKE '%task.close%' AND task_guid = '$value'")->num_rows();

                        $statuspermscheck = $this->db->query("SELECT * FROM ost_task_test a INNER JOIN ost_department_test b ON a.`dept_guid` = b.`department_guid` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.task_guid = '$value' AND d.permissions LIKE '%task.close%' AND C.`staff_guid` = '$poster_id'")->num_rows();

                    if ($primarystatuspermscheck != 0) {
                           $this->db->query("UPDATE ost_task_test SET task_status = '$status', task_updated = NOW() WHERE task_guid = '$value' ");
                    echo "<script> alert('$number Successfully change status');</script>";
                        
                    }

                    else if ($statuspermscheck != 0) {

                           $this->db->query("UPDATE ost_task_test SET task_status = '$status', task_updated = NOW() WHERE task_guid = '$value' ");
                    echo "<script> alert('$number Successfully change status');</script>";
                  
                    }

                    else{

                     echo "<script> alert('You have no permission for #$number');</script>";
                        

                    }
                        
                    

                }
                else if ($depart != "" ){
                    $this->db->query("UPDATE ost_task_test SET dept_guid = '$depart', task_updated = NOW() WHERE task_guid = '$value' ");
                    echo "<script> alert('$number Successfully change department');</script>";
                }
                else if ($assignto{0} == 'a'){
                    $staff_guid = substr($assignto, 1);
                    $team_guid = '0';

                    $this->db->query("UPDATE ost_task_test SET staff_guid = '$staff_guid' , team_guid = '$team_guid', task_updated = NOW() WHERE task_guid = '$value' ");
                    echo "<script> alert('$number Successfully assign to agent');</script>";
                }

                else if ($assignto{0} == 't'){
                    $team_guid = substr($assignto, 1);
                    $staff_guid = '0';

                    $this->db->query("UPDATE ost_task_test SET staff_guid = '$staff_guid' , team_guid = '$team_guid', task_updated = NOW() WHERE task_guid = '$value' ");
                    echo "<script> alert('$number Successfully assign to team');</script>";
                }

                else if ($delete == '5'){

                    $this->db->query("DELETE FROM ost_task_test WHERE task_guid = '$value' ");

                    $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE task_guid = '$value'");
                    echo "<script> alert('$number Successfully deleted');</script>";
                }

                foreach ($notearr as $note) {
                    if ($note != "")
                        $this->db->query("INSERT INTO ost_thread_entry_test ( thread_entry_guid, task_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar ) VALUES (REPLACE(UPPER(UUID()),'-',''), '$value', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                }
            }

            if ($direct == 'task')
            {
                if ($title == 'Open') {
                    echo "<script> document.location='" . base_url() . "/index.php/staff_task_controller/close?title=Closed' </script>";
                }

                elseif ($title == 'Closed') {
                    echo "<script> document.location='" . base_url() . "/index.php/staff_task_controller/main?title=Open' </script>";
                }
            }   
                 

            else if ($direct == 'ticket')
            {
                $ticketid = $_REQUEST['id'];

                redirect('staff_ticket_controller/ticketinfo?id='.$ticketid);
            }
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function taskinfo()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $task_guid = $_REQUEST["id"];
       $staffid = $_SESSION["staffid"];

        $data = array(

            'task' => $this->db->query("SELECT a.*, b.*, c.*, d.*, e.*, f.*, a.duedate AS taskdue, a.staff_guid AS taskstaff, a.team_guid AS taskteam, c.name AS deptname, f.name AS teamname, a.dept_guid AS taskdept, a.number FROM ost_task_test AS a
                INNER JOIN ost_task__cdata_test AS b ON a.task_guid = b.tasksub_guid
                INNER JOIN ost_department_test AS c ON a.dept_guid = c.department_guid
                LEFT JOIN ost_ticket_test AS d ON a.ticket_guid = d.ticket_guid
                LEFT JOIN ost_staff_test AS e ON a.staff_guid = e.staff_guid
                LEFT JOIN ost_team_test AS f ON a.team_guid = f.team_guid
                WHERE task_guid = '$task_guid'"),

            'editallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_guid` = ost_department_test.`department_guid` WHERE task_guid= '$task_guid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%task.edit%'")->num_rows(),

            'assignallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_guid` = ost_department_test.`department_guid` WHERE task_guid= '$task_guid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%task.assign%'")->num_rows(),

            'replyallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_guid` = ost_department_test.`department_guid` WHERE task_guid= '$task_guid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%task.reply%'")->num_rows(),

            'transferallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_guid` = ost_department_test.`department_guid` WHERE task_guid= '$task_guid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%task.transfer%'")->num_rows(),

            'deleteallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_guid` = ost_department_test.`department_guid` WHERE task_guid= '$task_guid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%task.delete%'")->num_rows(),

            'replyallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_guid` = ost_department_test.`department_guid` WHERE task_guid= '$task_guid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%task.reply%'")->num_rows(),

            'taskstatus' => $this->db->query("SELECT task_status FROM ost_task_test WHERE task_guid = '$task_guid'")->row('task_status'),

            'threadname' => $this->db->query("SELECT * FROM ost_staff_test AS a
                    INNER JOIN ost_thread_entry_test AS b ON a.staff_guid = b.staff_guid
                    INNER JOIN ost_task_test AS c ON b.`task_guid` = c.`task_guid`
                    INNER JOIN ost_department_test AS d ON a.dept_guid = d.department_guid
                    
                    WHERE b.task_guid = '$task_guid' ")->row(),

            'department' => $this->db->query("SELECT * FROM  ost_department_test"), 

            'staff' => $this->db->query("SELECT * FROM  ost_staff_test"),
            
            'team' => $this->db->query("SELECT * FROM  ost_team_test"), 

            'taskthread' => $this->db->query("SELECT * FROM ost_thread_entry_test
                WHERE task_guid = '$task_guid' GROUP BY created "),

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
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_task_info', $data);
                $this->load->view('footerstaff');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function taskupdate()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $taskid = $this->input->post('id');
            $description = addslashes($this->input->post('response'));
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');

            $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
            VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

            $task_status = $this->input->post('task_status');
            $this->db->query("UPDATE ost_task_test SET task_status = '$task_status', task_updated = NOW() WHERE task_guid = '$taskid'");

            if(isset($_POST['submit'])){
     
                // Count total files
                $countfiles = count($_FILES['file']['name']);

                // Looping all files
                for($i=0;$i<$countfiles;$i++){

                    $thread_id = $this->db->query("SELECT thread_entry_guid FROM ost_thread_entry_test WHERE created = now() ")->row('thread_entry_guid');

                    $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                    if ($_FILES['file']['name'][0] != "") {
                        // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test ( file_guid, name, created , thread_entry_guid )
                    VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");

                    echo "<script> alert('$i File(s) and message succesfully sent.');</script>";

                    }
    

                    else {

                        echo "<script> alert('Message succesfully sent.');</script>"; 

                    }

                }

                redirect('staff_task_controller/taskinfo?id='.$taskid);
            }

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                    
            }
            else
            {
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_task_info',$data);
                $this->load->view('footerstaff');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function tasknote()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $taskid = $this->input->post('id');
            $note = addslashes($this->input->post('note'));
            $statusid = $this->input->post('taskstatus');
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');

            print_r($_FILES['file']['name']);die;

            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
            VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'N' ,'$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");

            $this->db->query("UPDATE ost_task_test SET task_status = '$statusid', task_updated = now() WHERE task_guid = '$taskid'");

            if(isset($_POST['submit'])){
     
                // Count total files
                $countfiles = count($_FILES['file']['name']);

                // Looping all files
                for($i=0;$i<$countfiles;$i++){

                    if ($_FILES['file']['name'][0] != "") {

                        $thread_id = $this->db->query("SELECT thread_entry_guid FROM ost_thread_entry_test WHERE created = now() ")->row('thread_entry_guid');

                        $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                        // Upload file
                        move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                        $this->db->query("INSERT ost_file_test ( file_guid, name, created , thread_entry_guid )
                        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");

                        echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                    }

                    else {

                        echo "<script> alert('Message successfully sent.');</script>"; 

                    }
                }
            }
            redirect('staff_task_controller/taskinfo?id='.$taskid);
        }

        else
        {
            redirect('user_controller/superlogin');
        }
    }

    public function taskinfoupdate()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

            $taskid = $_REQUEST['id'];
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $status = $this->input->post('status_guid');
            $depart = $this->input->post('departmentid');
            $assignto = $this->input->post('assignto');
            $ctitle = addslashes($this->input->post('ctitle'));
            $delete = $this->input->post('delete');
            $task_status = $this->db->query("SELECT task_status FROM ost_task_test WHERE task_guid = '$taskid' ")->row('task_status');
            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');

            if ($status != "" ){
                $this->db->query("UPDATE ost_task_test SET task_status = '$status', task_updated = NOW() WHERE task_guid = '$taskid' ");
                echo "<script> alert('Successfully change status');</script>";


                if ($task_status == 1) {
                    $description = 'Closed by <b>'.$posterfname.''.$posterlname.'</b>';
                } else if ($task_status == 0){
                    $description = 'Reopen by <b>'.$posterfname.''.$posterlname.'</b>';        
                }
                

                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'thumbs-up-alt', 'left')");

            }
            else if ($depart != "" ){
              $this->db->query("UPDATE ost_task_test SET dept_guid = '$depart', task_updated = NOW() WHERE task_guid = '$taskid' ");
                echo "<script> alert('Successfully change department');</script>";

                $departmentname = $this->db->query("SELECT name FROM ost_department_test WHERE department_guid = '$depart'")->row('name');

                $description = '<b>'.$posterfname.''.$posterlname.'</b> transfered this ticket to <strong>'.$departmentname. '</strong>';
                

                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'share-alt', 'left')");

            }
            else if ($assignto{0} == 'a'){
                $staff_guid = substr($assignto, 1);
                $team_guid = '0';

                $this->db->query("UPDATE ost_task_test SET staff_guid = '$staff_guid' , team_guid = '$team_guid', task_updated = NOW() WHERE task_guid = '$taskid' ");
                echo "<script> alert('Successfully assign to agent');</script>";

                $assignstafffname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('firstname');
                $assignstafflname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('lastname');
                $description = '<b>'.$posterfname.''.$posterlname.'</b> assigned this ticket to <strong>'.$assignstafffname. ''.$assignstafflname. '</strong>';
                

                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'hand-right', 'left')");

            }

            else if ($assignto{0} == 't'){
                $team_guid = substr($assignto, 1);
                $staff_guid = '0';

                $this->db->query("UPDATE ost_task_test SET staff_guid = '$staff_guid' , team_guid = '$team_guid', task_updated = NOW() WHERE task_guid = '$taskid' ");
                echo "<script> alert('Successfully assign to team');</script>";

                $assignteamname = $this->db->query("SELECT name FROM ost_team_test WHERE team_guid = '$team_guid' ")->row('name');
                $description = '<b>'.$posterfname.''.$posterlname.'</b> assigned this ticket to <strong>'.$assignteamname. '</strong>';

                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'hand-right', 'left')");
            }

            else if ($ctitle != "" ){
                $this->db->query("UPDATE ost_task__cdata_test SET title = '$ctitle' WHERE tasksub_guid = '$taskid'");

                $this->db->query("UPDATE ost_task_test SET task_updated = NOW() WHERE task_guid = '$taskid'");

                echo "<script> alert('Successfully change title');</script>";

                $description = '<b>'.$posterfname.''.$posterlname.'</b> change title of this task to <strong>'.$ctitle. '</strong>';

                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, task_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'pencil', 'left')");
            }
            else if ($delete == '5'){
                $team_guid = substr($assignto, 1);
                $staff_guid = '0';

                $this->db->query("DELETE FROM ost_task_test WHERE task_guid = '$taskid' ");

                $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE task_guid = '$taskid'");

                redirect('staff_task_controller/main');
            }

            $poster_id = $_SESSION["staffid"];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            
            $notearr = array(
                'closenote' => addslashes($this->input->post('closenote')),
                'assignnote' => addslashes($this->input->post('assignnote')),
                'transfernote' => addslashes($this->input->post('transfernote')),
                'editnote' => addslashes($this->input->post('editnote')),
                'deletenote' => addslashes($this->input->post('deletenote')),
            );

            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');

            foreach ($notearr as $note) {
                if ($note != "")
                    $this->db->query("INSERT INTO ost_thread_entry_test (thread_entry_guid, task_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar ) VALUES (REPLACE(UPPER(UUID()),'-',''), '$taskid', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
            }

            redirect('staff_task_controller/taskinfo?id='.$taskid);
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function printpreviewstafftask()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $taskid = $_REQUEST['id'];

            $taskstatus = $this->db->query("SELECT * FROM ost_task_test WHERE task_guid ='$taskid'")->row('task_status');
            if ($taskstatus == "0")
                $statusname = 'Closed';
            else if ($taskstatus == "1")
                $statusname = 'Opened';

            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_task_test 
                    INNER JOIN ost_department_test ON ost_department_test.department_guid = ost_task_test.dept_guid 
                    WHERE task_guid = '$taskid' "),

                'status' => $statusname,

                'user' => $this->db->query("SELECT * FROM ost_task_test AS a
                    LEFT JOIN ost_staff_test  AS b ON a.staff_guid = b.staff_guid
                    LEFT JOIN ost_team_test AS c ON a.team_guid = c.team_guid
                    WHERE task_guid = '$taskid' "),

                'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test WHERE task_guid = '$taskid' "),
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
                $this->load->view('staff/printpreviewstafftask',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function selected_tasks_ajax()
    {
            
            $task_guid_string= $_REQUEST['task_guid_string'];
            $i = 0;

            $checked_array = explode(',', $task_guid_string);

            foreach ($checked_array as $value ) {
                $data[$i] = $this->db->query("SELECT number from osticket.ost_task_test WHERE task_guid = '$value' GROUP BY number ASC")->row('number');
                $i++;

            }
            echo json_encode($data);
            
            

            
        
            /*$data = $this->db->query("SELECT a.period_code FROM `supplier_monthly_doc_count` a LEFT JOIN `supplier_monthly_main` b ON a.period_code = b.`period_code` WHERE a.customer_guid = '$customerid' AND a.supplier_guid = '$supplierid' AND invoice_number IS NULL;")->result();*/

   
    }
}

?>