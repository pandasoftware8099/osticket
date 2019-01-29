<html lang="en-US"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-pjax-version" content="9ae093d">
    <title>Panda Staff Control Panel</title>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/default/images/logo.png');?>" >
    
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.2.min.js?9ae093d');?>"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/bootstrap/dist/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('css/thread.css?9ae093dd');?>" media="screen">
    <link rel="stylesheet" href="<?php echo base_url('css/redactor.css?9ae093d');?>" media="screen">
    <link rel="stylesheet" href="<?php echo base_url('scp/css/scp.css?9ae093d');?>" media="all">
    <link rel="stylesheet" href="<?php echo base_url('scp/css/typeahead.css?9ae093d');?>" media="screen">  
    <!-- bootstrap datepicker -->
    <!-- <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="/adminlte/plugins/timepicker/bootstrap-timepicker.min.css"> -->
    <link type="text/css" href="<?php echo base_url('css/ui-lightness/jquery-ui-1.10.3.custom.min.css?9ae093d');?>" rel="stylesheet" media="screen">
     <link rel="stylesheet" href="<?php echo base_url('css/font-awesome.min.css?9ae093d');?>" media="screen">
    <!--[if IE 7]>
    <link rel="stylesheet" href="/helpdesk/css/font-awesome-ie7.min.css?9ae093d"/>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('scp/css/dropdown.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/loadingbar.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/flags.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/rtl.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/select2.min.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('scp/css/translatable.css?9ae093d');?>">
    <!-- export data table -->
    <script src="<?php echo base_url('bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    
    <!-- export data table -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('asset/plugins/bower_components/datetime/bootstrap-datetimepicker.js');?>"></script>
    <script src="<?php echo base_url('asset/plugins/bower_components/datetime/bootstrap-datetimepicker.min.js');?>"></script>


    <meta name="tip-namespace" content="tickets.queue">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
  <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bower_components/datetime/bootstrap-datetimepicker.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bower_components/datetime/bootstrap-datetimepicker.min.css');?>">



<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

<script type="text/javascript">
    
$(document).ready(function() {
  $('.textarea').summernote({

    minHeight: 200

  });
});

</script>

<style type="text/css">

.panel {
    margin-bottom: 0px;
}
  
[class^="icon-"], [class*=" icon-"] {

    line-height: unset;

}

.table tr.header td, .table tr.header th, .table > thead th {
    font-size: 14px;
    font-weight: bold;
}

table.dataTable td, table.dataTable th {

    font-size: 14px;
}

table.dataTable {
    width: 100%;
}


.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {

    font-size: 14px;
}

table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {

    bottom: 4px;

}

.row {
    display: unset;
}

button.dt-button, div.dt-button, a.dt-button {

    padding: 1px 6px;

}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin-bottom: 0px;
    margin-top: -25px;
}

.bootstrap-timepicker {

    display: inline-block;
    top: 9px;
}

.action-dropdown {

  z-index: 1000;

}

.col-sm-6 , .col-lg-12 {
    
    padding-right: unset; 
    padding-left: unset; 
}

.note-editor > .modal > .modal-dialog > .modal-content > .modal-body > .note-group-select-from-files
{

display: none;

}
</style>

</head>
<body style="overflow: auto;">
    <?php
        $admin = $this->db->query("SELECT isadmin FROM ost_staff_test WHERE staff_guid = '".$_SESSION['staffid']."'");
        $data = array(
            'offline' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '12'"),
        );
        
        if ($data['offline']->row('value') == '0' && $admin->row('isadmin') == '0')
        {   
            redirect("user_controller/superlogin", $data);
        }

        $time = $_SERVER['REQUEST_TIME'];
        $timeout = $this->db->query("SELECT value FROM ost_config_test WHERE id = '16'")->row('value');

        if($timeout <> 0)
        {
            $timeout_duration = $timeout*60;
            if (isset($_SESSION['LAST_ACTIVITY']) && 
               ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
                session_unset();
                session_destroy();
                session_start();
                echo "<script> alert('You have been IDLE for too long, please log in to continue.');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/user_controller/superlogin' </script>";
            }
            else
            {
                $_SESSION['LAST_ACTIVITY'] = $time;
            }
        }
    ;?>
    
