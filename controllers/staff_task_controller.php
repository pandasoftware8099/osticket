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

        $staff_id = $_SESSION["staffid"];    
        $userdeptid = $_SESSION['staffdept'];
        
    

        $data = array(
            
            'result' => $this->db->query("SELECT * FROM  ost_task_test 
                INNER JOIN ost_task__cdata_test ON ost_task_test.task_id = ost_task__cdata_test.tasksub_id
                INNER JOIN ost_department_test ON ost_task_test.dept_id = ost_department_test.id WHERE task_status = 1 AND dept_id IN (SELECT id FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.id = b.`dept_id` WHERE b.`staff_id` = '$staff_id' UNION SELECT id FROM ost_department_test WHERE id = '$userdeptid')"), 

            'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.edit%'")->num_rows(),

            'assignallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.assign%'")->num_rows(),

            'transferallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.transfer%'")->num_rows(),

            'deleteallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.delete%'")->num_rows(),

            'department' => $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%task.transfer%' "), 

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
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function close()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $staff_id = $_SESSION["staffid"]; 
        $userdeptid = $_SESSION['staffdept'];   

        $data = array(
            'result' => $this->db->query("SELECT * FROM  ost_task_test 
                INNER JOIN ost_task__cdata_test ON ost_task_test.task_id = ost_task__cdata_test.tasksub_id
                INNER JOIN ost_department_test ON ost_task_test.dept_id = ost_department_test.id WHERE task_status = 0 AND dept_id IN (SELECT id FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.id = b.`dept_id` WHERE b.`staff_id` = '$staff_id' UNION SELECT id FROM ost_department_test WHERE id = '$userdeptid')"), 

            'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.edit%'")->num_rows(),

            'assignallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.assign%'")->num_rows(),

            'transferallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.transfer%'")->num_rows(),

            'deleteallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%task.delete%'")->num_rows(),

            'department' => $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%task.transfer%' "), 

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
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
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

        $posterfname = $this->db->query("SELECT firstname FROM osticket.ost_staff_test WHERE staff_id = '$poster_id'")->row('firstname');
        $posterlname = $this->db->query("SELECT lastname FROM osticket.ost_staff_test WHERE staff_id = '$poster_id'")->row('lastname');

        $duedatetime = date('Y-m-d H:i', strtotime("$duedatetime"));
        $todaydatetime = date('Y-m-d H:i');

        echo $todaydatetime;die;

        if ($assign != "")
        {
            if ($assign{0} == 'a') 
            {
                $staff_id = substr($assign, 1);
                $team_id = '0';
            }
            else if ($assign{0} == 't') 
            {
                $team_id = substr($assign, 1);
                $staff_id = '0';
            }
        }
        else
        {
            $team_id = '0';
            $staff_id = '0';
        }

        $this->db->query("INSERT INTO osticket.ost_task_test ( task_status, dept_id , staff_id, team_id, task_created, task_updated)
            VALUES ( '1', '$deparment', '$staff_id', '$team_id', now(), now() )");

        $task_id = $this->db->query("SELECT task_id FROM ost_task_test WHERE task_created = now()")->row('task_id');

        if ($duedatetime >= $todaydatetime)
        {
            $this->db->query("UPDATE ost_task_test SET duedate = '$duedatetime' WHERE task_id = $task_id");
        }

        $this->db->query("INSERT INTO osticket.ost_task__cdata_test ( title )
            VALUES ( '$title' )");

        $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( task_id , staff_id , type, poster , body , ip_address, created, updated, class , avatar )
        VALUES ('$task_id' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

        if(isset($_POST['submit'])){
            // Count total files
            $countfiles = count($_FILES['file']['name']);
            // Looping all files
            for($i=0;$i<$countfiles;$i++)
            {
                $thread_id = $this->db->query("SELECT id FROM ost_thread_entry_test WHERE created = now() ")->row('id');

                $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                if ($_FILES['file']['name'][0] != "") 
                {
                    // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test ( name, created , thread_entry_id )
                    VALUES ( '$filename', NOW(), '$thread_id' ) ");
                }
            }

            if ($filename != "$thread_id".'_')
                echo "<script> alert('$i File(s) and message succesfully sent.');</script>";
            else
                echo "<script> alert('Task succesfully created.');</script>"; 
        }

        if ($direct == 'ticket')
        {
            $ticketid = $_REQUEST['id'];

            $this->db->query("UPDATE ost_task_test SET ticket_id = '$ticketid' WHERE task_id = '$task_id'");

            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }

        else if ($direct == 'task')
        {
            echo "<script> document.location='" . base_url() . "/index.php/staff_task_controller/taskinfo?id=$task_id' </script>";
        }
    }

    public function changetaskstatus()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $check = $this->input->post('tids[]');
            $status = $this->input->post('status_id');
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

            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('lastname');

            foreach ($check as $value) {
                $number = $this->db->query("SELECT task_id FROM osticket.ost_task_test WHERE task_id = '$value'")->row('task_id');

                if ($status != "" ){

                        $primarystatuspermscheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_task_test d ON C.`id` = d.`dept_id` WHERE a.staff_id = '$poster_id' AND b.permissions LIKE '%task.close%' AND task_id = '$value'")->num_rows();

                        $statuspermscheck = $this->db->query("SELECT * FROM ost_task_test a INNER JOIN ost_department_test b ON a.`dept_id` = b.`id` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.task_id = '$value' AND d.permissions LIKE '%task.close%' AND C.`staff_id` = '$poster_id'")->num_rows();

                    if ($primarystatuspermscheck != 0) {
                           $this->db->query("UPDATE ost_task_test SET task_status = '$status', task_updated = NOW() WHERE task_id = '$value' ");
                    echo "<script> alert('$number Successfully change status');</script>";
                        
                    }

                    else if ($statuspermscheck != 0) {

                           $this->db->query("UPDATE ost_task_test SET task_status = '$status', task_updated = NOW() WHERE task_id = '$value' ");
                    echo "<script> alert('$number Successfully change status');</script>";
                  
                    }

                    else{

                     echo "<script> alert('You have no permission for #$number');</script>";
                        

                    }
                        
                    

                }
                else if ($depart != "" ){
                    $this->db->query("UPDATE ost_task_test SET dept_id = '$depart', task_updated = NOW() WHERE task_id = '$value' ");
                    echo "<script> alert('$number Successfully change department');</script>";
                }
                else if ($assignto{0} == 'a'){
                    $staff_id = substr($assignto, 1);
                    $team_id = '0';

                    $this->db->query("UPDATE ost_task_test SET staff_id = '$staff_id' , team_id = '$team_id', task_updated = NOW() WHERE task_id = '$value' ");
                    echo "<script> alert('$number Successfully assign to agent');</script>";
                }

                else if ($assignto{0} == 't'){
                    $team_id = substr($assignto, 1);
                    $staff_id = '0';

                    $this->db->query("UPDATE ost_task_test SET staff_id = '$staff_id' , team_id = '$team_id', task_updated = NOW() WHERE task_id = '$value' ");
                    echo "<script> alert('$number Successfully assign to team');</script>";
                }

                else if ($delete == '5'){

                    $this->db->query("DELETE FROM ost_task_test WHERE task_id = '$value' ");
                    echo "<script> alert('$number Successfully deleted');</script>";
                }

                foreach ($notearr as $note) {
                    if ($note != "")
                        $this->db->query("INSERT INTO ost_thread_entry_test ( task_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar ) VALUES ('$value', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
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
           redirect('user_controller/login');
        }
    }

    public function taskinfo()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $task_id = $_REQUEST["id"];
        $staffid = $_SESSION["staffid"];

        $data = array(

            'task' => $this->db->query("SELECT a.*, b.*, c.*, d.*, e.*, f.*, a.duedate AS taskdue, a.staff_id AS taskstaff, a.team_id AS taskteam, c.name AS deptname, f.name AS teamname, a.dept_id AS taskdept FROM ost_task_test AS a
                INNER JOIN ost_task__cdata_test AS b ON a.task_id = b.tasksub_id
                INNER JOIN ost_department_test AS c ON a.dept_id = c.id
                LEFT JOIN ost_ticket_test AS d ON a.ticket_id = d.ticket_id
                LEFT JOIN ost_staff_test AS e ON a.staff_id = e.staff_id
                LEFT JOIN ost_team_test AS f ON a.team_id = f.team_id
                WHERE task_id = '$task_id'"),

            'editallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_id` = ost_department_test.`id` WHERE task_id= '$task_id') c ON a.dept_id = c.id  WHERE permissions LIKE '%task.edit%'")->num_rows(),

            'assignallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_id` = ost_department_test.`id` WHERE task_id= '$task_id') c ON a.dept_id = c.id  WHERE permissions LIKE '%task.assign%'")->num_rows(),

            'replyallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_id` = ost_department_test.`id` WHERE task_id= '$task_id') c ON a.dept_id = c.id  WHERE permissions LIKE '%task.reply%'")->num_rows(),

            'transferallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_id` = ost_department_test.`id` WHERE task_id= '$task_id') c ON a.dept_id = c.id  WHERE permissions LIKE '%task.transfer%'")->num_rows(),

            'deleteallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_id` = ost_department_test.`id` WHERE task_id= '$task_id') c ON a.dept_id = c.id  WHERE permissions LIKE '%task.delete%'")->num_rows(),

            'replyallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_task_test LEFT JOIN ost_department_test ON ost_task_test.`dept_id` = ost_department_test.`id` WHERE task_id= '$task_id') c ON a.dept_id = c.id  WHERE permissions LIKE '%task.reply%'")->num_rows(),

            'taskstatus' => $this->db->query("SELECT task_status FROM ost_task_test WHERE task_id = '$task_id'")->row('task_status'),

            'threadname' => $this->db->query("SELECT * FROM ost_staff_test AS a
                    INNER JOIN ost_thread_entry_test AS b ON a.staff_id = b.staff_id
                    INNER JOIN ost_task_test AS c ON b.`task_id` = c.`task_id`
                    INNER JOIN ost_department_test AS d ON a.dept_id = d.id
                    
                    WHERE b.task_id = $task_id ")->row(),

            'department' => $this->db->query("SELECT * FROM  ost_department_test"), 

            'staff' => $this->db->query("SELECT * FROM  ost_staff_test"),
            
            'team' => $this->db->query("SELECT * FROM  ost_team_test"), 

            'taskthread' => $this->db->query("SELECT * FROM ost_thread_entry_test
                WHERE task_id = '$task_id'"),

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
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
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

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');

            $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( task_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar )
            VALUES ('$taskid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

            $task_status = $this->input->post('task_status');
            $this->db->query("UPDATE ost_task_test SET task_status = '$task_status', task_updated = NOW() WHERE task_id = '$taskid'");

            if(isset($_POST['submit'])){
     
                // Count total files
                $countfiles = count($_FILES['file']['name']);

                // Looping all files
                for($i=0;$i<$countfiles;$i++){

                    $thread_id = $this->db->query("SELECT id FROM ost_thread_entry_test WHERE created = now() ")->row('id');

                    $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                    if ($_FILES['file']['name'][0] != "") {
                        // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test ( name, created , thread_entry_id )
                    VALUES ( '$filename', NOW(), '$thread_id' ) ");

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
                /*$this->load->view('footer');*/
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

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');

            print_r($_FILES['file']['name']);die;

            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( task_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
            VALUES ('$taskid' ,'$poster_id', 'N' ,'$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");

            $this->db->query("UPDATE ost_task_test SET task_status = '$statusid', task_updated = now() WHERE task_id = '$taskid'");

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

                    else {

                        echo "<script> alert('Message successfully sent.');</script>"; 

                    }
                }
            }
            redirect('staff_task_controller/taskinfo?id='.$taskid);
        }

        else
        {
            redirect('user_controller/login');
        }
    }

    public function taskinfoupdate()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

            $taskid = $_REQUEST['id'];
            $status = $this->input->post('status_id');
            $depart = $this->input->post('departmentid');
            $assignto = $this->input->post('assignto');
            $ctitle = addslashes($this->input->post('ctitle'));
            $delete = $this->input->post('delete');

            if ($status != "" ){
                $this->db->query("UPDATE ost_task_test SET task_status = '$status', task_updated = NOW() WHERE task_id = '$taskid' ");
                echo "<script> alert('Successfully change status');</script>";
            }
            else if ($depart != "" ){
              $this->db->query("UPDATE ost_task_test SET dept_id = '$depart', task_updated = NOW() WHERE task_id = '$taskid' ");
                echo "<script> alert('Successfully change department');</script>";
            }
            else if ($assignto{0} == 'a'){
                $staff_id = substr($assignto, 1);
                $team_id = '0';

                $this->db->query("UPDATE ost_task_test SET staff_id = '$staff_id' , team_id = '$team_id', task_updated = NOW() WHERE task_id = '$taskid' ");
                echo "<script> alert('Successfully assign to agent');</script>";
            }

            else if ($assignto{0} == 't'){
                $team_id = substr($assignto, 1);
                $staff_id = '0';

                $this->db->query("UPDATE ost_task_test SET staff_id = '$staff_id' , team_id = '$team_id', task_updated = NOW() WHERE task_id = '$taskid' ");
                echo "<script> alert('Successfully assign to team');</script>";
            }

            else if ($ctitle != "" ){
                $this->db->query("UPDATE ost_task__cdata_test SET title = '$ctitle', task_updated = NOW() WHERE tasksub_id = '$taskid'");
                echo "<script> alert('Successfully change title');</script>";
            }
            else if ($delete == '5'){
                $team_id = substr($assignto, 1);
                $staff_id = '0';

                $this->db->query("DELETE FROM ost_task_test WHERE task_id = '$taskid' ");

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

            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('lastname');

            foreach ($notearr as $note) {
                if ($note != "")
                    $this->db->query("INSERT INTO ost_thread_entry_test ( task_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar ) VALUES ('$taskid', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
            }

            redirect('staff_task_controller/taskinfo?id='.$taskid);
        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function printpreviewstafftask()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $taskid = $_REQUEST['id'];

            $taskstatus = $this->db->query("SELECT * FROM ost_task_test WHERE task_id = $taskid")->row('task_status');
            if ($taskstatus == "0")
                $statusname = 'Closed';
            else if ($taskstatus == "1")
                $statusname = 'Opened';

            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_task_test 
                    INNER JOIN ost_department_test ON ost_department_test.id = ost_task_test.dept_id 
                    WHERE task_id = $taskid"),

                'status' => $statusname,

                'user' => $this->db->query("SELECT * FROM ost_task_test AS a
                    LEFT JOIN ost_staff_test  AS b ON a.staff_id = b.staff_id
                    LEFT JOIN ost_team_test AS c ON a.team_id = c.team_id
                    WHERE task_id = '$taskid'"),

                'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test WHERE task_id = $taskid"),
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
           redirect('user_controller/login');
        }

    }
}

?>