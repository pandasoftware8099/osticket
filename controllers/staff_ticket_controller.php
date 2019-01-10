<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff_ticket_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('staff_new_ticket_model');
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
            $userdeptid = $_SESSION['staffdept'];
            $staff_id = $_SESSION["staffid"];
            $direct = $_REQUEST['direct'];
            $show_assigned_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '65'")->row('value');
            $show_answered_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '66'")->row('value');
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.id WHERE a.id = '85'");

            if ($direct == 'open')
            {
                $result = $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id 
                    INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id
                    WHERE c.state = 'open'
                    AND department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.id = b.`dept_id` WHERE B.`staff_id` = '$staff_id' UNION SELECT NAME FROM ost_department_test WHERE id = '$userdeptid')
                    AND (($show_assigned_tickets = '1' AND NOT ((a.assigned_to IS NOT NULL AND a.assigned_to != '0') OR (a.team_id IS NOT NULL AND a.team_id != '0'))) OR ($show_assigned_tickets = '0'))
                    AND (($show_answered_tickets = '1' AND a.ticket_id NOT IN (SELECT ticket_id FROM ost_thread_entry_test AS f WHERE f.type = 'S' AND a.created_at != f.created)) OR ($show_answered_tickets = '0'))");
            }
            else if ($direct == 'answered')
            {
                $result = $this->db->query("SELECT * FROM ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id 
                    INNER JOIN ost_user_test AS d ON a.user_id = d.user_id 
                    INNER JOIN ost_ticket_priority_test AS e ON e.priority_id = a.priority_id
                    INNER JOIN ost_thread_entry_test AS f ON a.ticket_id = f.ticket_id
                    WHERE f.type = 'S' AND a.created_at != f.created GROUP BY a.ticket_id");
            }

            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }

            $data = array(
                
                'result' => $result,

                'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'assignallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),

                'transferallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),

                'deleteallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),

                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),

                'department' => $department,

                'default_depart' => $defaultdept,

                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_id = '$userdeptid'"), 

                'team' => $this->db->query("SELECT * FROM ost_team_test WHERE flags = 1 "),

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
                $this->load->view('staff/staff_ticket',$data);
                /*$this->load->view('footer');*/
            }
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function mytickets()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $staff_id = $_SESSION["staffid"];  
            $userdeptid = $_SESSION['staffdept'];
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.id WHERE a.id = '85'");

            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }

            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id 
                    INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id 
                    WHERE c.state = 'open' AND assigned_to = '$staff_id' ORDER BY ticket_id DESC"), 

                 'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'assignallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),

                'transferallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),

                'deleteallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),

                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),

                'department' => $department,

                'default_depart' => $defaultdept,

                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_id = '$userdeptid'"),

                'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'team' => $this->db->query("SELECT * FROM ost_team_test WHERE flags = 1 "),

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
                $this->load->view('staff/staff_ticket',$data);
                /*$this->load->view('footer');*/
            }    
        }
        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function overdue()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $staff_id = $_SESSION["staffid"];  
            $userdeptid = $_SESSION['staffdept'];
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.id WHERE a.id = '85'");

            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }

            /*$todaydate = date('Y-m-d');
            $time_utc=mktime(date('G'),date('i'),date('s'));
            $NowisTime=date(' G:i:s',$time_utc);*/
     
            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id 
                    INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id 
                    WHERE c.state = 'open' AND duedate <= now()"), 

                 'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'assignallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),

                'transferallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),

                'deleteallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),

                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),

                'department' => $department,

                'default_depart' => $defaultdept,

                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_id = '$userdeptid'"),

                'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'team' => $this->db->query("SELECT * FROM ost_team_test WHERE flags = 1 "),

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
                $this->load->view('staff/staff_ticket',$data);
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
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $staff_id = $_SESSION["staffid"];  
            $userdeptid = $_SESSION['staffdept'];
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.id WHERE a.id = '85'");

            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }

            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id 
                    INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id
                    WHERE c.state = 'closed' AND department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.id = b.`dept_id` WHERE B.`staff_id` = '$staff_id' UNION SELECT NAME FROM ost_department_test WHERE id = '$userdeptid')"),

                 'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'assignallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),

                'transferallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),

                'deleteallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),

                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),

                'department' => $department,

                'default_depart' => $defaultdept,

                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_id = '$userdeptid'"),

                'editallow' => $this->db->query(" SELECT dept_id, role_id ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_id` = b.id WHERE staff_id = '$staff_id' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),

                'team' => $this->db->query("SELECT * FROM ost_team_test WHERE flags = 1 "),

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
                $this->load->view('staff/staff_ticket',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function newticket()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $user_id = $_REQUEST['id'];
            $staff_id = $_SESSION['staffid'];

            $default_topic = $this->db->query("SELECT value FROM ost_config_test WHERE id ='102'");
            $manager = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$user_id'")->row('manager');

            if ($manager != ('0' || ''))
            {
                if ($manager{0} == 'a')
                {
                    $staffid = substr($manager, 1);
                    $teamid = '0';
                }
                else if ($manager{0} == 't')
                {
                    $staffid = '0';
                    $teamid = substr($manager, 1);
                }
            }
            else
            {
                $staffid = '0';
                $teamid = '0';
            }
            
            if ($user_id != "")
            {
                $data = array(
                    'userinfo' => $this->db->query("SELECT * FROM ost_user_test AS a
                        LEFT JOIN ost_organization_test AS b ON a.user_org_id = b.id
                        LEFT JOIN ost_staff_test AS c ON b.manager = '$staffid'
                        LEFT JOIN ost_team_test AS d ON b.manager = '$teamid'
                        WHERE user_id = '$user_id'"),
                    'stafftopic' => $this->db->query("SELECT * FROM ost_help_topic_test WHERE isactive = 1 ORDER BY topic"),
                    'staffdepart' => $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.create%' "),
                    'priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                    'sla' => $this->db->query("SELECT * FROM ost_sla_test WHERE isactive = 1 ORDER BY id"),
                    'defaultslaid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='86'"),
                    'defaultpriorityid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='9'"),
                    'defaultstatusid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='103'"),
                    'default_help_topic' => $default_topic,
                    'current_sub' => $this->db->query("SELECT id, value FROM ost_list_items_test WHERE topic_id = '".$default_topic->row('value')."' ORDER BY value"),
                    'agent' => $this->db->query("SELECT * FROM ost_staff_test ORDER BY firstname"),
                    'team' => $this->db->query("SELECT * FROM ost_team_test WHERE flags = 1  ORDER BY name"),
                    'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                    'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
                    'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
                );
            }

            elseif ($user_id == "")
            {
                $data = array(
                    'stafftopic' => $this->db->query("SELECT * FROM ost_help_topic_test WHERE isactive = 1 ORDER BY topic"),
                    'staffdepart' => $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.create%' "),
                    'priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                    'sla' => $this->db->query("SELECT * FROM ost_sla_test WHERE isactive = 1 ORDER BY id"),
                    'defaultslaid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='86'"),
                    'defaultpriorityid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='9'"),
                    'defaultstatusid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='103'"),
                    'default_help_topic' => $default_topic,
                    'current_sub' => $this->db->query("SELECT id, value FROM ost_list_items_test WHERE topic_id = '".$default_topic->row('value')."' ORDER BY value"),
                    'agent' => $this->db->query("SELECT * FROM ost_staff_test ORDER BY firstname"),
                    'team' => $this->db->query("SELECT * FROM ost_team_test  WHERE flags = 1 ORDER BY name"),
                    'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                    'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
                    'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
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
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_new_ticket', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function opennew()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $user_name = $this->input->post('name');
            $user_email = $this->input->post('email');
            $alertuser = $this->input->post('alertuser');
            $status_id = $this->input->post('statusId');
            $priority_id = $this->input->post('priorityId');
            $sla_id = $this->input->post('slaId');
            $subject = $this->input->post('topicId');
            $subtopic_id = $this->input->post('subId');
            $description = $this->input->post('message');
            $assign_id = $this->input->post('assignId');
            $datetime = $this->input->post('datetime');
            $source = $this->input->post('source');
            $signature = $this->input->post('signature');
            $notes = $this->input->post('notes');
            $departid = $this->input->post('deptId');
            $poster_id = $_SESSION['staffid'];
            $userdepname = $this->db->query("SELECT * FROM ost_department_test WHERE id = '$departid'")->row('name');

            if ($assign_id != '')
            {
                if ($assign_id{0} == 'a')
                {
                    $staff_id = substr($assign_id, 1);
                    $team_id = '0';
                }
                else if ($assign_id{0} == 't')
                {
                    $team_id = substr($assign_id, 1);
                    $staff_id = '0';
                }
            }
            else
            {
                $team_id = '0';
                $staff_id = '0';
            }

            $user_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->row('user_id');

            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_id = b.id WHERE a.user_id = '$user_id' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');

            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                $result = $this->staff_new_ticket_model->add_new( $user_id, $status_id, $priority_id, $userdepname, $sla_id, $subject, $subtopic_id, $description, $assign_id, $staff_id, $team_id, $datetime, $source, $user_name, $user_email, $notes );

                $ticketid = $this->db->query("SELECT * FROM ost_ticket_test WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 1 ")->row('ticket_id');
                $poster_id = $_SESSION['staffid'];      
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                $description = 'Created by <b>'.$posterfname.''.$posterlname.'</b>';

                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'magic', 'left')");
            
                $ticket_auto_response = $this->db->query("SELECT ticket_auto_response FROM ost_department_test WHERE NAME = (SELECT department FROM ost_ticket_test WHERE ticket_id = '$ticketid')")->row('ticket_auto_response');

                if(isset($_POST['submit']))
                {
                    // Count total files
                    $countfiles = count($_FILES['file']['name']);
                    // Looping all files
                    for($i=0;$i<$countfiles;$i++)
                    {
                        $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE created = now() AND type ='S'")->row('id');

                        $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                        if ($_FILES['file']['name'][0] != "") 
                        {
                            // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                            $this->db->query("INSERT ost_file_test ( name, created, thread_entry_id )
                            VALUES ( '$filename', NOW(), '$thread_id' ) ");
                        }
                    }
                        
                }

                $sql = "SELECT a.user_email FROM ost_user_test a WHERE a.user_depart = '$departid'";
                $query = $this->db->query($sql);
                $array1=$query->result_array();
                $alluseremail = array_map (
                    function($value){
                    return $value['user_email'];
                    } , $array1
                );

                if ($ticket_auto_response == '1')
                {
                    foreach ($alluseremail as $value)
                    {

                        $this->load->library('email');

                        $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE created = now() AND type ='S'")->row('id');
                        $file_id = $this->db->query("SELECT name FROM ost_file_test WHERE thread_entry_id='$thread_id'");
                        $email_attach = $this->db->query("SELECT value FROM ost_config_test WHERE id='69'")->row('value');
                        $allow_auth_tokens = $this->db->query("SELECT value FROM ost_config_test WHERE id='112'")->row('value');
                        $user_name = $this->db->query("SELECT user_name FROM ost_user_test WHERE user_email = '$value'")->row('user_name');
                        $emailinfo = $this->db->query("SELECT * FROM ost_user_test AS a
                            INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id
                            INNER JOIN ost_help_topic_test AS c ON b.topic_id = c.topic_id
                            INNER JOIN ost_list_items_test AS d ON b.subtopic_id = d.id
                            WHERE ticket_id = '$result'");
                        $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');

                        if ($allow_auth_tokens == '0')
                        {
                            $login = 'http://[::1]/helpme/index.php/user_controller/login';
                        }
                        elseif ($allow_auth_tokens == '1')
                        {
                            $login = 'http://[::1]/helpme/index.php/user_controller/allow_auth?id='.$result.'';
                        }

                        $data = array(
                            'body' => $this->db->query("SELECT REPLACE(REPLACE(subject, '%subject%', '".$emailinfo->row('value')."'), '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '$user_name'), '%login%', '$login'), '%number%', '".$emailinfo->row('number')."'), '%topic%', '".$emailinfo->row('topic')."'), '%subtopic%', '".$emailinfo->row('value')."') AS email
                                FROM ost_email_template_test WHERE code_name = 'ticket.notice' AND tpl_id = '$default_template_id'"),
                            'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                                INNER JOIN ost_department_test AS b ON a.dept_id = b.id
                                WHERE staff_id = '$poster_id'"),
                            'signature' => $signature,
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

                        $this->email->initialize($config);
                        $this->email->from($sender_email->userid); 
                        $this->email->reply_to($sender_email->userid);    // Optional, an account where a human being reads.
                        $this->email->to($value);
                        $this->email->subject($data['body']->row('email_subject'));
                        $this->email->message($bodyContent);
                        if($email_attach=='1'){
                            foreach($file_id->result() as $value1){
                                $this->email->attach('uploads/'.$value1->name);
                            }
                        }
                        $this->email->send();
                    }
                }

                if (in_array($user_email, $alluseremail) )
                {
                }
                else
                {
                    if ($alertuser == '1')
                    {
                        $this->load->library('email');

                        $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE created = now() AND type ='S'")->row('id');
                        $file_id = $this->db->query("SELECT name FROM ost_file_test WHERE thread_entry_id='$thread_id'");
                        $email_attach = $this->db->query("SELECT value FROM ost_config_test WHERE id='69'")->row('value');
                        $allow_auth_tokens = $this->db->query("SELECT value FROM ost_config_test WHERE id='112'")->row('value');
                        $emailinfo = $this->db->query("SELECT * FROM ost_user_test AS a
                            INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id
                            INNER JOIN ost_help_topic_test AS c ON b.topic_id = c.topic_id
                            INNER JOIN ost_list_items_test AS d ON b.subtopic_id = d.id
                            WHERE ticket_id = '$result'");
                        $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                        
                        if ($allow_auth_tokens == '0')
                        {
                            $login = 'http://[::1]/helpme/index.php/user_controller/login';
                        }
                        elseif ($allow_auth_tokens == '1')
                        {
                            $login = 'http://[::1]/helpme/index.php/user_controller/allow_auth?id='.$result.'';
                        }

                        $data = array(
                            'body' => $this->db->query("SELECT REPLACE(REPLACE(subject, '%subject%', '".$emailinfo->row('value')."'), '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$emailinfo->row('user_name')."'), '%login%', '$login'), '%number%', '".$emailinfo->row('number')."'), '%topic%', '".$emailinfo->row('topic')."'), '%subtopic%', '".$emailinfo->row('value')."') AS email
                                FROM ost_email_template_test WHERE code_name = 'ticket.notice' AND tpl_id = '$default_template_id'"),
                            'signature' => $signature,
                            'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                                INNER JOIN ost_department_test AS b ON a.dept_id = b.id
                                WHERE staff_id = '$poster_id'"),
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

                        $this->email->initialize($config);
                        $this->email->from($sender_email->userid); 
                        $this->email->reply_to($sender_email->userid);    // Optional, an account where a human being reads.
                        $this->email->to($user_email);
                        $this->email->subject($data['body']->row('email_subject'));
                        $this->email->message($bodyContent);
                        if($email_attach=='1'){
                            foreach($file_id->result() as $value1){
                                $this->email->attach('uploads/'.$value1->name);
                            }
                        }
                        $this->email->send();
                    }
                }

                
                echo "<script> alert('Ticket succesfully created.');</script>"; 
                echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$result' </script>";
            }
            else
            {
                echo "<script> alert('The number of unsolved tickets for this user has exceeded maximum number allowed for a single user. Kindly assign this ticket to another user.');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/newticket?id=' </script>";
            }
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function ticketinfo()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

            $ticketid = $_REQUEST['id'];
            $staffid =$_SESSION['staffid'];
            $staff_id =$_SESSION['staffid'];
            $userid = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = $ticketid")->row('user_id');
            $taskid = $this->db->query("SELECT * FROM ost_task_test WHERE ticket_id = $ticketid")->row('task_id');
            $userticket = $this->db->query("SELECT * FROM ost_user_test AS a 
                INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id 
                WHERE ticket_id = $ticketid");
            $default_depart = $this->db->query("SELECT name, value FROM ost_config_test a 
                INNER JOIN ost_department_test b ON a.value = b.id WHERE a.id = '85'");

            $phone = $userticket->row('user_phone');
            $phoneext = $userticket->row('user_phoneext');
            if ($phoneext != "")
            {
                $phone = $phone.'X'.$phoneext;
            }

            if ($_SESSION['staffdept'] == $default_depart->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$default_depart->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_id, role_id, permissions ,c.`name`,c.`id` FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staff_id' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staff_id' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN ost_department_test c ON a.dept_id = c.id WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$default_depart->row('name')."'");
            }            

            $data = array(
                'result' => $this->db->query("SELECT a.*, b.*, c.*, d.*, e.*, a.team_id as ticket_team_id FROM ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                    INNER JOIN ost_ticket_priority_test AS d ON a.priority_id = d.priority_id 
                    INNER JOIN ost_list_items_test AS e ON a.subtopic_id = e.id
                    WHERE ticket_id = '$ticketid'"),

                'department' => $department, 

                'editallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_id= '$ticketid') c ON a.dept_id = c.id  WHERE permissions LIKE '%ticket.edit%'")->num_rows(),

                'assignallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_id= '$ticketid') c ON a.dept_id = c.id  WHERE permissions LIKE '%ticket.assign%'")->num_rows(),

                'replyallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_id= '$ticketid') c ON a.dept_id = c.id  WHERE permissions LIKE '%ticket.reply%'")->num_rows(),

                'transferallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_id= '$ticketid') c ON a.dept_id = c.id  WHERE permissions LIKE '%ticket.transfer%'")->num_rows(),

                'deleteallow' => $this->db->query(" SELECT * FROM (SELECT dept_id , role_id FROM ost_staff_test WHERE staff_id = '$staffid' UNION SELECT dept_id , role_id FROM ost_staff_dept_access_test WHERE staff_id = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_id=b.id INNER JOIN (SELECT ost_department_test.id FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_id= '$ticketid') c ON a.dept_id = c.id  WHERE permissions LIKE '%ticket.delete%'")->num_rows(),

                'departmentsign' => $this->db->query("SELECT ost_department_test.signature FROM ost_department_test INNER JOIN ost_staff_test ON ost_department_test.id = ost_staff_test.dept_id WHERE staff_id='$staffid'"), 

                'default_depart' => $default_depart,

                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_id = (SELECT id FROM ost_department_test WHERE NAME = (SELECT department FROM ost_ticket_test WHERE ticket_id = '$ticketid'))"),

                'stafflogin' => $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$staffid'")->row(),

                'team' => $this->db->query("SELECT * FROM ost_team_test WHERE flags = 1 "), 

                'task' => $this->db->query("SELECT a.*, b.*, c.*, d.*, e.*, c.name AS deptname, e.name AS teamname, a.staff_id AS taskstaff, a.team_id AS taskteam FROM ost_task_test AS a 
                    INNER JOIN ost_task__cdata_test AS b ON a.task_id = b.tasksub_id
                    INNER JOIN ost_department_test AS c ON a.dept_id = c.id
                    LEFT JOIN ost_staff_test AS d ON a.staff_id = d.staff_id
                    LEFT JOIN ost_team_test AS e ON a.team_id = e.team_id
                    WHERE a.ticket_id = '$ticketid' ORDER BY a.task_created DESC"),

                'thread' => $this->db->query("SELECT * FROM ost_thread_entry_test WHERE ticket_id = $ticketid"),

                'thread_num' => $this->db->query("SELECT * FROM ost_thread_entry_test WHERE ticket_id = '$ticketid' AND type != 'E'"),

                'threadname' => $this->db->query("SELECT * FROM ost_staff_test AS a
                    INNER JOIN ost_thread_entry_test AS b ON a.staff_id = b.staff_id
                    INNER JOIN ost_ticket_test AS c ON b.`ticket_id` = c.`ticket_id`
                    INNER JOIN ost_department_test AS d ON a.dept_id = d.id
                    
                    WHERE c.ticket_id = $ticketid")->row(),
                
                'user' => $this->db->query("SELECT * FROM ost_user_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id
                    LEFT JOIN ost_organization_test AS c ON c.id = a.user_org_id
                    WHERE ticket_id = '$ticketid'"),

                'phone' => $phone,

                'editticket' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = $ticketid"),

                'openclose' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = $ticketid")->row(),

                'org' => $this->db->query("SELECT * FROM ost_user_test AS a 
                    INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id 
                    LEFT JOIN ost_staff_test AS c ON a.usernote_poster = c.staff_id
                    LEFT JOIN ost_organization__cdata_test AS d ON a.user_org_id = d.org_id
                    WHERE ticket_id = $ticketid")->row(),

                'ticketstatus' => $this->db->query("SELECT * FROM ost_ticket_status_test"),

                'userticketcount' => $this->db->query("SELECT * FROM ost_ticket_test WHERE user_id = $userid"),

                'userticketopen' => $this->db->query("SELECT * FROM ost_ticket_test AS a INNER JOIN ost_ticket_status_test AS b ON a.status_id = b.id WHERE b.state = 'open' AND a.user_id = $userid"),

                'userticketclose' => $this->db->query("SELECT * FROM ost_ticket_test AS a INNER JOIN ost_ticket_status_test AS b ON a.status_id = b.id WHERE b.state = 'closed' AND a.user_id = $userid"),

                'enable_avatars' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '93'"),

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
                $this->load->view('staff/staff_ticket_info', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function ticketinfoupdate()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticketid = $_REQUEST['id'];
            $poster_id = $_SESSION["staffid"];   
            $status = $this->input->post('status_id');
            $depart = $this->input->post('departmentid');
            $assignto = $this->input->post('assignto');
            $delete = $this->input->post('deletetask');

            $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_id = '$ticketid'");
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));

            if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
            {
                if ($status != "" )
                {
                    if ($status == 3)
                    {
                        $primaryclosecheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.close%' AND ticket_id = '$ticketid'")->num_rows();
                        $closecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$ticketid' AND d.permissions LIKE '%ticket.close%' AND C.`staff_id` = '$poster_id'")->num_rows();

                        if ($primaryclosecheck != 0)
                        {
                            $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$ticketid'")->row('status_id');

                            $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");

                            $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                            if ($original != '3' && $new == 'closed')
                            {
                                $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL, ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid'");
                            }

                            $poster_id = $_SESSION['staffid'];      
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                            $description = 'Closed by <b>'.$posterfname.''.$posterlname.'</b>';

                            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'thumbs-up-alt', 'left')");

                            echo "<script> alert('Successfully change status');</script>";
                        }

                        else if ($closecheck != 0)
                        {
                            $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$ticketid'")->row('status_id');

                            $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");

                            $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                            if ($original != '3' && $new == 'closed')
                            {
                                $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL, ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid'");
                            }

                            $poster_id = $_SESSION['staffid'];      
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                            $description = 'Closed by <b>'.$posterfname.''.$posterlname.'</b>';

                            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'thumbs-up-alt', 'left')");

                            echo "<script> alert('Successfully change status');</script>";
                        }

                        else
                        {
                            echo "<script> alert('You have no permission for this ticket');</script>";
                        }
                    }
                    
                    else
                    {
                        $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$ticketid'")->row('status_id');
                        $statusname = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = $status")->row('name');

                        $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");
                        
                        $poster_id = $_SESSION['staffid'];      
                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                        $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                        $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                        $description = '<b>'.$posterfname.''.$posterlname.'</b> change status of this ticket to <strong>'.$statusname.'</strong>' ;

                        $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                        VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'pencil', 'left')");
                        
                        $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                        if ($original == '3' && $new == 'open')
                        {
                            $this->db->query("UPDATE ost_ticket_test SET closed = NULL, reopened = now(), ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid'");

                            $poster_id = $_SESSION['staffid'];      
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                            $description = 'Reopened by <b>'.$posterfname.''.$posterlname.'</b>';

                            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'rotate-right', 'left')");
                        }

                        echo "<script> alert('Successfully change status');</script>";
                    }
                }
                
                else if ($depart != "" )
                {
                    $transfer_sla_id = $this->db->query("SELECT sla_id FROM `ost_department_test` WHERE name = '$depart' ")->row('sla_id');

                    $this->db->query("UPDATE ost_ticket_test SET department = '$depart', status_id = '8', sla_id = '$transfer_sla_id', assigned_to = '0', team_id = '0', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");

                    $poster_id = $_SESSION['staffid'];      
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                    $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                    $departmentname = $this->db->query("SELECT * FROM ost_department_test WHERE name = '$depart'")->row('name');
                    $description = '<b>'.$posterfname.''.$posterlname.'</b> transfered this ticket to <strong>'.$departmentname. '</strong>';

                    $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'share-alt', 'left')");

                    echo "<script> alert('Successfully change department');</script>";
                }

                else if ($assignto{0} == 'a')
                {
                    $staff_id = substr($assignto, 1);
                    $team_id = '0';
                    $poster_id = $_SESSION['staffid'];      
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                    $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                    $assignstafffname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $staff_id")->row('firstname');
                    $assignstafflname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $staff_id")->row('lastname');
                    $description = '<b>'.$posterfname.''.$posterlname.'</b> assigned this ticket to <strong>'.$assignstafffname. ''.$assignstafflname. '</strong>';

                    $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'hand-right', 'left')");

                    $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id', status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");
                    echo "<script> alert('Successfully assigned to agent');</script>";
                }

                else if ($assignto{0} == 't')
                {
                    $team_id = substr($assignto, 1);
                    $staff_id = '0';

                    $poster_id = $_SESSION['staffid'];      
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                    $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                    $assignteamname = $this->db->query("SELECT * FROM ost_team_test WHERE team_id = '$team_id' ")->row('name');
                    $description = '<b>'.$posterfname.''.$posterlname.'</b> assigned this ticket to <strong>'.$assignteamname. '</strong>';

                    $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'hand-right', 'left')");

                    $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id', status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");

                    echo "<script> alert('Successfully assigned to team');</script>";
                }

                else if ($delete == '5')
                {
                    $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_id = '$ticketid'");

                    echo "<script> alert('Successfully deleted');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open' </script>";    
                }

                $poster_id = $_SESSION["staffid"];
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                
                $notearr = array(
                    'statusnote' => addslashes($this->input->post('statusnote')),
                    'assignnote' => addslashes($this->input->post('assignnote')),
                    'transfernote' => addslashes($this->input->post('transfernote')),
                    'deletenote' => addslashes($this->input->post('deletenote')),
                );

                $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('firstname');
                $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('lastname');

                foreach ($notearr as $note)
                {
                    if ($note != "")
                    {
                        $this->db->query("INSERT INTO ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar )
                        VALUES ('$ticketid', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                    }
                }
            }
            else
            {
                echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
            }

            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function ticketinfoedit()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticketid = $_REQUEST['id'];
            $userid = $_REQUEST['uid'];

            $phone = $this->db->query("SELECT * FROM ost_ticket_test AS a 
                INNER JOIN ost_user_test AS b ON a.user_id = b.user_id
                WHERE ticket_id = $ticketid")->row('user_phone');
            $phoneext = $this->db->query("SELECT * FROM ost_ticket_test AS a 
                INNER JOIN ost_user_test AS b ON a.user_id = b.user_id
                WHERE ticket_id = $ticketid")->row('user_phoneext');
            $current_topic = $this->db->query("SELECT topic_id FROM ost_ticket_test WHERE ticket_id = '$ticketid'");

            if ($phoneext != "")
            {
                $phone = $phone.'('.$phoneext.')';
            }

            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id 
                    INNER JOIN ost_ticket_status_test AS c ON c.id = a.status_id
                    INNER JOIN ost_ticket_priority_test AS d ON a.priority_id = d.priority_id 
                    INNER JOIN ost_list_items_test AS e ON a.subtopic_id = e.id
                    WHERE ticket_id = $ticketid"),

                'topic' => $this->db->query("SELECT * FROM ost_help_topic_test ORDER BY topic"),

                'inventory' => $this->db->query("SELECT * FROM  ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.topic_id = b.topic_id INNER JOIN ost_ticket_test AS c ON b.topic_id = c.topic_id WHERE c.ticket_id = $ticketid"),

                'subt' => $this->db->query("SELECT * FROM  ost_list_items_test INNER JOIN ost_ticket_test ON ost_list_items_test.id = ost_ticket_test.subtopic_id WHERE ticket_id = $ticketid"),

                'current_sub' => $this->db->query("SELECT id, value FROM ost_list_items_test WHERE topic_id = '".$current_topic->row('topic_id')."' ORDER BY value"),

                'sla' => $this->db->query("SELECT * FROM ost_sla_test"),

                'status' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                
                'user' => $this->db->query("SELECT * FROM ost_user_test AS a INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id WHERE ticket_id = '$ticketid'"),

                'newuser' => $this->db->query("SELECT * FROM ost_user_test WHERE user_id = '$userid'"),

                'phone' => $phone,

                'editticket' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = $ticketid"),

                'departmt' => $this->db->query("SELECT * FROM  ost_department_test AS a INNER JOIN ost_user_test AS b ON a.id = b.user_depart INNER JOIN ost_ticket_test AS c ON b.user_id = c.user_id WHERE ticket_id = $ticketid")->row(),
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
                $this->load->view('staff/staff_ticket_info_edit', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function ticket_user_update()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticketid = $_REQUEST['id'];
            $status = $_REQUEST['status'];
            $poster_id = $_SESSION['staffid'];

            $user_id = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$ticketid'")->row('user_id');
            $cemail = addslashes($this->input->post('cemail'));
            $cusername = addslashes($this->input->post('cusername'));
            $cphone = addslashes($this->input->post('cphone'));
            $cphoneext = addslashes($this->input->post('cphoneext'));
            $cnote = addslashes($this->input->post('cnote'));

            $usernamecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_id != '$user_id' AND user_name = '$cusername' ")->num_rows();

            $useremailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_id != '$user_id' AND user_email = '$cemail' ")->num_rows();

            $splitemail = explode('@', $cemail);
            $domain = '@'.$splitemail[1];
            $org = $this->db->query("SELECT * FROM ost_organization_test");
            $user_orgid = $this->db->query("SELECT * FROM ost_user_test AS a
                LEFT JOIN ost_organization_test AS b ON a.user_org_id = b.id
                WHERE user_id = '$user_id'")->row('id');

            if ($usernamecheck != '0' && $useremailcheck != '0')
                echo "<script> alert('Name and email duplicated');</script>";

            else if ($usernamecheck != '0')
                echo "<script> alert('Name duplicated');</script>";

            else if ($useremailcheck != '0')
                echo "<script> alert('Email duplicated');</script>";

            else {
                $this->db->query("UPDATE ost_user_test SET 
                    user_name = '$cusername', 
                    user_email = '$cemail' , 
                    user_phone = '$cphone', 
                    user_phoneext = '$cphoneext' ,
                    notes = '$cnote',
                    user_updated_at = NOW()
                    WHERE user_id = '$user_id' ");

                foreach ($org->result() as $orgdomain)
                {
                    if ($orgdomain->id != $user_orgid && $orgdomain->domain == $domain)
                    {
                        $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");

                        echo "<script> alert('User has been auto add into organization $orgdomain->name due to email domain setting in organization page.');</script>";
                    }
                }

                if ($cnote != "")
                    $this->db->query("UPDATE ost_user_test SET usernote_poster = '$poster_id', usernote_created = now() WHERE user_id = '$user_id' ");
                else
                    $this->db->query("UPDATE ost_user_test SET usernote_poster = '0', usernote_created = NULL WHERE user_id = '$user_id' ");

                echo "<script> alert('Edit Profile Successfully');</script>";

            }

            if ($status == 'info')
            {
                echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
            }
            else if ($status == 'edit')
            {
                echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfoedit?id=$ticketid&uid=' </script>";
            }
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function ticketeditsubmit()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $userid = $_REQUEST['uid'];
            $ticketid = $this->input->post('id');
            $source = $this->input->post('source');
            $topicid = $this->input->post('topicId');
            $subtopicid = $this->input->post('subtopicId');
            $slaid = $this->input->post('slaId');
            $dt = $this->input->post('datetime');
            $priorityid = $this->input->post('priorityId');
            $note = addslashes($this->input->post('note'));
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];

            $datetime = date('Y-m-d H:i', strtotime("$dt"));
            $todaydatetime = date('Y-m-d H:i');

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');

            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_id = b.id WHERE a.user_id = '$userid' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');
            $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_id = '$ticketid'");
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));

            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
                {
                    $this->db->query("UPDATE ost_ticket_test 
                        SET source = '$source', topic_id = '$topicid', subtopic_id = '$subtopicid', sla_id = '$slaid', priority_id = '$priorityid', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent'
                        WHERE ticket_id = '$ticketid'");

                    if ($userid != '')
                    {
                        $this->db->query("UPDATE ost_ticket_test SET user_id = '$userid' WHERE ticket_id = '$ticketid'");
                    }

                    if ($datetime > $todaydatetime)
                    {
                        $this->db->query("UPDATE ost_ticket_test SET duedate = '$datetime' WHERE ticket_id = '$ticketid'");
                    }
                    else
                    {
                        $this->db->query("UPDATE ost_ticket_test SET duedate = NULL WHERE ticket_id = '$ticketid'");
                    }

                    $this->db->query("INSERT INTO ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticketid' ,'$poster_id', 'N' ,'$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");

                    redirect('staff_ticket_controller/ticketinfo?id='.$ticketid);
                }
                else
                {
                    echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
                }
            }
            else
            {
                echo "<script> alert('The number of unsolved tickets has exceeded maximum number allowed for a single user. Kindly assign this ticket to another user.');</script>";
            }
            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfoedit?id=$ticketid&uid=' </script>";
        }

        else       
        {
           redirect('user_controller/login');
        }
    }

    public function printpreviewstaff()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $ticketid = $_REQUEST['id']; 
        $data = array(
            
            'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                INNER JOIN ost_help_topic_test AS b ON b.topic_id = a.topic_id
                INNER JOIN ost_ticket_priority_test AS c ON c.priority_id = a.priority_id
                LEFT JOIN ost_staff_test AS d ON a.assigned_to = d.staff_id
                LEFT JOIN ost_team_test AS e ON a.team_id = e.team_id
                LEFT JOIN ost_sla_test AS f ON a.sla_id = f.id
                WHERE ticket_id = $ticketid"),

            'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test WHERE ticket_id = $ticketid"),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test 
                INNER JOIN ost_ticket_test ON ost_user_test.user_id = ost_ticket_test.user_id 
                WHERE ticket_id = '$ticketid'"),
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
                $this->load->view('staff/printpreviewstaff',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function subtopic()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $id= $_REQUEST['id'];
            $data = $this->db->query("SELECT id, VALUE FROM ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.`topic_id` = b.`topic_id` WHERE b.topic_id = '$id' ORDER BY value")->result();
            echo json_encode($data);
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function ticketuser_notes()
    {
        $ticket_id = $_REQUEST['id'];
        $poster_id = $_SESSION['staffid'];
        $user_id = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = $ticket_id")->row('user_id');
        $usernote = addslashes($this->input->post('usernote'));

        $this->db->query("UPDATE ost_user_test 
            SET notes = '$usernote', usernote_poster = '$poster_id', usernote_created = now(), user_updated_at = now() WHERE user_id = '$user_id'");

        redirect('staff_ticket_controller/ticketinfo?id='.$ticket_id);
    }

    public function deleteticketusernote()
    {
        $ticket_id = $_REQUEST['id'];
        $user_id = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$ticket_id'")->row('user_id');

        $this->db->query("UPDATE ost_user_test SET notes = NULL, usernote_poster = '0', usernote_created = NULL, user_updated_at = NOW() WHERE user_id = '$user_id'");

        redirect('staff_ticket_controller/ticketinfo?id='.$ticket_id);
    }

    public function staffupdate()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticketid = $_REQUEST['id'];
            $description = addslashes($this->input->post('response'));
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $signature = $this->input->post('signature');
            $sign = $this->input->post('sign');

            /*$departmentemail = $this->db->query("SELECT email FROM ost_email_test WHERE email_id = (SELECT autoresp_email_id FROM `ost_department_test` WHERE NAME = (SELECT department FROM ost_ticket_test WHERE ticket_id = '$ticketid'))")->row('email');
            // follow config email , not following here */
            
            $email = $this->db->query("SELECT b.user_email, b.user_name FROM ost_ticket_test a INNER JOIN ost_user_test b ON a.user_id = b.user_id WHERE ticket_id = '$ticketid'");
            $ticket_info = $this->db->query("SELECT a.number, a.assigned_to, a.team_id, a.reopened, a.ticket_updated, a.ticket_updated_by_id, a.ticket_updated_by_role, b.state, c.value FROM ost_ticket_test a 
                INNER JOIN ost_ticket_status_test b ON a.status_id = b.id 
                INNER JOIN ost_list_items_test c ON a.subtopic_id = c.id WHERE a.ticket_id = '$ticketid'");

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');

            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticket_info->row('ticket_updated'))));

            $auto_claim_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '63'");

            if ($ticket_info->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticket_info->row('ticket_updated_by_id') == $poster_id || $ticket_info->row('ticket_updated_by_role') == 'user')
            {
                if ($signature == 'none') 
                {
                    $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticketid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");
                }

                else if ($signature == 'mine')
                {
                    $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticketid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description<br>$sign', '$ipaddress', now(), now(), 'response', 'left')");
                }

                if ($auto_claim_tickets->row('value') == 1)
                { 
                    if ((empty($ticket_info->row('assigned_to')) && empty($ticket_info->row('team_id')) || (!empty($ticket_info->row('reopened')) && $ticket_info->row('state') == 'open')))
                    {
                        $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$poster_id' WHERE ticket_id = '$ticketid'");
                    }
                }

                $autoresponseusercheck = $this->db->query("SELECT message_auto_response FROM ost_department_test WHERE NAME = (SELECT department FROM ost_ticket_test WHERE ticket_id = '$ticketid')")->row('message_auto_response');
                $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');

                if ($autoresponseusercheck == '1')
                {
                    $data = array(
                        'body' => $this->db->query("SELECT REPLACE(REPLACE(subject, '%subject%', '".$ticket_info->row('value')."'), '%number%', '".$ticket_info->row('number')."') AS email_subject,
                            REPLACE(REPLACE(body, '%name%', '".$email->row('user_name')."'), '%response%', '$description') AS email
                            FROM ost_email_template_test WHERE code_name = 'ticket.reply' AND tpl_id = '$default_template_id'"),
                        'signature' => $signature,
                        'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                            INNER JOIN ost_department_test AS b ON a.dept_id = b.id
                            WHERE staff_id = '$poster_id'"),
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
                    ->to($email->row('user_email'))
                    ->subject($data['body']->row('email_subject'))
                    ->message($bodyContent)
                    ->send();
                }
                
                $solve = $this->input->post('solve');
                $this->db->query("UPDATE ost_ticket_test SET status_id = '$solve', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");

                if(isset($_POST['submit']))
                {
                    // Count total files
                    $countfiles = count($_FILES['file']['name']);

                    if ($_FILES['file']['name'][0] != "")
                    {
                        // Looping all files
                        for($i=0;$i<$countfiles;$i++)
                        {
                            $thread_id = $this->db->query("SELECT max(id) AS id FROM ost_thread_entry_test")->row('id');
                            $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                            // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                            $this->db->query("INSERT ost_file_test ( name, created , thread_entry_id )
                            VALUES ( '$filename', NOW(), '$thread_id' ) ");
                        }
                        echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                    }
                    else
                    {
                        echo "<script> alert('Message successfully sent.');</script>"; 
                    }
                }
            }
            else
            {
                echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
            }

            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }

        else
        {
            redirect('user_controller/login');
        }
    }

    public function ticketnote()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticketid = $this->input->post('id');
            $title = $this->input->post('title');
            $note = addslashes($this->input->post('note'));
            $statusid = $this->input->post('note_status_id');
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];

            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');

            $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_id = '$ticketid'");
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));

            if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
            {
                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , title , body , ip_address, created, updated, class, avatar )
                VALUES ('$ticketid' ,'$poster_id', 'N' ,'$posterfname $posterlname', '$title', '$note', '$ipaddress', now(), now(), 'note', 'left')");

                $this->db->query("UPDATE ost_ticket_test SET status_id = '$statusid', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid' ");

                if(isset($_POST['submit']))
                {
                    // Count total files
                    $countfiles = count($_FILES['file']['name']);

                    if ($_FILES['file']['name'][0] != "")
                    {
                        // Looping all files
                        for($i=0;$i<$countfiles;$i++)
                        {
                            $thread_id = $this->db->query("SELECT max(id) AS id FROM ost_thread_entry_test")->row('id');
                            $filename = $thread_id.'_'.$_FILES['file']['name'][$i];

                            // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                            $this->db->query("INSERT ost_file_test ( name, created , thread_entry_id )
                            VALUES ( '$filename', NOW(), '$thread_id' ) ");
                        }
                        echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                    }
                    else
                    {
                        echo "<script> alert('Message successfully sent.');</script>"; 
                    }
                }
            }
            else
            {
                echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
            }

            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }

        else
        {
            redirect('user_controller/login');
        }
    }

    public function changeticketstatus()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $check = $this->input->post('tids[]');
            $status = $this->input->post('status_id');
            $depart = $this->input->post('departmentid');
            $assignto = $this->input->post('assignto');
            $delete = $this->input->post('deleteticket'); 
            $poster_id = $_SESSION["staffid"];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            
            $notearr = array(
                'statusnote' => addslashes($this->input->post('statusnote')),
                'assignnote' => addslashes($this->input->post('assignnote')),
                'transfernote' => addslashes($this->input->post('transfernote')),
                'deletenote' => addslashes($this->input->post('deletenote')),
            );

            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('lastname');

            foreach ($check as $value)
            {
                $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_id = '$value'");
                $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
                $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));

                if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
                {
                    $primarypermscheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.edit%' AND ticket_id = '$value'")->num_rows();
                    $permissionscheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.edit%' AND C.`staff_id` = '$poster_id'")->num_rows();
                    $number = $this->db->query("SELECT number FROM osticket.ost_ticket_test WHERE ticket_id = '$value'")->row('number');

                    if ($permissionscheck != 0)
                    {
                        if ($status != "" )
                        {
                            if ($status == 3)
                            {
                                $primaryclosecheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.close%' AND ticket_id = '$value'")->num_rows();
                                $closecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.close%' AND C.`staff_id` = '$poster_id'")->num_rows();

                                if ($primaryclosecheck != 0) 
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$value'")->row('status_id');

                                    $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");

                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_id = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_id = '$value'");
                                    }

                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }

                                else if ($closecheck != 0)
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$value'")->row('status_id');

                                    $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");

                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_id = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_id = '$value'");
                                    }

                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }

                                else{
                                    echo "<script> alert('You have no permission for #$number');</script>";
                                }
                            }

                            else
                            {
                                $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$value'")->row('status_id');

                                $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");

                                $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                                if ($original == '3' && $new == 'open')
                                {
                                    $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_id = '$value'");
                                }
                                else if ($original != '3' && $new == 'closed')
                                {
                                    $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_id = '$value'");
                                }

                                echo "<script> alert('#$number Successfully change status');</script>";
                            }
                        }
                    
                        else if ($depart != "" )
                        {
                            $transfer_sla_id = $this->db->query("SELECT sla_id FROM `ost_department_test` WHERE name = '$depart' ")->row('sla_id');

                            $this->db->query("UPDATE ost_ticket_test SET department = '$depart', status_id = '8', sla_id = '$transfer_sla_id', assigned_to = '0', team_id = '0', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                            echo "<script> alert('#$number Successfully change department');</script>";
                        }

                        else if ($assignto{0} == 'a')
                        {
                            $staff_id = substr($assignto, 1);
                            $team_id = '0';

                            $primaryassigncheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_id = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_id` = '$poster_id'")->num_rows();

                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }

                        else if ($assignto{0} == 't')
                        {
                            $team_id = substr($assignto, 1);
                            $staff_id = '0';

                            $primaryassigncheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_id = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_id` = '$poster_id'")->num_rows();

                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else{
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }

                        else if ($delete == '5')
                        {
                            $primarydeletecheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.delete%' AND ticket_id = '$value'")->num_rows();
                            $deletecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.delete%' AND C.`staff_id` = '$poster_id'")->num_rows();

                            if ($primarydeletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully delete');</script>";
                            }

                            else if ($deletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully delete');</script>";
                            }

                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }

                        foreach ($notearr as $note)
                        {
                            if ($note != "")
                            {
                                $this->db->query("INSERT INTO ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar ) VALUES ('$value', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                            }
                        }
                    }

                    else if ($primarypermscheck != 0)
                    {
                        if ($status != "" )
                        {
                            if ($status == 3)
                            {
                                $primaryclosecheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.close%' AND ticket_id = '$value'")->num_rows();
                                $closecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.close%' AND C.`staff_id` = '$poster_id'")->num_rows();

                                if ($primaryclosecheck != 0)
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$value'")->row('status_id');

                                    $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");

                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_id = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_id = '$value'");
                                    }

                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }

                                else if ($closecheck != 0)
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_id = '$value'")->row('status_id');

                                    $this->db->query("UPDATE ost_ticket_test SET status_id = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");

                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE id = '$status'")->row('state');

                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_id = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_id = '$value'");
                                    }

                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }

                                else
                                {
                                    echo "<script> alert('You have no permission for #$number');</script>";
                                }
                            }
                        }
                    
                        else if ($depart != "" )
                        {
                          $this->db->query("UPDATE ost_ticket_test SET department = '$depart', status_id = '8', assigned_to = '0', team_id = '0', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                          echo "<script> alert('#$number Successfully change department');</script>";
                        }

                        else if ($assignto{0} == 'a')
                        {
                            $staff_id = substr($assignto, 1);
                            $team_id = '0';

                            $primaryassigncheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_id = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_id` = '$poster_id'")->num_rows();

                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }

                        else if ($assignto{0} == 't')
                        {
                            $team_id = substr($assignto, 1);
                            $staff_id = '0';

                            $primaryassigncheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_id = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_id` = '$poster_id'")->num_rows();

                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_id' , team_id = '$team_id' , status_id = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }

                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }

                        else if ($delete == '5')
                        {
                            $primarydeletecheck = $this->db->query("SELECT a.dept_id , a.role_id, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_id` = b.id INNER JOIN ost_department_test c ON a.dept_id = c.`id` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_id = '$poster_id' AND b.permissions LIKE '%ticket.delete%' AND ticket_id = '$value'")->num_rows();
                            $deletecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`id` = c.dept_id INNER JOIN ost_role_test d ON c.`role_id` = d.`id` WHERE a.ticket_id = '$value' AND d.permissions LIKE '%ticket.delete%' AND C.`staff_id` = '$poster_id'")->num_rows();

                            if ($primarydeletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully delete');</script>";
                            }

                            else if ($deletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_id = '$value' ");
                                echo "<script> alert('#$number Successfully delete');</script>";
                            }

                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }

                        foreach ($notearr as $note)
                        {
                            if ($note != "")
                            {
                                $this->db->query("INSERT INTO ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar ) VALUES ('$value', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                            }
                        }
                    }

                    else
                    {
                        echo "<script> alert('You have no permission for #$number');</script>";
                    }
                }
                else
                {
                    echo "<script> alert('Ticket(s) have been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
                }
            }
            
            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open&direct=open' </script>";
        }

        else       
        {
           redirect('user_controller/login');
        }
    }


    public function ticketinfo_assignuser()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticket_id = $_REQUEST['tid'];
            $user_id = $_REQUEST['id'];
            $poster_id = $_SESSION['staffid'];

            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_id = b.id WHERE a.user_id = '$user_id' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');
            $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_id = '$ticket_id'");
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));

            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
                {
                    $this->db->query("UPDATE ost_ticket_test SET user_id = '$user_id', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id='$ticket_id' ");

                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('firstname');
                    $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = $poster_id")->row('lastname');
                    $user_name = $this->db->query("SELECT * FROM ost_user_test WHERE user_id = $user_id")->row('user_name');

                    $description = '<b>'.$posterfname.''.$posterlname.'</b> change owenership of this ticcket to <strong>'.$user_name.'</strong>' ;

                    $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , staff_id , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES ('$ticket_id' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'pencil', 'left')");

                    echo "<script> alert('Successfully Assigned');</script>";
                }
                else
                {
                    echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
                }
            }
            else
            {
                echo "<script> alert('The number of unsolved tickets for this user has exceeded maximum number allowed for a single user. Kindly assign this ticket to another user.');</script>";
            }

            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticket_id' </script>";
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    //ajax search user assign ticket
    public function fetch_user()
    {
        $ticket_id = $_REQUEST['id'];
        $direct = $_REQUEST['direct'];
        $output = '';
        $query = '';
        $this->load->model('ajaxsearch_model');

        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
       
        $data = $this->ajaxsearch_model->fetch_data_user($query);
        
        if ($query == '') {
            $output .= '  
            ';
        }

        else if($data->num_rows() > 0)
        {
            $output .= '
              <div style="background-color: lightyellow;border-style:groove;border-width:1px;">
            ';

            if ($direct == 'new')
            {
                foreach($data->result() as $nrow)
                {
                    $output .= '
                    <div style="border-style:groove;border-width:1px;">
                        -- <b><a href ="ticketinfo_assignuser?id='.$nrow->user_id.'&tid='.$ticket_id.'">
                          <span>'.$nrow->user_name.'</span> (<span>'.$nrow->user_email.'</span>)
                        </a></b><br>
                    </div>
                    ';
                }
            }
            elseif ($direct == 'tinfo')
            {
                foreach($data->result() as $trow)
                {
                    $output .= '
                    <div style="border-style:groove;border-width:1px;">
                        -- <b><a href ="ticketinfoedit?id='.$ticket_id.'&uid='.$trow->user_id.'">
                          <span>'.$trow->user_name.'</span> (<span>'.$trow->user_email.'</span>)
                        </a></b><br>
                    </div>
                    ';
                }
            }

            $output .= '
              </div>
            ';
        }
          
        else
        {
            $output .= '<tr>
                <td colspan="5">No Data Found</td>
            </tr>';
        }
          
        echo $output;
    }

    //ajax search user assign ticket
    public function fetch_useropenticket()
    {
        $output = '';
        $query = '';
        $this->load->model('ajaxsearch_model');
        
        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
       
        $data = $this->ajaxsearch_model->fetch_data_user($query);
        
        if ($query == '') {
            $output .= '
            ';
        }
        else if($data->num_rows() > 0)
        {
            $output .= '
                <div style="background-color: lightyellow;border-style:groove;border-width:1px;">
            ';

            foreach($data->result() as $row)
            {
                $output .= '
                <div style="border-style:groove;border-width:1px;">
                    -- <b><a href ="newticket?id='.$row->user_id.'">
                        <span>'.$row->user_name.'</span> (<span>'.$row->user_email.'</span>)
                    </a></b><br>
                </div>
                ';
            }

            $output .= '
                </div>
            ';
        }
        else
        {
            $output .= '<tr>
                <td colspan="5">No Data Found</td>
            </tr>';
        }
      
        echo $output;
    }
}
?>