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
            $staff_guid = $_SESSION["staffid"];
            if ($userdeptid == '1') {
                $staff_list = $this->db->query("SELECT * FROM ost_staff_test ");
                $team_list = $this->db->query("SELECT * FROM ost_team_test ");
            } else {
                $staff_list = $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$userdeptid'");
                $team_list = $this->db->query("SELECT * FROM ost_team_test a LEFT JOIN ost_team_member_test b ON a.`team_guid` = b.`team_guid` WHERE b.`staff_guid` IN (SELECT staff_guid FROM ost_staff_test WHERE dept_guid = '$userdeptid') AND  a.flags = '1' GROUP BY a.team_guid ");
            }   
            $direct = $_REQUEST['direct'];
            $show_assigned_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '65'")->row('value');
            $show_answered_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '66'")->row('value');
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.department_guid WHERE a.id = '85'");
            if ($direct == 'open')
            {
                $result = $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                    INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid
                    WHERE c.state = 'open'
                    AND department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid')
                    AND (($show_assigned_tickets = '1' AND NOT ((a.assigned_to IS NOT NULL AND a.assigned_to != '0') OR (a.team_guid IS NOT NULL AND a.team_guid != '0'))) OR ($show_assigned_tickets = '0'))
                    AND (($show_answered_tickets = '1' AND a.ticket_guid NOT IN (SELECT ticket_guid FROM ost_thread_entry_test AS f WHERE f.type = 'S' AND a.created_at != f.created)) OR ($show_answered_tickets = '0'))");
            }
            else if ($direct == 'answered')
            {
                $result = $this->db->query("SELECT * FROM ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid 
                    INNER JOIN ost_user_test AS d ON a.user_guid = d.user_guid 
                    INNER JOIN ost_ticket_priority_test AS e ON e.priority_guid = a.priority_guid
                    INNER JOIN ost_thread_entry_test AS f ON a.ticket_guid = f.ticket_guid
                    WHERE f.type = 'S' AND a.created_at != f.created AND a.department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid') GROUP BY a.ticket_guid");
            }
            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_guid, a.role_guid, permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }
            $data = array(
                
                'result' => $result,
                'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
                'assignallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),
                'transferallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),
                'deleteallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),
                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                'department' => $department,
                'default_depart' => $defaultdept,
                'staff' => $staff_list,
                'team' => $team_list,
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
                $this->load->view('footerstaff');
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
            $staff_guid = $_SESSION["staffid"];  
            $userdeptid = $_SESSION['staffdept'];
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.department_guid WHERE a.id = '85'");
            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_guid, a.role_guid, permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }
            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                    INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid 
                    WHERE c.state = 'open' AND a.assigned_to = '$staff_guid' OR a.team_guid IN (SELECT team_guid FROM ost_team_member_test WHERE staff_guid = '$staff_guid') ORDER BY ticket_guid DESC"), 

                 'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
                'assignallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),
                'transferallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),
                'deleteallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),
                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                'department' => $department,
                'default_depart' => $defaultdept,
                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$userdeptid'"),
                'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
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
                $this->load->view('footerstaff');
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
            $staff_guid = $_SESSION["staffid"];  
            $userdeptid = $_SESSION['staffdept'];
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.department_guid WHERE a.id = '85'");
            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }
            /*$todaydate = date('Y-m-d');
            $time_utc=mktime(date('G'),date('i'),date('s'));
            $NowisTime=date(' G:i:s',$time_utc);*/
     
            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                    INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid 
                    WHERE c.state = 'open' AND duedate <= now() AND a.department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid')"), 
                 'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
                'assignallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),
                'transferallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),
                'deleteallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),
                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                'department' => $department,
                'default_depart' => $defaultdept,
                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$userdeptid'"),
                'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
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
                $this->load->view('footerstaff');
            }
        }
        else       
        {
           redirect('user_controller/superlogin');
        }
    }
    public function closed()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $staff_guid = $_SESSION["staffid"];  
            $userdeptid = $_SESSION['staffdept'];
            $defaultdept = $this->db->query("SELECT name, value FROM ost_config_test a INNER JOIN ost_department_test b ON a.value = b.department_guid WHERE a.id = '85'");
            if ($userdeptid == $defaultdept->row('value'))
            {
                $department = $this->db->query("SELECT name FROM ost_department_test WHERE name != '".$defaultdept->row('name')."'");
            }
            else
            {
                $department = $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$defaultdept->row('name')."'");
            }
            $data = array(
                
                'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                    INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid
                    WHERE c.state = 'closed' AND department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid')"),
                 'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
                'assignallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.assign%'")->num_rows(),
                'transferallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.transfer%'")->num_rows(),
                'deleteallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.delete%'")->num_rows(),
                'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                'department' => $department,
                'default_depart' => $defaultdept,
                'staff' => $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$userdeptid'"),
                'editallow' => $this->db->query(" SELECT dept_guid, a.role_guid ,b.`permissions` FROM ost_staff_test AS a INNER JOIN ost_role_test AS b ON a.`role_guid` = b.role_guid WHERE staff_guid = '$staff_guid' AND b.`permissions` LIKE '%ticket.edit%'")->num_rows(),
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
                $this->load->view('footerstaff');
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
            $user_guid = $_REQUEST['id'];
            $staff_guid = $_SESSION['staffid'];
            $userdeptid = $_SESSION['staffdept'];
            if ($userdeptid == '1') {
                $staff_list = $this->db->query("SELECT * FROM ost_staff_test ");
                $team_list = $this->db->query("SELECT * FROM ost_team_test ");
            } else {
                $staff_list = $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$userdeptid'");
                $team_list = $this->db->query("SELECT * FROM ost_team_test a LEFT JOIN ost_team_member_test b ON a.`team_guid` = b.`team_guid` WHERE b.`staff_guid` IN (SELECT staff_guid FROM ost_staff_test WHERE dept_guid = '$userdeptid') AND  a.flags = '1' GROUP BY a.team_guid ");
            }   
            $default_topic = $this->db->query("SELECT value FROM ost_config_test WHERE id ='102'");
            $manager = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$user_guid'")->row('manager');
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
            
            if ($user_guid != "")
            {
                $data = array(
                    'userinfo' => $this->db->query("SELECT * FROM ost_user_test AS a
                        LEFT JOIN ost_organization_test AS b ON a.user_org_guid = b.organization_guid
                        LEFT JOIN ost_staff_test AS c ON b.manager = '$staffid'
                        LEFT JOIN ost_team_test AS d ON b.manager = '$teamid'
                        WHERE user_guid = '$user_guid'"),
                    'stafftopic' => $this->db->query("SELECT * FROM ost_help_topic_test WHERE isactive = 1 ORDER BY topic"),
                    'staffdepart' => $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.create%' "),
                    'priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                    'sla' => $this->db->query("SELECT * FROM ost_sla_test WHERE isactive = 1 ORDER BY sla_guid"),
                    'defaultslaid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='86'"),
                    'defaultpriorityid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='9'"),
                    'defaultstatusid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='103'"),
                    'default_help_topic' => $default_topic,
                    'current_sub' => $this->db->query("SELECT list_item_guid, value FROM ost_list_items_test WHERE topic_guid = '".$default_topic->row('value')."' ORDER BY value"),
                    'agent' => $staff_list,
                    'team' => $team_list,
                    'status' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
                    'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
                    'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
                );
            }
            elseif ($user_guid == "")
            {
                $data = array(
                    'stafftopic' => $this->db->query("SELECT * FROM ost_help_topic_test WHERE isactive = 1 ORDER BY topic"),
                    'staffdepart' => $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.create%' "),
                    'priority' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
                    'sla' => $this->db->query("SELECT * FROM ost_sla_test WHERE isactive = 1 ORDER BY sla_guid"),
                    'defaultslaid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='86'"),
                    'defaultpriorityid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='9'"),
                    'defaultstatusid' => $this->db->query("SELECT * FROM ost_config_test WHERE id ='103'"),
                    'default_help_topic' => $default_topic,
                    'current_sub' => $this->db->query("SELECT list_item_guid, value FROM ost_list_items_test WHERE topic_guid = '".$default_topic->row('value')."' ORDER BY value"),
                    'agent' => $staff_list,
                    'team' => $team_list,
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
                $this->load->view('footerstaff');
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
            $status_guid = $this->input->post('statusId');
            $priority_guid = $this->input->post('priorityId');
            $sla_guid = $this->input->post('slaId');
            $subject = $this->input->post('topicId');
            $subtopic_guid = $this->input->post('subId');
            $description = $this->input->post('message');
            $assign_id = $this->input->post('assignId');
            $datetime = $this->input->post('datetime');
            $source = $this->input->post('source');
            $signature = $this->input->post('signature');
            $notes = $this->input->post('notes');
            $departid = $this->input->post('deptId');
            $poster_id = $_SESSION['staffid'];
            $userdepname = $this->db->query("SELECT * FROM ost_department_test WHERE department_guid = '$departid'")->row('name');
            $ticket_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id='39'")->row('value');
            $alluseremail = array();
            $allstaffemail = array();
            if ($assign_id != '')
            {
                if ($assign_id{0} == 'a')
                {
                    $staff_guid = substr($assign_id, 1);
                    $team_guid = '0';
                }
                else if ($assign_id{0} == 't')
                {
                    $team_guid = substr($assign_id, 1);
                    $staff_guid = '0';
                }
            }
            else
            {
                $team_guid = '0';
                $staff_guid = '0';
            }
            $user_guid = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->row('user_guid');
            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_guid = b.status_guid WHERE a.user_guid = '$user_guid' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');
            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                $result = $this->staff_new_ticket_model->add_new( $user_guid, $status_guid, $priority_guid, $userdepname, $sla_guid, $subject, $subtopic_guid, $description, $assign_id, $staff_guid, $team_guid, $datetime, $source, $user_name, $user_email, $notes );
                $ticketid = $this->db->query("SELECT * FROM ost_ticket_test WHERE user_guid = '$user_guid' ORDER BY created_at DESC LIMIT 1 ")->row('ticket_guid');
                $poster_id = $_SESSION['staffid'];      
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                $description = 'Created by <b>'.$posterfname.''.$posterlname.'</b>';
                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'magic', 'left')");
            
                $ticket_auto_response = $this->db->query("SELECT ticket_auto_response FROM ost_department_test WHERE NAME = (SELECT department FROM ost_ticket_test WHERE ticket_guid = '$ticketid')")->row('ticket_auto_response');
                $ticket_notice_active = $this->db->query("SELECT value FROM ost_config_test WHERE id='38'")->row('value');
                if(isset($_POST['submit']))
                {
                    // Count total files
                    $countfiles = count($_FILES['file']['name']);
                    // Looping all files
                    for($i=0;$i<$countfiles;$i++)
                    {
                        $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE created = now() AND type ='S'")->row('thread_entry_guid');
                        $filename = $thread_id.'_'.$_FILES['file']['name'][$i];
                        if ($_FILES['file']['name'][0] != "") 
                        {
                            // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);
                            $this->db->query("INSERT ost_file_test ( file_guid, name, created, thread_entry_guid )
                            VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");
                        }
                    }
                        
                }
                if ($ticket_auto_response == '1' && $ticket_notice_active == '1')
                {
                    $sql = "SELECT a.user_email FROM ost_user_test a WHERE a.user_depart = '$departid'";
                    $query = $this->db->query($sql);
                    $array1=$query->result_array();
                    $alluseremail = array_map (
                        function($value){
                        return $value['user_email'];
                        } , $array1
                    );
                    
                }
                if ($alertuser == '1')
                {
                    if (!in_array($user_email, $alluseremail))
                    {
                        array_push($alluseremail, $user_email);
                    }
                }
                else if($ticket_notice_active == '1')
                {
                    if (!in_array($user_email, $alluseremail))
                    {
                        array_push($alluseremail, $user_email);
                    }
                }
                foreach ($alluseremail as $value)
                {
                    $this->load->library('email');
                    $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE type ='S' ORDER BY created DESC LIMIT 1;")->row('thread_entry_guid');
                    $file_id = $this->db->query("SELECT name FROM ost_file_test WHERE thread_entry_guid='$thread_id'");
                    $email_attach = $this->db->query("SELECT value FROM ost_config_test WHERE id='69'")->row('value');
                    $allow_auth_tokens = $this->db->query("SELECT value FROM ost_config_test WHERE id='112'")->row('value');
                    $user_name = $this->db->query("SELECT user_name FROM ost_user_test WHERE user_email = '$value'")->row('user_name');
                    $emailinfo = $this->db->query("SELECT * FROM ost_user_test AS a
                        INNER JOIN ost_ticket_test AS b ON a.user_guid = b.user_guid
                        INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                        INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                        WHERE ticket_guid = '$result'");
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
                    if($email_attach=='1'){
                        if($file_id->num_rows() > 0){
                            foreach($file_id->result() as $value1){
                                $this->email->attach('uploads/'.$value1->name);
                            }
                        }
                    }
                    $this->email->send();
                }
                
                if($ticket_alert_active == '1')
                {
                    $ticket_alert_dept_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='41'")->row('value');
                    $ticket_alert_dept_members = $this->db->query("SELECT value FROM ost_config_test WHERE id='42'")->row('value');
                    $ticket_alert_acct_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='100'")->row('value');
                    if($ticket_alert_dept_manager == '1')
                    {
                        $dept_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b ON b.manager_guid = a.staff_guid WHERE b.department_guid = '$departid' ")->row('email');
                        if (!in_array($dept_manager_email, $allstaffemail))
                        {
                            array_push($allstaffemail, $dept_manager_email);
                        }
                    }
                    if($ticket_alert_dept_members == '1')
                    {
                        $dept_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE b.department_guid = '$departid' ")->result();
                        foreach($dept_members_email as $value)
                        {
                            if (!in_array($value->email, $allstaffemail))
                            {
                                array_push($allstaffemail, $value->email);
                            }
                        }
                    }
                    if($ticket_alert_acct_manager == '1')
                    {
                        $acct_manager = $this->db->query("SELECT b.manager FROM ost_user_test a INNER JOIN ost_organization_test b ON b.organization_guid = a.user_org_guid WHERE a.user_email = '$user_email' ")->row('manager');
                        if($acct_manager != '')
                        {  
                            if ($acct_manager{0} == 'a')
                            {
                                $staff_guid = substr($acct_manager, 1);
                                $acct_manager_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->result();
                            }
                            else if ($acct_manager{0} == 't')
                            {
                                $team_guid = substr($acct_manager, 1);
                                $acct_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid INNER JOIN ost_team_test c ON b.`team_guid` = c.`team_guid` WHERE c.team_guid = '$team_guid' ")->result();
                            }
                            foreach($acct_manager_email as $value)
                            {
                                if (!in_array($value->email, $allstaffemail))
                                {
                                    array_push($allstaffemail, $value->email);
                                }
                            }   
                        }
                    }
                }
                    foreach ($allstaffemail as $value)
                    {
                        $this->load->library('email');
                        $file_id = $this->db->query("SELECT name FROM ost_file_test WHERE thread_entry_guid='$thread_id'");
                        $email_attach = $this->db->query("SELECT value FROM ost_config_test WHERE id='69'")->row('value');
                        $username = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username, b.name FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE email = '$value'");
                        $emailinfo = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$result'");
                        $topicinfo = $this->db->query("SELECT * FROM ost_ticket_test b
                        INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                        INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                        WHERE ticket_guid = '$result'");
                        $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                        $login = 'http://[::1]/helpme/index.php/user_controller/login';
                        $data = array(
                            'body' => $this->db->query("SELECT REPLACE(subject, '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%creator%', '$posterfname$posterlname'), '%number%', '".$emailinfo->row('number')."'), '%department%', '".$username->row('name')."'), '%topic%', '".$topicinfo->row('topic')."'), '%subtopic%', '".$topicinfo->row('value')."') AS email
                                FROM ost_email_template_test WHERE code_name = 'ticket.alert' AND tpl_guid = '$default_template_id'"),
                            'signature' => $signature,
                            'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                                INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                                WHERE staff_guid = '$poster_id'"),
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
                        if($email_attach=='1' && $file_id->num_rows() > 0){
                            foreach($file_id->result() as $value1){
                                $this->email->attach('uploads/'.$value1->name);
                            }
                        }
                        $this->email->send();
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
            $userdeptid = $_SESSION['staffdept'];
            if ($userdeptid == '1') {
                $staff_list = $this->db->query("SELECT * FROM ost_staff_test ");
                $team_list = $this->db->query("SELECT * FROM ost_team_test ");
            } else {
                $staff_list = $this->db->query("SELECT * FROM ost_staff_test WHERE dept_guid = '$userdeptid'");
                $team_list = $this->db->query("SELECT * FROM ost_team_test a LEFT JOIN ost_team_member_test b ON a.`team_guid` = b.`team_guid` WHERE b.`staff_guid` IN (SELECT staff_guid FROM ost_staff_test WHERE dept_guid = '$userdeptid') AND  a.flags = '1' GROUP BY a.team_guid ");
            }
        $ticketid = $_REQUEST['id'];
        $staffid =$_SESSION['staffid'];
        $staff_guid =$_SESSION['staffid'];
        $userid = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row('user_guid');
        $taskid = $this->db->query("SELECT * FROM ost_task_test WHERE ticket_guid = '$ticketid'")->row('task_guid');
        $userticket = $this->db->query("SELECT * FROM ost_user_test AS a 
            INNER JOIN ost_ticket_test AS b ON a.user_guid = b.user_guid 
            WHERE ticket_guid = '$ticketid'");
        $default_depart = $this->db->query("SELECT name, value FROM ost_config_test a 
            INNER JOIN ost_department_test b ON a.value = b.department_guid WHERE a.id = '85'");
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
            $department = $this->db->query("SELECT dept_guid, a.role_guid, b.permissions ,c.`name`,c.`department_guid` FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staff_guid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staff_guid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.department_guid WHERE permissions LIKE '%ticket.transfer%' AND c.name != '".$default_depart->row('name')."'");
        }            
            $data = array(
                'result' => $this->db->query("SELECT a.*, b.*, c.*, d.*, e.*, a.team_guid as ticket_team_guid FROM ost_ticket_test AS a
                    INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                    INNER JOIN ost_ticket_priority_test AS d ON a.priority_guid = d.priority_guid 
                    INNER JOIN ost_list_items_test AS e ON a.subtopic_guid = e.list_item_guid
                    WHERE ticket_guid = '$ticketid' "),
            'department' => $department, 
            'editallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_guid= '$ticketid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%ticket.edit%'")->num_rows(),
            'assignallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_guid= '$ticketid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%ticket.assign%'")->num_rows(),
            'replyallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_guid= '$ticketid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%ticket.reply%'")->num_rows(),
            'transferallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_guid= '$ticketid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%ticket.transfer%'")->num_rows(),
            'deleteallow' => $this->db->query(" SELECT * FROM (SELECT dept_guid , role_guid FROM ost_staff_test WHERE staff_guid = '$staffid' UNION SELECT dept_guid , role_guid FROM ost_staff_dept_access_test WHERE staff_guid = '$staffid' ) a INNER JOIN ost_role_test b ON a.role_guid=b.role_guid INNER JOIN (SELECT ost_department_test.department_guid FROM ost_ticket_test LEFT JOIN ost_department_test ON ost_ticket_test.`department` = ost_department_test.`name` WHERE ticket_guid= '$ticketid') c ON a.dept_guid = c.department_guid  WHERE permissions LIKE '%ticket.delete%'")->num_rows(),
            'departmentsign' => $this->db->query("SELECT ost_department_test.signature FROM ost_department_test INNER JOIN ost_staff_test ON ost_department_test.department_guid = ost_staff_test.dept_guid WHERE staff_guid='$staffid'"), 
            'default_depart' => $default_depart,
                'staff' => $staff_list,
            'stafflogin' => $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid'")->row(),
                'team' => $team_list, 
            'task' => $this->db->query("SELECT a.*, b.*, c.*, d.*, e.*, c.name AS deptname, e.name AS teamname, a.staff_guid AS taskstaff, a.team_guid AS taskteam FROM ost_task_test AS a 
                INNER JOIN ost_task__cdata_test AS b ON a.task_guid = b.tasksub_guid
                INNER JOIN ost_department_test AS c ON a.dept_guid = c.department_guid
                LEFT JOIN ost_staff_test AS d ON a.staff_guid = d.staff_guid
                LEFT JOIN ost_team_test AS e ON a.team_guid = e.team_guid
                WHERE a.ticket_guid = '$ticketid' ORDER BY a.task_created DESC"),
            'thread' => $this->db->query("SELECT * FROM ost_thread_entry_test WHERE ticket_guid = '$ticketid' GROUP BY created"),
            'thread_num' => $this->db->query("SELECT * FROM ost_thread_entry_test WHERE ticket_guid = '$ticketid' AND type != 'E'"),
            'threadname' => $this->db->query("SELECT * FROM ost_staff_test AS a
                INNER JOIN ost_thread_entry_test AS b ON a.staff_guid = b.staff_guid
                INNER JOIN ost_ticket_test AS c ON b.`ticket_guid` = c.`ticket_guid`
                INNER JOIN ost_department_test AS d ON a.dept_guid = d.department_guid
                WHERE c.ticket_guid = '$ticketid'")->row(),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test AS a
                INNER JOIN ost_ticket_test AS b ON a.user_guid = b.user_guid
                LEFT JOIN ost_organization_test AS c ON c.organization_guid = a.user_org_guid
                WHERE ticket_guid = '$ticketid'"),
            'phone' => $phone,
            'editticket' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'"),
            'openclose' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row(),
            'org' => $this->db->query("SELECT * FROM ost_user_test AS a 
                INNER JOIN ost_ticket_test AS b ON a.user_guid = b.user_guid 
                LEFT JOIN ost_staff_test AS c ON a.usernote_poster = c.staff_guid
                LEFT JOIN ost_organization__cdata_test AS d ON a.user_org_guid = d.org_guid
                WHERE ticket_guid = '$ticketid'")->row(),
            'ticketstatus' => $this->db->query("SELECT * FROM ost_ticket_status_test"),
            'userticketcount' => $this->db->query("SELECT * FROM ost_ticket_test WHERE user_guid = '$userid'"),
            'userticketopen' => $this->db->query("SELECT * FROM ost_ticket_test AS a INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid WHERE b.state = 'open' AND a.user_guid = '$userid'"),
            'userticketclose' => $this->db->query("SELECT * FROM ost_ticket_test AS a INNER JOIN ost_ticket_status_test AS b ON a.status_guid = b.status_guid WHERE b.state = 'closed' AND a.user_guid = '$userid'"),
            'enable_avatars' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '93'"),
            'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
            'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
            'canned_response' => $this->db->query("SELECT title, response FROM ost_canned_response WHERE isenabled = '1'"),
            'enable_premade' => $this->db->query("SELECT value FROM ost_config_test WHERE id='27'")->row('value'),
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
            $this->load->view('footerstaff');
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
        $status = $this->input->post('status_guid');
        $depart = $this->input->post('departmentid');
        $assignto = $this->input->post('assignto');
        $delete = $this->input->post('deleteticket'); 
        $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
        $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
        $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));
        $assigned_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id = '59'")->row('value');
        $assigned_alert_staff = $this->db->query("SELECT value FROM ost_config_test WHERE id = '60'")->row('value');
        $assigned_alert_team_lead = $this->db->query("SELECT value FROM ost_config_test WHERE id = '61'")->row('value');
        $assigned_alert_team_members = $this->db->query("SELECT value FROM ost_config_test WHERE id = '62'")->row('value');
        $transfer_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id = '51'")->row('value');
        $transfer_alert_assigned = $this->db->query("SELECT value FROM ost_config_test WHERE id = '52'")->row('value');
        $transfer_alert_dept_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id = '53'")->row('value');
        $transfer_alert_dept_members = $this->db->query("SELECT value FROM ost_config_test WHERE id = '54'")->row('value');
        $alluseremail = array();
        if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
        {
            if ($status != "" )
                {
                    if ($status == 3)
                    {
                        $primaryclosecheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.close%' AND ticket_guid = '$ticketid'")->num_rows();
                        $closecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$ticketid' AND d.permissions LIKE '%ticket.close%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                        if ($primaryclosecheck != 0)
                        {
                            $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row('status_guid');
                            $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                            $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                            if ($original != '3' && $new == 'closed')
                            {
                                $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL, ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid'");
                            }
                            $poster_id = $_SESSION['staffid'];      
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                            $description = 'Closed by <b>'.$posterfname.''.$posterlname.'</b>';
                            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'thumbs-up-alt', 'left')");
                            echo "<script> alert('Successfully change status');</script>";
                        }
                        else if ($closecheck != 0)
                        {
                            $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row('status_guid');
                            $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                            $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                            if ($original != '3' && $new == 'closed')
                            {
                                $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL, ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid'");
                            }
                            $poster_id = $_SESSION['staffid'];      
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                            $description = 'Closed by <b>'.$posterfname.''.$posterlname.'</b>';
                            $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'thumbs-up-alt', 'left')");
                            echo "<script> alert('Successfully change status');</script>";
                        }
                        else
                        {
                            echo "<script> alert('You have no permission for this ticket');</script>";
                        }
                    }
                    
                    else
                    {
                        $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row('status_guid');
                        
                        
                        $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                        if ($original == '3' && $new == 'open')
                        {
                            $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status',closed = NULL, reopened = now(), ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid'");
                            $poster_id = $_SESSION['staffid'];      
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                            $description = 'Reopened by <b>'.$posterfname.''.$posterlname.'</b>';
                            $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                            VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'rotate-right', 'left')");
                        } else{
                            $statusname = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = $status")->row('name');
                        $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                        
                        $poster_id = $_SESSION['staffid'];      
                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                        $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                        $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                        $description = '<b>'.$posterfname.''.$posterlname.'</b> change status of this ticket to <strong>'.$statusname.'</strong>' ;
                        $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                        VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'pencil', 'left')");
                            
                        }
                        echo "<script> alert('Successfully change status');</script>";
                    }
                }
            
            else if ($depart != "" )
            {
                $transfer_sla_guid = $this->db->query("SELECT sla_guid FROM `ost_department_test` WHERE name = '$depart' ")->row('sla_guid');
                $this->db->query("UPDATE ost_ticket_test SET department = '$depart', status_guid = '8', sla_guid = '$transfer_sla_guid', assigned_to = '0', team_guid = '0', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                $poster_id = $_SESSION['staffid'];      
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                $departmentname = $this->db->query("SELECT * FROM ost_department_test WHERE name = '$depart'")->row('name');
                $description = '<b>'.$posterfname.''.$posterlname.'</b> transfered this ticket to <strong>'.$departmentname. '</strong>';
                $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'share-alt', 'left')");
                if($transfer_alert_active == '1')
                            {
                                if($transfer_alert_assigned == '1')
                                {
                                    $assigned = $this->db->query("SELECT assigned_to, team_guid FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
                                    if($assigned->row('assigned_to') != '' && $assigned->row('team_guid') != '')
                                    {
                                        if($assigned->row('assigned_to') != '0')
                                        {
                                            $assigned_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$assigned->row('assigned_to')."'")->row('email');
                                            if (!in_array($assigned_email, $alluseremail))
                                            {
                                                array_push($alluseremail, $assigned_email);
                                            }
                                        }
                                        else
                                        {
                                            $assigned_teamlead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE team_guid = '".$assigned->row('team_guid')."'")->row('email');
                                            if (!in_array($assigned_teamlead_email, $alluseremail))
                                            {
                                                array_push($alluseremail, $assigned_teamlead_email);
                                            }
                                            $assigned_teammem_emails = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE team_guid = '".$assigned->row('assigned_to')."'");
                                            foreach($assigned_teammem_emails->result() as $value3)
                                            {
                                                if (!in_array($value3->email, $alluseremail))
                                                {
                                                    array_push($alluseremail, $value3->email);
                                                }
                                            }
                                        }
                                    }
                                }
                                if($transfer_alert_dept_manager == '1')
                                {
                                    $dept_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b ON b.manager_guid = a.staff_guid WHERE b.name = '$depart'")->row('email');
                                    if (!in_array($dept_manager_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $dept_manager_email);
                                    }
                                }
                                if($transfer_alert_dept_members == '1')
                                {
                                    $dept_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b on b.department_guid = a.dept_guid WHERE b.name = '$depart'");
                                    foreach($dept_members_email->result() as $email)
                                    {
                                        if (!in_array($email->email, $alluseremail))
                                        {
                                            array_push($alluseremail, $email->email);
                                        }
                                    }
                                }
                            }
                echo "<script> alert('Successfully change department');</script>";
            }
            else if ($assignto{0} == 'a')
            {
                $staff_guid = substr($assignto, 1);
                $team_guid = '0';
                $poster_id = $_SESSION['staffid'];      
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                $assignstafffname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $staff_guid")->row('firstname');
                $assignstafflname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $staff_guid")->row('lastname');
                $description = '<b>'.$posterfname.''.$posterlname.'</b> assigned this ticket to <strong>'.$assignstafffname. ''.$assignstafflname. '</strong>';
                $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'hand-right', 'left')");
                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid', status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                echo "<script> alert('Successfully assigned to agent');</script>";
                if($assigned_alert_active == '1')
                {
                    if($assigned_alert_staff == '1')
                    {
                        $staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('email');
                        if (!in_array($staff_email, $alluseremail))
                        {
                            array_push($alluseremail, $staff_email);
                        }
                    }
                }
            }
            else if ($assignto{0} == 't')
            {
                $team_guid = substr($assignto, 1);
                $staff_guid = '0';
                $poster_id = $_SESSION['staffid'];      
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                $assignteamname = $this->db->query("SELECT * FROM ost_team_test WHERE team_guid = '$team_guid' ")->row('name');
                $description = '<b>'.$posterfname.''.$posterlname.'</b> assigned this ticket to <strong>'.$assignteamname. '</strong>';
                $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'hand-right', 'left')");
                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid', status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                if($assigned_alert_active == '1')
                {
                    if($assigned_alert_team_lead == '1')
                    {
                        $team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$team_guid'")->row('email');
                        if (!in_array($team_lead_email, $alluseremail))
                        {
                            array_push($alluseremail, $team_lead_email);
                        }
                    }
                    if($assigned_alert_team_members == '1')
                    {
                        $team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$team_guid'");
                        foreach($team_members_email->result() as $value)
                        {
                            if (!in_array($value->email, $alluseremail))
                            {
                                array_push($alluseremail, $value->email);
                            }
                        }
                    }
                }
                echo "<script> alert('Successfully assigned to team');</script>";
            }
            else if ($delete == '5')
            {
                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
                $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE ticket_guid = '$ticketid'");
                echo "<script> alert('Successfully deleted');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open&direct=open' </script>";    
            }
            $poster_id = $_SESSION["staffid"];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            
            $notearr = array(
                'statusnote' => addslashes($this->input->post('statusnote')),
                'assignnote' => addslashes($this->input->post('assignnote')),
                'transfernote' => addslashes($this->input->post('transfernote')),
                'deletenote' => addslashes($this->input->post('deletenote')),
            );
            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');
            foreach ($alluseremail as $value)
            {
                $this->load->library('email');
                $username = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username, b.name FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE email = '$value'");
                $poster = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username FROM ost_staff_test a WHERE staff_guid = '$poster_id'")->row('username');
                $emailinfo = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
                $topicinfo = $this->db->query("SELECT * FROM ost_ticket_test b
                INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                WHERE ticket_guid = '$ticketid'");
                
                $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                if($depart != '')
                {
                    $data = array(
                        'body' => $this->db->query("SELECT REPLACE(REPLACE(subject, '%number%', '".$emailinfo->row('number')."'), '%department%', '".$depart."') AS email_subject, 
                            REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%assigner%', '$poster'), '%number%', '".$emailinfo->row('number')."'), '%department%', '".$depart."'), '%comment%', '".$notearr['transfernote']."') AS email
                            FROM ost_email_template_test WHERE code_name = 'transfer.alert' AND tpl_guid = '$default_template_id'"),
                        'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                            INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                            WHERE staff_guid = '$poster_id'"),
                        'template' => $this->db->query("SELECT * FROM ost_company_test"),
                    );
                }
                else
                {
                    $data = array(
                        'body' => $this->db->query("SELECT REPLACE(subject, '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                            REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%assigner%', '$poster'), '%number%', '".$emailinfo->row('number')."'), '%topic%', '".$topicinfo->row('topic')."'), '%department%', '".$username->row('name')."'), '%subtopic%', '".$topicinfo->row('value')."') AS email
                            FROM ost_email_template_test WHERE code_name = 'assigned.alert' AND tpl_guid = '$default_template_id'"),
                        'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                            INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                            WHERE staff_guid = '$poster_id'"),
                        'template' => $this->db->query("SELECT * FROM ost_company_test"),
                    );
                }
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
            foreach ($notearr as $note)
            {
                if ($note != "")
                {
                    $this->db->query("INSERT INTO ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
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
       redirect('user_controller/superlogin');
    }
}
public function editorupdate()
{      
    if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
    {
        $threadid = $this->input->post('threadguid');
        $body = addslashes($this->input->post('threadbody'));
       $staffid = $_SESSION['staffid'];
        $editor = $this->db->query("SELECT CONCAT(firstname,' ',lastname) as editor FROM ost_staff_test WHERE staff_guid = '$staffid'")->row('editor');
        $lastbody = $this->db->query("SELECT body FROM ost_thread_entry_test WHERE thread_entry_guid = '$threadid'")->row('body');
        $this->db->query("UPDATE ost_thread_entry_test SET body = '$body', last_body = '$lastbody', editor = '$editor', updated = NOW() WHERE thread_entry_guid = '$threadid'");
        $ticketid = $this->db->query("SELECT ticket_guid FROM ost_thread_entry_test WHERE thread_entry_guid = '$threadid'")->row('ticket_guid');
         echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
    }
     else       
    {
       redirect('user_controller/superlogin');
    }
}
public function ticketinfoedit()
{      
    if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
    {
        $ticketid = $_REQUEST['id'];
        $userid = $_REQUEST['uid'];
        $poster_id = $_SESSION["staffid"];   
        $phone = $this->db->query("SELECT * FROM ost_ticket_test AS a 
            INNER JOIN ost_user_test AS b ON a.user_guid = b.user_guid
            WHERE ticket_guid = '$ticketid'")->row('user_phone');
        $phoneext = $this->db->query("SELECT * FROM ost_ticket_test AS a 
            INNER JOIN ost_user_test AS b ON a.user_guid = b.user_guid
            WHERE ticket_guid = '$ticketid'")->row('user_phoneext');
        $current_topic = $this->db->query("SELECT topic_guid FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
        if ($phoneext != "")
        {
            $phone = $phone.'('.$phoneext.')';
        }
        $data = array(
            'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
                INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid 
                INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid
                INNER JOIN ost_ticket_priority_test AS d ON a.priority_guid = d.priority_guid 
                INNER JOIN ost_list_items_test AS e ON a.subtopic_guid = e.list_item_guid
                WHERE ticket_guid = '$ticketid'"),
            'topic' => $this->db->query("SELECT * FROM ost_help_topic_test ORDER BY topic"),
            'inventory' => $this->db->query("SELECT * FROM  ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.topic_guid = b.topic_guid INNER JOIN ost_ticket_test AS c ON b.topic_guid = c.topic_guid WHERE c.ticket_guid = '$ticketid'"),
            'subt' => $this->db->query("SELECT * FROM  ost_list_items_test INNER JOIN ost_ticket_test ON ost_list_items_test.list_item_guid = ost_ticket_test.subtopic_guid WHERE ticket_guid = '$ticketid'"),
            'current_sub' => $this->db->query("SELECT list_item_guid, value FROM ost_list_items_test WHERE topic_guid = '".$current_topic->row('topic_guid')."' ORDER BY value"),
            'sla' => $this->db->query("SELECT * FROM ost_sla_test"),
            'status' => $this->db->query("SELECT * FROM ost_ticket_priority_test"),
            
            'user' => $this->db->query("SELECT * FROM ost_user_test AS a INNER JOIN ost_ticket_test AS b ON a.user_guid = b.user_guid WHERE ticket_guid = '$ticketid'"),
            'newuser' => $this->db->query("SELECT * FROM ost_user_test WHERE user_guid = '$userid'"),
            'phone' => $phone,
            'editticket' => $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'"),
            'departmt' => $this->db->query("SELECT * FROM  ost_department_test AS a INNER JOIN ost_user_test AS b ON a.department_guid = b.user_depart INNER JOIN ost_ticket_test AS c ON b.user_guid = c.user_guid WHERE ticket_guid = '$ticketid'")->row(),
        );
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
                    $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');
                   
                    $description = '<b>'.$posterfname.''.$posterlname.'</b> edited ticket.' ;
                    $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'pencil', 'left')");            
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
            $this->load->view('footerstaff');
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
        $user_guid = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'")->row('user_guid');
        $cemail = addslashes($this->input->post('cemail'));
        $cusername = addslashes($this->input->post('cusername'));
        $cphone = addslashes($this->input->post('cphone'));
        $cphoneext = addslashes($this->input->post('cphoneext'));
        $cnote = addslashes($this->input->post('cnote'));
        $usernamecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_guid != '$user_guid' AND user_name = '$cusername' ")->num_rows();
        $useremailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_guid != '$user_guid' AND user_email = '$cemail' ")->num_rows();
        $splitemail = explode('@', $cemail);
        $domain = '@'.$splitemail[1];
        $org = $this->db->query("SELECT * FROM ost_organization_test");
        $user_orgid = $this->db->query("SELECT * FROM ost_user_test AS a
            LEFT JOIN ost_organization_test AS b ON a.user_org_guid = b.id
            WHERE user_guid = '$user_guid'")->row('id');
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
                WHERE user_guid = '$user_guid' ");
            foreach ($org->result() as $orgdomain)
            {
                if ($orgdomain->organization_guid != $user_orgid && $orgdomain->domain == $domain)
                {
                    $this->db->query("UPDATE ost_user_test SET user_org_guid = '$orgdomain->organization_guid' WHERE user_guid = '$user_guid' ");
                    echo "<script> alert('User has been auto add into organization $orgdomain->name due to email domain setting in organization page.');</script>";
                }
            }
            if ($cnote != "")
                $this->db->query("UPDATE ost_user_test SET usernote_poster = '$poster_id', usernote_created = now() WHERE user_guid = '$user_guid' ");
            else
                $this->db->query("UPDATE ost_user_test SET usernote_poster = '0', usernote_created = NULL WHERE user_guid = '$user_guid' ");
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
        $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
        $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
        $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_guid = b.status_guid WHERE a.user_guid = '$userid' AND b.state = 'open'")->row('count');
        $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');
        $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
        $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
        $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));
        if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
        {
            if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
            {
                $this->db->query("UPDATE ost_ticket_test 
                    SET source = '$source', topic_guid = '$topicid', subtopic_guid = '$subtopicid', sla_guid = '$slaid', priority_guid = '$priorityid', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent'
                    WHERE ticket_guid = '$ticketid'");
                if ($userid != '')
                {
                    $this->db->query("UPDATE ost_ticket_test SET user_guid = '$userid' WHERE ticket_guid = '$ticketid'");
                }
                if ($datetime > $todaydatetime)
                {
                    $this->db->query("UPDATE ost_ticket_test SET duedate = '$datetime' WHERE ticket_guid = '$ticketid'");
                }
                else
                {
                    $this->db->query("UPDATE ost_ticket_test SET duedate = NULL WHERE ticket_guid = '$ticketid'");
                }
                $this->db->query("INSERT INTO ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'N' ,'$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
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
       redirect('user_controller/superlogin');
    }
}
public function printpreviewstaff()
{      
    if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
    {
    $ticketid = $_REQUEST['id']; 
    $data = array(
        
        'result' => $this->db->query("SELECT * FROM  ost_ticket_test AS a
            INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid
            INNER JOIN ost_ticket_priority_test AS c ON c.priority_guid = a.priority_guid
            LEFT JOIN ost_staff_test AS d ON a.assigned_to = d.staff_guid
            LEFT JOIN ost_team_test AS e ON a.team_guid = e.team_guid
            LEFT JOIN ost_sla_test AS f ON a.sla_guid = f.sla_guid
            WHERE ticket_guid = '$ticketid'"),
        'thread' => $this->db->query("SELECT * FROM  ost_thread_entry_test WHERE ticket_guid = '$ticketid' GROUP BY created"),
        
        'user' => $this->db->query("SELECT * FROM ost_user_test 
            INNER JOIN ost_ticket_test ON ost_user_test.user_guid = ost_ticket_test.user_guid 
            WHERE ticket_guid = '$ticketid'"),
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
       redirect('user_controller/superlogin');
    }
}
public function subtopic()
{
    if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
    {   
        $id= $_REQUEST['id'];
        $data = $this->db->query("SELECT list_item_guid, VALUE FROM ost_list_items_test AS a INNER JOIN ost_help_topic_test AS b ON a.`topic_guid` = b.`topic_guid` WHERE b.topic_guid = '$id' ORDER BY value")->result();
        echo json_encode($data);
    }
    else       
    {
       redirect('user_controller/superlogin');
    }
}
public function ticketuser_notes()
{
    $ticket_guid = $_REQUEST['id'];
    $poster_id = $_SESSION['staffid'];
    $user_guid = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = $ticket_guid")->row('user_guid');
    $usernote = addslashes($this->input->post('usernote'));
    $this->db->query("UPDATE ost_user_test 
        SET notes = '$usernote', usernote_poster = '$poster_id', usernote_created = now(), user_updated_at = now() WHERE user_guid = '$user_guid'");
    redirect('staff_ticket_controller/ticketinfo?id='.$ticket_guid);
}
public function deleteticketusernote()
{
    $ticket_guid = $_REQUEST['id'];
    $user_guid = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticket_guid'")->row('user_guid');
    $this->db->query("UPDATE ost_user_test SET notes = NULL, usernote_poster = '0', usernote_created = NULL, user_updated_at = NOW() WHERE user_guid = '$user_guid'");
    redirect('staff_ticket_controller/ticketinfo?id='.$ticket_guid);
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
            
            $email = $this->db->query("SELECT b.user_email, b.user_name FROM ost_ticket_test a INNER JOIN ost_user_test b ON a.user_guid = b.user_guid WHERE ticket_guid = '$ticketid'");
            $ticket_info = $this->db->query("SELECT a.number, a.assigned_to, a.team_guid, a.reopened, a.ticket_updated, a.ticket_updated_by_id, a.ticket_updated_by_role, b.state, c.value FROM ost_ticket_test a 
                INNER JOIN ost_ticket_status_test b ON a.status_guid = b.status_guid 
                INNER JOIN ost_list_items_test c ON a.subtopic_guid = c.list_item_guid WHERE a.ticket_guid = '$ticketid'");
            $poster_info = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id");
            $posterfname = $poster_info->row('firstname');
            $posterlname = $poster_info->row('lastname');
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticket_info->row('ticket_updated'))));
            $auto_claim_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '63'");
            $message_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id='43'")->row('value');
            $alluseremail = array();
            if ($ticket_info->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticket_info->row('ticket_updated_by_id') == $poster_id || $ticket_info->row('ticket_updated_by_role') == 'user')
            {
                if ($signature == 'none') 
                {
                    $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");
                }
                else if ($signature == 'mine')
                {
                    $sql = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'S' ,'$posterfname $posterlname', '$description<br>$sign', '$ipaddress', now(), now(), 'response', 'left')");
                }
                if ($auto_claim_tickets->row('value') == 1)
                { 
                    if ((empty($ticket_info->row('assigned_to')) && empty($ticket_info->row('team_guid')) || (!empty($ticket_info->row('reopened')) && $ticket_info->row('state') == 'open')))
                    {
                        $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$poster_id' WHERE ticket_guid = '$ticketid'");
                    }
                }
                /*$solve = $this->input->post('solve');*/
                $this->db->query("UPDATE ost_ticket_test SET ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                if(isset($_POST['submit']))
                {
                    // Count total files
                    $countfiles = count($_FILES['file']['name']);
                    if ($_FILES['file']['name'][0] != "")
                    {
                        // Looping all files
                        for($i=0;$i<$countfiles;$i++)
                        {
                            $thread_id = $this->db->query("SELECT thread_entry_guid as id FROM ost_thread_entry_test WHERE created = (SELECT max(created) FROM ost_thread_entry_test)")->row('id');
                            $filename = $thread_id.'_'.$_FILES['file']['name'][$i];
                            // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);
                            $this->db->query("INSERT ost_file_test ( file_guid, name, created , thread_entry_guid )
                            VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");
                        }
                        echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                    }
                    else
                    {
                        echo "<script> alert('Message successfully sent.');</script>"; 
                    }
                }
                if($message_alert_active == '1')
                {
                    $message_alert_laststaff = $this->db->query("SELECT value FROM ost_config_test WHERE id='44'")->row('value');
                    $message_alert_assigned = $this->db->query("SELECT value FROM ost_config_test WHERE id='45'")->row('value');
                    $message_alert_dept_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='46'")->row('value');
                    $message_alert_acct_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='101'")->row('value');
                    if($message_alert_laststaff == '1')
                    {
                        $thread_ids = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE type ='S' and ticket_guid = '$ticketid';");
                        if($thread_ids->num_rows() > 1)
                        {
                            $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE type = 'S' and ticket_guid = '$ticketid' ORDER BY created DESC LIMIT 1,1;");
                            if($thread_id->row('staff_guid') == '0')
                            {
                                $last_res_email = $this->db->query("SELECT user_email FROM ost_user_test WHERE user_guid = '".$thread_id->row('user_guid')."'")->row('user_email');
                            }
                            else
                            {
                                $last_res_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$thread_id->row('staff_guid')."'")->row('email');
                            }
                            if (!in_array($last_res_email, $alluseremail))
                            {
                                array_push($alluseremail, $last_res_email);
                            }
                        }
                    }
                    if($message_alert_assigned == '1')
                    {
                        $ticket = $this->db->query("SELECT * FROM ost_ticket_test a WHERE ticket_guid = '$ticketid'");
                        if($ticket->row('assigned_to') != '' || $ticket->row('team_guid') != '')
                        {
                            if($ticket->row('assigned_to') != '0')
                            {
                                $assigned_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$ticket->row('assigned_to')."'")->row('email');
                                if (!in_array($assigned_email, $alluseremail))
                                {
                                    array_push($alluseremail, $assigned_email);
                                }
                            }
                            else if($ticket->row('team_guid') != '0')
                            {
                                $assigned_emails = $this->db->query("SELECT email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '".$ticket->row('team_guid')."'");
                                foreach($assigned_emails->result() as $value)
                                {
                                    if (!in_array($value->email, $alluseremail))
                                    {
                                        array_push($alluseremail, $value->email);
                                    }
                                }
                            }
                        }
                    }
                    if($message_alert_dept_manager == '1')
                    {
                        $dept_manager_email = $this->db->query("SELECT c.email FROM ost_staff_test c INNER JOIN ost_department_test a ON c.staff_guid=a.`manager_guid` INNER JOIN ost_ticket_test b ON a.name= b.`department` WHERE ticket_guid = '$ticketid'")->row('email');
                        if (!in_array($dept_manager_email, $alluseremail))
                        {
                            array_push($alluseremail, $dept_manager_email);
                        }
                    }
                    if($message_alert_acct_manager == '1')
                    {
                        $acct_manager = $this->db->query("SELECT b.manager FROM ost_user_test a INNER JOIN ost_organization_test b ON b.organization_guid = a.user_org_guid WHERE a.user_email = '".$email->row('user_email')."' ")->row('manager');
                        if($acct_manager != '')
                        {  
                            if ($acct_manager{0} == 'a')
                            {
                                $staff_guid = substr($acct_manager, 1);
                                $acct_manager_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->result();
                            }
                            else if ($acct_manager{0} == 't')
                            {
                                $team_guid = substr($acct_manager, 1);
                                $acct_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid INNER JOIN ost_team_test c ON b.`team_guid` = c.`team_guid` WHERE c.team_guid = '$team_guid' ")->result();
                            }
                            foreach($acct_manager_email as $value)
                            {
                                if (!in_array($value->email, $alluseremail))
                                {
                                    array_push($alluseremail, $value->email);
                                }
                            }   
                        }
                    }
                }
                foreach ($alluseremail as $value)
                    {
                        $this->load->library('email');
                        $username = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username, b.name FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE email = '$value'");
                        $emailinfo = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
                        $topicinfo = $this->db->query("SELECT * FROM ost_ticket_test b
                        INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                        INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                        WHERE ticket_guid = '$ticketid'");
                        $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                        $login = 'http://[::1]/helpme/index.php/user_controller/login';
                        $data = array(
                            'body' => $this->db->query("SELECT REPLACE(subject, '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%creator%', '$posterfname$posterlname'), '%number%', '".$emailinfo->row('number')."'), '%department%', '".$username->row('name')."'), '%topic%', '".$topicinfo->row('topic')."'), '%subtopic%', '".$topicinfo->row('value')."') AS email
                                FROM ost_email_template_test WHERE code_name = 'message.alert' AND tpl_guid = '$default_template_id'"),
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
                
                /*$autoresponseusercheck = $this->db->query("SELECT message_auto_response FROM ost_department_test WHERE NAME = (SELECT department FROM ost_ticket_test WHERE ticket_guid = '$ticketid')")->row('message_auto_response');
                $message_autoresponder = $this->db->query("SELECT value FROM ost_config_test WHERE id='37'")->row('value');
                $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                if ($autoresponseusercheck == '1' && $message_autoresponder == '1')
                {
                    $data = array(
                        'body' => $this->db->query("SELECT REPLACE(REPLACE(body, '%user_name%', '".$email->row('user_name')."'), '%number%', '".$ticket_info->row('number')."') AS email, subject FROM ost_email_template_test WHERE code_name = 'message.autoresp' AND tpl_guid = '$default_template_id'"),
                        'signature' => $signature,
                        'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                            INNER JOIN ost_department_test AS b ON a.dept_guid = b.id
                            WHERE staff_guid = '$poster_id'"),
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
                    ->to($poster_info->row('email'))
                    ->subject($data['body']->row('subject'))
                    ->message($bodyContent)
                    ->send();
                }*/
                
            }
            else
            {
                echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
            }
            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }
        else
        {
            redirect('user_controller/superlogin');
        }
    }
    public function ticketnote()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticketid = $this->input->post('id');
            $title = $this->input->post('title');
            $note = addslashes($this->input->post('note'));
            $statusid = $this->input->post('note_status_guid');
            $poster_id = $_SESSION['staffid'];
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $message_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id='43'")->row('value');
            $alluseremail = array();
            $email = $this->db->query("SELECT b.user_email, b.user_name FROM ost_ticket_test a INNER JOIN ost_user_test b ON a.user_guid = b.user_guid WHERE ticket_guid = '$ticketid'");
            $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
            $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
            $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));
            if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
            {
                $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, ticket_guid , staff_guid , type, poster , title , body , ip_address, created, updated, class, avatar )
                VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid' ,'$poster_id', 'N' ,'$posterfname $posterlname', '$title', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                $this->db->query("UPDATE ost_ticket_test SET ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$ticketid' ");
                if(isset($_POST['submit']))
                {
                    // Count total files
                    $countfiles = count($_FILES['file']['name']);
                    if ($_FILES['file']['name'][0] != "")
                    {
                        // Looping all files
                        for($i=0;$i<$countfiles;$i++)
                        {
                            $thread_id = $this->db->query("SELECT thread_entry_guid as id FROM ost_thread_entry_test WHERE created = (SELECT max(created) FROM ost_thread_entry_test)")->row('id');
                            $filename = $thread_id.'_'.$_FILES['file']['name'][$i];
                            // Upload file
                            move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);
                            $this->db->query("INSERT ost_file_test ( file_guid, name, created , thread_entry_guid )
                            VALUES ( REPLACE(UPPER(UUID()),'-',''), '$filename', NOW(), '$thread_id' ) ");
                        }
                        echo "<script> alert('$i File(s) and message successfully sent.');</script>";
                    }
                    else
                    {
                        echo "<script> alert('Message successfully sent.');</script>"; 
                    }
                }

                if($message_alert_active == '1')
                {
                    $message_alert_laststaff = $this->db->query("SELECT value FROM ost_config_test WHERE id='44'")->row('value');
                    $message_alert_assigned = $this->db->query("SELECT value FROM ost_config_test WHERE id='45'")->row('value');
                    $message_alert_dept_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='46'")->row('value');
                    $message_alert_acct_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id='101'")->row('value');
                    if($message_alert_laststaff == '1')
                    {
                        $thread_ids = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE type ='N' and ticket_guid = '$ticketid';");
                        if($thread_ids->num_rows() > 1)
                        {
                            $thread_id = $this->db->query("SELECT * FROM ost_thread_entry_test WHERE type = 'N' and ticket_guid = '$ticketid' ORDER BY created DESC LIMIT 1,1;");
                            if($thread_id->row('staff_guid') == '0')
                            {
                                $last_res_email = $this->db->query("SELECT user_email FROM ost_user_test WHERE user_guid = '".$thread_id->row('user_guid')."'")->row('user_email');
                            }
                            else
                            {
                                $last_res_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$thread_id->row('staff_guid')."'")->row('email');
                            }
                            if (!in_array($last_res_email, $alluseremail))
                            {
                                array_push($alluseremail, $last_res_email);
                            }
                        }
                    }
                    if($message_alert_assigned == '1')
                    {
                        $ticket = $this->db->query("SELECT * FROM ost_ticket_test a WHERE ticket_guid = '$ticketid'");
                        if($ticket->row('assigned_to') != '' || $ticket->row('team_guid') != '')
                        {
                            if($ticket->row('assigned_to') != '0')
                            {
                                $assigned_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$ticket->row('assigned_to')."'")->row('email');
                                if (!in_array($assigned_email, $alluseremail))
                                {
                                    array_push($alluseremail, $assigned_email);
                                }
                            }
                            else if($ticket->row('team_guid') != '0')
                            {
                                $assigned_emails = $this->db->query("SELECT email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '".$ticket->row('team_guid')."'");
                                foreach($assigned_emails->result() as $value)
                                {
                                    if (!in_array($value->email, $alluseremail))
                                    {
                                        array_push($alluseremail, $value->email);
                                    }
                                }
                            }
                        }
                    }
                    if($message_alert_dept_manager == '1')
                    {
                        $dept_manager_email = $this->db->query("SELECT c.email FROM ost_staff_test c INNER JOIN ost_department_test a ON c.staff_guid=a.`manager_guid` INNER JOIN ost_ticket_test b ON a.name= b.`department` WHERE ticket_guid = '$ticketid'")->row('email');
                        if (!in_array($dept_manager_email, $alluseremail))
                        {
                            array_push($alluseremail, $dept_manager_email);
                        }
                    }
                    if($message_alert_acct_manager == '1')
                    {
                        $acct_manager = $this->db->query("SELECT b.manager FROM ost_user_test a INNER JOIN ost_organization_test b ON b.organization_guid = a.user_org_guid WHERE a.user_email = '".$email->row('user_email')."' ")->row('manager');
                        if($acct_manager != '')
                        {  
                            if ($acct_manager{0} == 'a')
                            {
                                $staff_guid = substr($acct_manager, 1);
                                $acct_manager_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->result();
                            }
                            else if ($acct_manager{0} == 't')
                            {
                                $team_guid = substr($acct_manager, 1);
                                $acct_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid INNER JOIN ost_team_test c ON b.`team_guid` = c.`team_guid` WHERE c.team_guid = '$team_guid' ")->result();
                            }
                            foreach($acct_manager_email as $value)
                            {
                                if (!in_array($value->email, $alluseremail))
                                {
                                    array_push($alluseremail, $value->email);
                                }
                            }   
                        }
                    }
                }
                foreach ($alluseremail as $value)
                    {
                        $this->load->library('email');
                        $username = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username, b.name FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE email = '$value'");
                        $emailinfo = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$ticketid'");
                        $topicinfo = $this->db->query("SELECT * FROM ost_ticket_test b
                        INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                        INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                        WHERE ticket_guid = '$ticketid'");
                        $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                        $login = 'http://[::1]/helpme/index.php/user_controller/login';
                        $data = array(
                            'body' => $this->db->query("SELECT REPLACE(subject, '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%creator%', '$posterfname$posterlname'), '%number%', '".$emailinfo->row('number')."'), '%department%', '".$username->row('name')."'), '%topic%', '".$topicinfo->row('topic')."'), '%subtopic%', '".$topicinfo->row('value')."') AS email
                                FROM ost_email_template_test WHERE code_name = 'message.alert' AND tpl_guid = '$default_template_id'"),
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
            }
            else
            {
                echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
            }
            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
        }
        else
        {
            redirect('user_controller/superlogin');
        }
    }
    public function changeticketstatus()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $check = $this->input->post('tids[]');
            $status = $this->input->post('status_guid');
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
            $posterfname = $this->db->query("SELECT firstname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
            $posterlname = $this->db->query("SELECT lastname FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');
            $assigned_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id = '59'")->row('value');
            $assigned_alert_staff = $this->db->query("SELECT value FROM ost_config_test WHERE id = '60'")->row('value');
            $assigned_alert_team_lead = $this->db->query("SELECT value FROM ost_config_test WHERE id = '61'")->row('value');
            $assigned_alert_team_members = $this->db->query("SELECT value FROM ost_config_test WHERE id = '62'")->row('value');
            $transfer_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id = '51'")->row('value');
            $transfer_alert_assigned = $this->db->query("SELECT value FROM ost_config_test WHERE id = '52'")->row('value');
            $transfer_alert_dept_manager = $this->db->query("SELECT value FROM ost_config_test WHERE id = '53'")->row('value');
            $transfer_alert_dept_members = $this->db->query("SELECT value FROM ost_config_test WHERE id = '54'")->row('value');
            
            foreach ($check as $value)
            {
                $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_guid = '$value'");
                $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
                $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));
                $alluseremail = array();
                if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
                {
                    $primarypermscheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.edit%' AND ticket_guid = '$value'")->num_rows();
                    $permissionscheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.edit%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                    $number = $this->db->query("SELECT number FROM osticket.ost_ticket_test WHERE ticket_guid = '$value'")->row('number');
                    if ($permissionscheck != 0)
                    {
                        if ($status != "" )
                        {
                            if ($status == 3)
                            {
                                $primaryclosecheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.close%' AND ticket_guid = '$value'")->num_rows();
                                $closecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.close%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                                if ($primaryclosecheck != 0) 
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$value'")->row('status_guid');
                                    $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_guid = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_guid = '$value'");
                                    }
                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }
                                else if ($closecheck != 0)
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$value'")->row('status_guid');
                                    $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_guid = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_guid = '$value'");
                                    }
                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }
                                else{
                                    echo "<script> alert('You have no permission for #$number');</script>";
                                }
                            }
                            else
                            {
                                $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$value'")->row('status_guid');
                                $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                                if ($original == '3' && $new == 'open')
                                {
                                    $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_guid = '$value'");
                                }
                                else if ($original != '3' && $new == 'closed')
                                {
                                    $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_guid = '$value'");
                                }
                                echo "<script> alert('#$number Successfully change status');</script>";
                            }
                        }
                    
                        else if ($depart != "" )
                        {
                            $transfer_sla_guid = $this->db->query("SELECT sla_guid FROM `ost_department_test` WHERE name = '$depart' ")->row('sla_guid');
                            if($transfer_alert_active == '1')
                            {
                                if($transfer_alert_assigned == '1')
                                {
                                    $assigned = $this->db->query("SELECT assigned_to, team_guid FROM ost_ticket_test WHERE ticket_guid = $value");
                                    if($assigned->row('assigned_to') != '' && $assigned->row('team_guid') != '')
                                    {
                                        if($assigned->row('assigned_to') != '0')
                                        {
                                            $assigned_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$assigned->row('assigned_to')."'")->row('email');
                                            if (!in_array($assigned_email, $alluseremail))
                                            {
                                                array_push($alluseremail, $assigned_email);
                                            }
                                        }
                                        else
                                        {
                                            $assigned_teamlead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE team_guid = '".$assigned->row('team_guid')."'")->row('email');
                                            if (!in_array($assigned_teamlead_email, $alluseremail))
                                            {
                                                array_push($alluseremail, $assigned_teamlead_email);
                                            }
                                            $assigned_teammem_emails = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE team_guid = '".$assigned->row('team_guid')."'");
                                            foreach($assigned_teammem_emails->result() as $email)
                                            {
                                                if (!in_array($email->email, $alluseremail))
                                                {
                                                    array_push($alluseremail, $email->email);
                                                }
                                            }
                                        }
                                    }
                                }
                                if($transfer_alert_dept_manager == '1')
                                {
                                    $dept_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b ON b.manager_guid = a.staff_guid WHERE b.name = '$depart'")->row('email');
                                    if (!in_array($dept_manager_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $dept_manager_email);
                                    }
                                }
                                if($transfer_alert_dept_members == '1')
                                {
                                    $dept_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b on b.department_guid = a.dept_guid WHERE b.name = '$depart'");
                                    foreach($dept_members_email->result() as $email)
                                    {
                                        if (!in_array($email->email, $alluseremail))
                                        {
                                            array_push($alluseremail, $email->email);
                                        }
                                    }
                                }
                            }
                            $this->db->query("UPDATE ost_ticket_test SET department = '$depart', status_guid = '8', sla_guid = '$transfer_sla_guid', assigned_to = '0', team_guid = '0', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                            echo "<script> alert('#$number Successfully change department');</script>";
                        }
                        else if ($assignto{0} == 'a')
                        {
                            $staff_guid = substr($assignto, 1);
                            $team_guid = '0';
                            $primaryassigncheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_guid = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                            if($assigned_alert_active == '1')
                            {
                                if($assigned_alert_staff == '1')
                                {
                                    $staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('email');
                                    if (!in_array($staff_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $staff_email);
                                    }
                                }
                            }
                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }
                        else if ($assignto{0} == 't')
                        {
                            $team_guid = substr($assignto, 1);
                            $staff_guid = '0';
                            $primaryassigncheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_guid = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                            if($assigned_alert_active == '1')
                            {
                                if($assigned_alert_team_lead == '1')
                                {
                                    $team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$team_guid'")->row('email');
                                    if (!in_array($team_lead_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $team_lead_email);
                                    }
                                }
                                if($assigned_alert_team_members == '1')
                                {
                                    $team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$team_guid'");
                                    foreach($team_members_email->result() as $value2)
                                    {
                                        if (!in_array($value2->email, $alluseremail))
                                        {
                                            array_push($alluseremail, $value2->email);
                                        }
                                    }
                                }
                            }
                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else{
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }
                        else if ($delete == '5')
                        {
                            $primarydeletecheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.delete%' AND ticket_guid = '$value'")->num_rows();
                            $deletecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.delete%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                            if ($primarydeletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_guid = '$value' ");
                                $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE ticket_guid = '$value'");
                                echo "<script> alert('#$number Successfully delete');</script>";
                            }
                            else if ($deletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_guid = '$value' ");
                                $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE ticket_guid = '$value'");
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
                                $this->db->query("INSERT INTO ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar ) VALUES (REPLACE(UPPER(UUID()),'-',''), '$value', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                            }
                        }
                    }
                    else if ($primarypermscheck != 0)
                    {
                        if ($status != "" )
                        {
                            if ($status == 3)
                            {
                                $primaryclosecheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.close%' AND ticket_guid = '$value'")->num_rows();
                                $closecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.close%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                                if ($primaryclosecheck != 0)
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$value'")->row('status_guid');
                                    $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_guid = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_guid = '$value'");
                                    }
                                    echo "<script> alert('#$number Successfully change status');</script>";
                                }
                                else if ($closecheck != 0)
                                {
                                    $original = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$value'")->row('status_guid');
                                    $this->db->query("UPDATE ost_ticket_test SET status_guid = '$status', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                    $new = $this->db->query("SELECT * FROM ost_ticket_status_test WHERE status_guid = '$status'")->row('state');
                                    if ($original == '3' && $new == 'open')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET reopened = now() WHERE ticket_guid = '$value'");
                                    }
                                    else if ($original != '3' && $new == 'closed')
                                    {
                                        $this->db->query("UPDATE ost_ticket_test SET closed = now(), reopened = NULL WHERE ticket_guid = '$value'");
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
                            $this->db->query("UPDATE ost_ticket_test SET department = '$depart', status_guid = '8', assigned_to = '0', team_guid = '0', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                            echo "<script> alert('#$number Successfully change department');</script>";
                            if($transfer_alert_active == '1')
                            {
                                if($transfer_alert_assigned == '1')
                                {
                                    $assigned = $this->db->query("SELECT assigned_to, team_guid FROM ost_ticket_test WHERE ticket_guid = '$value'");
                                    if($assigned->row('assigned_to') != '' && $assigned->row('team_guid') != '')
                                    {
                                        if($assigned->row('assigned_to') != '0')
                                        {
                                            $assigned_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '".$assigned->row('assigned_to')."'")->row('email');
                                            if (!in_array($assigned_email, $alluseremail))
                                            {
                                                array_push($alluseremail, $assigned_email);
                                            }
                                        }
                                        else
                                        {
                                            $assigned_teamlead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE team_guid = '".$assigned->row('team_guid')."'")->row('email');
                                            if (!in_array($assigned_teamlead_email, $alluseremail))
                                            {
                                                array_push($alluseremail, $assigned_teamlead_email);
                                            }
                                            $assigned_teammem_emails = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE team_guid = '".$assigned->row('assigned_to')."'");
                                            foreach($assigned_teammem_emails->result() as $email)
                                            {
                                                if (!in_array($email->email, $alluseremail))
                                                {
                                                    array_push($alluseremail, $email->email);
                                                }
                                            }
                                        }
                                    }
                                }
                                if($transfer_alert_dept_manager == '1')
                                {
                                    $dept_manager_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b ON b.manager_guid = a.staff_guid WHERE b.name = '$depart'")->row('email');
                                    if (!in_array($dept_manager_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $dept_manager_email);
                                    }
                                }
                                if($transfer_alert_dept_members == '1')
                                {
                                    $dept_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_department_test b on b.department_guid = a.dept_guid WHERE b.name = '$depart'");
                                    foreach($dept_members_email->result() as $email)
                                    {
                                        if (!in_array($email->email, $alluseremail))
                                        {
                                            array_push($alluseremail, $email->email);
                                        }
                                    }
                                }
                            }
                        }
                        else if ($assignto{0} == 'a')
                        {
                            $staff_guid = substr($assignto, 1);
                            $team_guid = '0';
                            $primaryassigncheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_guid = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                            if($assigned_alert_active == '1')
                            {
                                if($assigned_alert_staff == '1')
                                {
                                    $staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('email');
                                    if (!in_array($staff_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $staff_email);
                                    }
                                }
                            }
                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }
                        else if ($assignto{0} == 't')
                        {
                            $team_guid = substr($assignto, 1);
                            $staff_guid = '0';
                            $primaryassigncheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.assign%' AND ticket_guid = '$value'")->num_rows();
                            $assgincheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.assign%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                            if($assigned_alert_active == '1')
                            {
                                if($assigned_alert_team_lead == '1')
                                {
                                    $team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$team_guid'")->row('email');
                                    if (!in_array($team_lead_email, $alluseremail))
                                    {
                                        array_push($alluseremail, $team_lead_email);
                                    }
                                }
                                if($assigned_alert_team_members == '1')
                                {
                                    $team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$team_guid'");
                                    foreach($team_members_email->result() as $value2)
                                    {
                                        if (!in_array($value2->email, $alluseremail))
                                        {
                                            array_push($alluseremail, $value2->email);
                                        }
                                    }
                                }
                            }
                            if ($primaryassigncheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else if ($assgincheck != 0)
                            {
                                $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$staff_guid' , team_guid = '$team_guid' , status_guid = '7', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid = '$value' ");
                                echo "<script> alert('#$number Successfully assigned to agent');</script>";
                            }
                            else
                            {
                                echo "<script> alert('You have no permission for #$number');</script>";
                            }
                        }
                        else if ($delete == '5')
                        {
                            $primarydeletecheck = $this->db->query("SELECT a.dept_guid , a.role_guid, b.`permissions` FROM ost_staff_test a INNER JOIN ost_role_test b ON a.`role_guid` = b.role_guid INNER JOIN ost_department_test c ON a.dept_guid = c.`department_guid` INNER JOIN ost_ticket_test d ON C.`name` = d.`department` WHERE staff_guid = '$poster_id' AND b.permissions LIKE '%ticket.delete%' AND ticket_guid = '$value'")->num_rows();
                            $deletecheck = $this->db->query("SELECT * FROM ost_ticket_test a INNER JOIN ost_department_test b ON a.`department` = b.`name` INNER JOIN ost_staff_dept_access_test c ON b.`department_guid` = c.dept_guid INNER JOIN ost_role_test d ON c.`role_guid` = d.`role_guid` WHERE a.ticket_guid = '$value' AND d.permissions LIKE '%ticket.delete%' AND C.`staff_guid` = '$poster_id'")->num_rows();
                            if ($primarydeletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_guid = '$value' ");
                                $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE ticket_guid = '$value'");
                                echo "<script> alert('#$number Successfully delete');</script>";
                            }
                            else if ($deletecheck != 0)
                            {
                                $this->db->query("DELETE FROM ost_ticket_test WHERE ticket_guid = '$value' ");
                                $this->db->query("DELETE FROM osticket.ost_thread_entry_test WHERE ticket_guid = '$value'");
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
                                $this->db->query("INSERT INTO ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar ) VALUES (REPLACE(UPPER(UUID()),'-',''), '$value', '$poster_id', 'N','$posterfname $posterlname', '$note', '$ipaddress', now(), now(), 'note', 'left')");
                            }
                        }
                    }
                    else
                    {
                        echo "<script> alert('You have no permission for #$number');</script>";
                    }
                    foreach ($alluseremail as $value1)
                    {
                        $this->load->library('email');
                        $username = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username, b.name FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE email = '$value1'");
                        $poster = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username FROM ost_staff_test a WHERE staff_guid = '$poster_id'")->row('username');
                        $emailinfo = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$value'");
                        $topicinfo = $this->db->query("SELECT * FROM ost_ticket_test b
                        INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                        INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                        WHERE ticket_guid = '$value'");
                        
                        $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');
                        if($depart != '')
                        {
                            $data = array(
                                'body' => $this->db->query("SELECT REPLACE(REPLACE(subject, '%number%', '".$emailinfo->row('number')."'), '%department%', '".$depart."') AS email_subject, 
                                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%assigner%', '$poster'), '%number%', '".$emailinfo->row('number')."'), '%department%', '".$depart."'), '%comment%', '".$notearr['transfernote']."') AS email
                                    FROM ost_email_template_test WHERE code_name = 'transfer.alert' AND tpl_guid = '$default_template_id'"),
                                'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                                    INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                                    WHERE staff_guid = '$poster_id'"),
                                'template' => $this->db->query("SELECT * FROM ost_company_test"),
                            );
                        }
                        else
                        {
                            $data = array(
                                'body' => $this->db->query("SELECT REPLACE(subject, '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%assigner%', '$poster'), '%number%', '".$emailinfo->row('number')."'), '%topic%', '".$topicinfo->row('topic')."'), '%department%', '".$username->row('name')."'), '%subtopic%', '".$topicinfo->row('value')."') AS email
                                    FROM ost_email_template_test WHERE code_name = 'assigned.alert' AND tpl_guid = '$default_template_id'"),
                                'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                                    INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                                    WHERE staff_guid = '$poster_id'"),
                                'template' => $this->db->query("SELECT * FROM ost_company_test"),
                            );
                        }
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
                        $this->email->to($value1);
                        $this->email->subject($data['body']->row('email_subject'));
                        $this->email->message($bodyContent);
                        $this->email->send();
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
           redirect('user_controller/superlogin');
        }
    }
    public function ticketinfo_assignuser()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $ticket_guid = $_REQUEST['tid'];
            $user_guid = $_REQUEST['id'];
            $poster_id = $_SESSION['staffid'];
            $count_user_tickets = $this->db->query("SELECT COUNT(*) AS count FROM ost_ticket_test a INNER JOIN ost_ticket_status_test b ON a.status_guid = b.status_guid WHERE a.user_guid = '$user_guid' AND b.state = 'open'")->row('count');
            $max_open_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '22'")->row('value');
            $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_guid = '$ticket_guid'");
            $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
            $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));
            if ($count_user_tickets < $max_open_tickets || empty($max_open_tickets))
            {
                if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
                {
                    $this->db->query("UPDATE ost_ticket_test SET user_guid = '$user_guid', ticket_updated = NOW(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_guid='$ticket_guid' ");
                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    $posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('firstname');
                    $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = $poster_id")->row('lastname');
                    $user_name = $this->db->query("SELECT * FROM ost_user_test WHERE user_guid = $user_guid")->row('user_name');
                    $description = '<b>'.$posterfname.''.$posterlname.'</b> change owenership of this ticket to <strong>'.$user_name.'</strong>' ;
                    $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , staff_guid , type, poster , body , ip_address, created, updated, class, avatar )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticket_guid' ,'$poster_id', 'E' ,'$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'pencil', 'left')");
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
            echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticket_guid' </script>";
        }
        else       
        {
           redirect('user_controller/superlogin');
        }
    }
    //ajax search user assign ticket
    public function fetch_user()
    {
        $ticket_guid = $_REQUEST['id'];
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
              <div style="background-color: lightyellow;border-style:groove;border-radius: 10px;text-align:center;">
            ';
            if ($direct == 'new')
            {
                foreach($data->result() as $nrow)
                {
                    $output .= '
                    <div style="border-bottom: 1px groove;">
                        <b><a href ="ticketinfo_assignuser?id='.$nrow->user_guid.'&tid='.$ticket_guid.'">
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
                    <div style="border-bottom: 1px groove;">
                        <b><a href ="ticketinfoedit?id='.$ticket_guid.'&uid='.$trow->user_guid.'">
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
                <div style="border-style:groove;border-width:1px;border-radius: 10px;">
                    <b>No Data
                    </a></b><br>
                </div>
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
                <div style="background-color: lightyellow;border-style:groove;border-radius: 10px;text-align:center;">
            ';
            foreach($data->result() as $row)
            {
                $output .= '
                <div style="border-bottom: 1px groove;">
                    <b><a href ="newticket?id='.$row->user_guid.'">
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
            $output .= '<div style="background-color: lightyellow;text-align:center;">
                <div style="border-style:groove;border-width:1px;border-radius: 10px;">
                    <b>No Data
                    </a></b><br>
                </div></div>';
        }
      
        echo $output;
    }
    public function selected_tickets_ajax()
    {
            
            $ticket_guid_string= $_REQUEST['ticket_guid_string'];
            $i = 0;
            $checked_array = explode(',', $ticket_guid_string);
            foreach ($checked_array as $value ) {
                $data[$i] = $this->db->query("SELECT number from osticket.ost_ticket_test WHERE ticket_guid = '$value' GROUP BY number ASC")->row('number');
                $i++;
            }
            echo json_encode($data);
            
            
            
        
            /*$data = $this->db->query("SELECT a.period_code FROM `supplier_monthly_doc_count` a LEFT JOIN `supplier_monthly_main` b ON a.period_code = b.`period_code` WHERE a.customer_guid = '$customerid' AND a.supplier_guid = '$supplierid' AND invoice_number IS NULL;")->result();*/
   
    }
}
?>