<div id="container" class="container">

    <?php $logostaff = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' AND default_staff = '1'");?>

        <div id="header">
        <div class="log-lg-8">
            <p id="info" class="pull-right no-pjax">Welcome, <strong><?php echo $_SESSION["staffname"] ?></strong>. 
                                          | 
                <?php 

                $staffname = $_SESSION['staffname'];

                $staffpass = $_SESSION['staffpass'];

                $isadmin = $this->db->query("SELECT isadmin FROM osticket.ost_staff_test WHERE username = '$staffname' AND passwd = '$staffpass'")->row('isadmin');

                if ($isadmin == 1 ) { ?>
                <a href="<?php echo site_url('admin_settings_controller/main')?>" class="no-pjax">Admin Panel</a>

                <?php } else  { ?>

                <a href="<?php echo site_url('staff_ticket_controller/main?title=Open&direct=open')?>" class="no-pjax">Agent Panel</a>

                <?php } ?>

                | <a href="<?php echo site_url('staff_dashboard_controller/profile')?>">Profile</a>
                | <a href="<?php echo site_url('logout_c/stafflogout')?>" class="no-pjax">Log Out</a>
            </p>
        </div>
        <div class="log-lg-4" style="height: max-content;">
            <a href="<?php echo site_url('staff_ticket_controller/main?title=Open&direct=open')?>" class="no-pjax" id="logo" style="display: table;">
                <span class="valign-helper"></span>
                <img src="/helpme/uploads/<?php echo $logostaff->row('name');?>" alt="osTicket — Customer Support System">
            </a>
        </div>
    </div>
    <div id="pjax-container" class="">    <script type="text/javascript">
    $('#content').data('tipNamespace', 'tickets.queue');;    </script>
        <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>

    <?php 

    if ($this->uri->segment(1) == 'staff_dashboard_controller')

    {

        $dashboard = 'active';
        $user = 'inactive';
        $tasks = 'inactive';
        $tickets = 'inactive';
        $knowledgebase = 'inactive';

    }

    else if ($this->uri->segment(1) == 'staff_user_controller')

    {

        $dashboard = 'inactive';
        $user = 'active';
        $tasks = 'inactive';
        $tickets = 'inactive';
        $knowledgebase = 'inactive';

    }

    else if ($this->uri->segment(1) == 'staff_task_controller')

    {

        $dashboard = 'inactive';
        $user = 'inactive';
        $tasks = 'active';
        $tickets = 'inactive';
        $knowledgebase = 'inactive';

    }

    else if ($this->uri->segment(1) == 'staff_ticket_controller')

    {

        $dashboard = 'inactive';
        $user = 'inactive';
        $tasks = 'inactive';
        $tickets = 'active';
        $knowledgebase = 'inactive';

    }

    else if ($this->uri->segment(1) == 'staff_faqs_controller')

    {

        $dashboard = 'inactive';
        $user = 'inactive';
        $tasks = 'inactive';
        $tickets = 'inactive';
        $knowledgebase = 'active';

    }

    ?>

    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li class="<?php echo $dashboard ?> no-pjax dropdown">
                <a href="#" helpdesk="" scp="" dashboard.php="" class="dropdown-toggle" data-toggle="dropdown">Dashboard <span class="caret"></span>
                </a>
            <ul class="dropdown-menu">
                <li><a class="logs" href="<?php echo site_url('staff_dashboard_controller/dashboard')?>" title="" id="nav0">Dashboard</a></li>
                <li><a class="teams" href="<?php echo site_url('staff_dashboard_controller/agent')?>" title="" id="nav1">Agent Directory</a></li>
                <li><a class="users" href="<?php echo site_url('staff_dashboard_controller/profile')?>" title="" id="nav2">My Profile</a></li>
            </ul>

            </li>

            <?php 

            $staffid = $_SESSION["staffid"];
            $userdirallow = $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%user.dir%'")->num_rows() ;

            if ($userdirallow != 0 ) { 
            ?> 

            <li class="<?php echo $user ?> dropdown"><a href="#" helpdesk="" scp="" users.php="" class="dropdown-toggle" data-toggle="dropdown">Users <span class="caret"></span></a>

            <ul class="dropdown-menu">
            
                <li><a class="teams" href="<?php echo site_url('staff_user_controller/main')?>" title="" id="nav0">User Directory</a></li>
                <li><a class="departments" href="<?php echo site_url('staff_user_controller/organization')?>" title="" id="nav1">Organizations</a></li>

            </ul>

            </li>

            <?php } ?> 


            <li class="<?php echo $tasks ?> dropdown"><a href="#" helpdesk="" scp="" tasks.php="" class="dropdown-toggle" data-toggle="dropdown">Tasks <span class="caret"></span></a>

            <ul class="dropdown-menu">

                <li><a class="Ticket" href="<?php echo site_url('staff_task_controller/main?title=Open')?>" title="" id="nav0">Open</a></li>
                <li><a class="closedTickets" href="<?php echo site_url('staff_task_controller/close?title=Closed')?>" title="" id="nav0">Completed</a></li>

            </ul>

            </li>

            <li class="<?php echo $tickets ?> dropdown"><a href="#" helpdesk="" scp="" tickets.php="" class="dropdown-toggle" data-toggle="dropdown">Tickets <span class="caret"></span></a>

            <ul class="dropdown-menu">


                <li><a class="Ticket active" href="<?php echo site_url('staff_ticket_controller/main?title=Open&direct=open')?>" title="Open Tickets" id="subnav2">Open (<?php
                    $userdeptid = $_SESSION['staffdept'];
                    $staff_guid = $_SESSION["staffid"];  
                    $userdeptname = $this->db->query("SELECT name FROM ost_department_test WHERE department_guid = '$userdeptid' ")->row('name');
                    $show_assigned_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '65'")->row('value');
                    $show_answered_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '66'")->row('value');

                    echo $this->db->query("SELECT COUNT(*) AS count FROM  ost_ticket_test AS a  
                        INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                        INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                        INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                        INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid
                        WHERE c.state = 'open'
                        AND department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid')
                        AND (($show_assigned_tickets = '1' AND NOT ((a.assigned_to IS NOT NULL AND a.assigned_to != '0') OR (a.team_guid IS NOT NULL AND a.team_guid != '0'))) OR ($show_assigned_tickets = '0'))
                        AND (($show_answered_tickets = '1' AND a.ticket_guid NOT IN (SELECT ticket_guid FROM ost_thread_entry_test AS f WHERE f.type = 'S' AND a.created_at != f.created)) OR ($show_answered_tickets = '0'))")->row('count');?>)</a></li>
                <?php 
                $show_answered_tickets = $this->db->query("SELECT value FROM ost_config_test WHERE id = '66'");
                if ($show_answered_tickets->row('value') == '1') { ?>
                <li><a class="answeredTickets active" href="<?php echo site_url('staff_ticket_controller/main?title=Answered&direct=answered')?>" title="Answered Tickets" id="subnav4">Answered (<?php echo $this->db->query("SELECT * FROM ost_ticket_test AS a  
                                    INNER JOIN ost_help_topic_test AS b ON b.topic_guid = a.topic_guid 
                                    INNER JOIN ost_ticket_status_test AS c ON c.status_guid = a.status_guid 
                                    INNER JOIN ost_user_test AS d ON a.user_guid = d.user_guid 
                                    INNER JOIN ost_ticket_priority_test AS e ON e.priority_guid = a.priority_guid
                                    INNER JOIN ost_thread_entry_test AS f ON a.ticket_guid = f.ticket_guid
                                    WHERE f.type = 'S' AND a.created_at != f.created AND a.department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid') GROUP BY a.ticket_guid")->num_rows();?>)</a></li>
                <?php } ?>
                <li><a class="assignedTickets active" href="<?php echo site_url('staff_ticket_controller/mytickets?title=My')?>" title="Assigned Tickets" id="subnav4">My Tickets (<?php echo $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                    INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid 
                    WHERE c.state = 'open' AND a.assigned_to = '$staff_guid' OR a.team_guid IN (SELECT team_guid FROM ost_team_member_test WHERE staff_guid = '$staff_guid')")->num_rows();?>)</a></li>
                <li><a class="overdueTickets" href="<?php echo site_url('staff_ticket_controller/overdue?title=Overdue')?>" title="Stale Tickets" id="subnav3">Overdue (<?php echo $this->db->query("SELECT * FROM  ost_ticket_test AS a  
                                    INNER JOIN ost_help_topic_test AS b  ON b.topic_guid = a.topic_guid 
                                    INNER JOIN ost_ticket_status_test AS c  ON c.status_guid = a.status_guid 
                                    INNER JOIN ost_user_test AS d  ON a.user_guid = d.user_guid 
                                    INNER JOIN ost_ticket_priority_test AS e  ON e.priority_guid = a.priority_guid 
                                    WHERE c.state = 'open' AND duedate <= now() AND a.department IN (SELECT NAME FROM ost_department_test a INNER JOIN ost_staff_dept_access_test b ON a.department_guid = b.`dept_guid` WHERE B.`staff_guid` = '$staff_guid' UNION SELECT NAME FROM ost_department_test WHERE department_guid = '$userdeptid')")->num_rows();?>)</a></li>
                <li><a class="closedTickets" href="<?php echo site_url('staff_ticket_controller/closed?title=Closed')?>" title="Closed Tickets" id="subnav4">Closed</a></li>
                <li><a class="newTicket" href="<?php echo site_url('staff_ticket_controller/newticket?id=')?>" title="Open a New Ticket" id="new-ticket">New Ticket</a></li>

            </ul>

            </li>


            <li class="<?php echo $knowledgebase ?>  dropdown"><a href="#" helpdesk="" scp="" kb.php="" class="dropdown-toggle" data-toggle="dropdown">Knowledgebase <span class="caret"></span></a>

            <ul class="dropdown-menu">
                <li><a class="kb" href="<?php echo site_url('staff_faqs_controller/main')?>" title="" id="nav0">FAQs</a></li>

                <?php $faqallow = $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%faq.manage%'")->num_rows();

                    if ($faqallow != 0 ) {
                ?>

                <li><a class="faq-categories" href="<?php echo site_url('staff_faqs_controller/categories')?>" title="" id="nav1">Categories</a></li>

                <?php } ?>

                <li><a class="canned" href="<?php echo site_url('staff_faqs_controller/canned_response')?>" title="" id="nav2">Canned Responses</a></li>
            </ul>

            </li>
        </ul>
    </div>
  </div>
</nav>
   <!-- <ul id="nav">
<li class="inactive no-pjax dropdown"><a href="#" /helpdesk/scp/dashboard.php class="dropdown-toggle" data-toggle="dropdown">Dashboard <span class="caret"></span></a><ul class='dropdown-menu'>
<li><a class="logs" href="/helpdesk/scp/dashboard.php" title="" id="nav0">Dashboard</a></li><li><a class="teams" href="/helpdesk/scp/directory.php" title="" id="nav1">Agent Directory</a></li><li><a class="users" href="/helpdesk/scp/profile.php" title="" id="nav2">My Profile</a></li>
</ul>

</li>
<li class="inactive  dropdown"><a href="#" /helpdesk/scp/users.php class="dropdown-toggle" data-toggle="dropdown">Users <span class="caret"></span></a><ul class='dropdown-menu'>
<li><a class="teams" href="/helpdesk/scp/users.php" title="" id="nav0">User Directory</a></li><li><a class="departments" href="/helpdesk/scp/orgs.php" title="" id="nav1">Organizations</a></li>
</ul>

</li>
<li class="inactive  dropdown"><a href="#" /helpdesk/scp/tasks.php class="dropdown-toggle" data-toggle="dropdown">Tasks <span class="caret"></span></a><ul class='dropdown-menu'>
<li><a class="Ticket" href="/helpdesk/scp/tasks.php" title="" id="nav0">Tasks</a></li>
</ul>

</li>
<li class="active  dropdown"><a href="#" /helpdesk/scp/tickets.php class="dropdown-toggle" data-toggle="dropdown">Tickets <span class="caret"></span></a><ul class='dropdown-menu'>
<li><a class="Ticket active" href="tickets.php?status=open" title="Open Tickets" id="subnav2" >Open (5)</a></li><li><a class="overdueTickets" href="tickets.php?status=overdue" title="Stale Tickets" id="subnav3" >Overdue (3)</a></li><li><a class="closedTickets" href="tickets.php?status=closed" title="Closed Tickets" id="subnav4" >Closed</a></li><li><a class="newTicket" href="tickets.php?a=open" title="Open a New Ticket" id="new-ticket" >New Ticket</a></li>
</ul>

</li>
<li class="inactive  dropdown"><a href="#" /helpdesk/scp/kb.php class="dropdown-toggle" data-toggle="dropdown">Knowledgebase <span class="caret"></span></a><ul class='dropdown-menu'>
<li><a class="kb" href="/helpdesk/scp/kb.php" title="" id="nav0">FAQs</a></li><li><a class="faq-categories" href="/helpdesk/scp/categories.php" title="" id="nav1">Categories</a></li><li><a class="canned" href="/helpdesk/scp/canned.php" title="" id="nav2">Canned Responses</a></li>
</ul>

</li>
    </ul>
    <ul id="sub_nav">
<li><a class="Ticket active" href="tickets.php?status=open" title="Open Tickets" id="subnav2" >Open (5)</a></li><li><a class="overdueTickets" href="tickets.php?status=overdue" title="Stale Tickets" id="subnav3" >Overdue (3)</a></li><li><a class="closedTickets" href="tickets.php?status=closed" title="Closed Tickets" id="subnav4" >Closed</a></li><li><a class="newTicket" href="tickets.php?a=open" title="Open a New Ticket" id="new-ticket" >New Ticket</a></li>    </ul> -->