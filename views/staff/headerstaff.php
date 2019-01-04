<html lang="en-US"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-pjax-version" content="9ae093d">
    <title>Panda Staff Control Panel</title>
    <link rel="icon" type="image/png" href="/helpdesk/assets/default/images/logo.png">
    <link rel="apple-touch-icon" href="/helpdesk/assets/default/images/logo.png">
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="/helpdesk/js/jquery-1.11.2.min.js?9ae093d"></script>
    <link type="text/css" rel="stylesheet" href="/helpdesk/assets/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/helpdesk/css/thread.css?9ae093d" media="all">
    <link rel="stylesheet" href="/helpdesk/scp/css/scp.css?9ae093d" media="all">
    <link rel="stylesheet" href="/helpdesk/css/redactor.css?9ae093d" media="screen">
    <link rel="stylesheet" href="/helpdesk/scp/css/typeahead.css?9ae093d" media="screen">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="/adminlte/plugins/timepicker/bootstrap-timepicker.min.css"> 
    <link type="text/css" href="/helpdesk/css/ui-lightness/jquery-ui-1.10.3.custom.min.css?9ae093d" rel="stylesheet" media="screen">
     <link type="text/css" rel="stylesheet" href="/helpdesk/css/font-awesome.min.css?9ae093d">
    <!--[if IE 7]>
    <link rel="stylesheet" href="/helpdesk/css/font-awesome-ie7.min.css?9ae093d"/>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/dropdown.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/loadingbar.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/flags.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/select2.min.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/rtl.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/translatable.css?9ae093d">
    <script type="text/javascript" src="/helpdesk/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- export data table -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>


<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    
    <meta name="csrf_token" content="25d9753bd6e94b1089bdde8be8c3cd9c37954141">
    <script type="text/javascript" src="js/ticket.js?9ae093d"></script>
    <script type="text/javascript" src="js/thread.js?9ae093d"></script>
    <meta name="tip-namespace" content="tickets.queue">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
<style type="text/css">
  
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

</style>

</head>
<body style="overflow: auto;">
<div id="container" class="container">
        <div id="header">
        <div class="log-lg-8">
            <p id="info" class="pull-right no-pjax">Welcome, <strong><?php echo $_SESSION["username"] ?></strong>.                               | <a href="/helpdesk/scp/admin.php" class="no-pjax">Admin Panel</a>
                                | <a href="<?php echo site_url('staff_dashboard_controller/profile')?>">Profile</a>
                | <a href="<?php echo site_url('logout_c/stafflogout')?>" class="no-pjax">Log Out</a>
            </p>
        </div>
        <div class="log-lg-4" style="height: max-content;">
            <a href="<?php echo site_url('staff_ticket_controller/main?title=Open')?>" class="no-pjax" id="logo" style="display: table;">
                <span class="valign-helper"></span>
                <img src="/helpdesk/scp/logo.php?1524307549" alt="osTicket — Customer Support System">
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
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li class="inactive no-pjax dropdown"><a href="#" helpdesk="" scp="" dashboard.php="" class="dropdown-toggle" data-toggle="dropdown">Dashboard <span class="caret"></span></a><ul class="dropdown-menu">
<li><a class="logs" href="<?php echo site_url('staff_dashboard_controller/dashboard')?>" title="" id="nav0">Dashboard</a></li><li><a class="teams" href="<?php echo site_url('staff_dashboard_controller/agent')?>" title="" id="nav1">Agent Directory</a></li><li><a class="users" href="<?php echo site_url('staff_dashboard_controller/profile')?>" title="" id="nav2">My Profile</a></li>
</ul>

</li>
<li class="inactive  dropdown"><a href="#" helpdesk="" scp="" users.php="" class="dropdown-toggle" data-toggle="dropdown">Users <span class="caret"></span></a><ul class="dropdown-menu">
<li><a class="teams" href="<?php echo site_url('staff_user_controller/main')?>" title="" id="nav0">User Directory</a></li><li><a class="departments" href="<?php echo site_url('staff_user_controller/organization')?>" title="" id="nav1">Organizations</a></li>
</ul>

</li>
<li class="inactive  dropdown"><a href="#" helpdesk="" scp="" tasks.php="" class="dropdown-toggle" data-toggle="dropdown">Tasks <span class="caret"></span></a><ul class="dropdown-menu">
<li><a class="Ticket" href="<?php echo site_url('staff_task_controller/main')?>" title="" id="nav0">Tasks</a></li>

<li><a class="newTicket new-task" href="#tasks/add" title="Open a New Task" id="new-task" data-dialog-config="{&quot;size&quot;:&quot;large&quot;}">New Task</a></li>

</ul>

</li>

<li class="inactive  dropdown"><a href="#" helpdesk="" scp="" tickets.php="" class="dropdown-toggle" data-toggle="dropdown">Tickets <span class="caret"></span></a>

<ul class="dropdown-menu">

<?php $userid = $_SESSION["staffid"];?>

<li><a class="Ticket active" href="<?php echo site_url('staff_ticket_controller/main?title=Open')?>" title="Open Tickets" id="subnav2">Open (<?php echo $this->db->query("SELECT * FROM  ost_ticket_test AS a INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id WHERE c.state = 'open'")->num_rows();?>)</a></li>
<li><a class="assignedTickets active" href="<?php echo site_url('staff_ticket_controller/mytickets?title=My')?>" title="Assigned Tickets" id="subnav4">My Tickets (<?php echo $this->db->query("SELECT * FROM  ost_ticket_test AS a INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id WHERE assigned_to = '$userid'")->num_rows();?>)</a></li>
<li><a class="overdueTickets" href="<?php echo site_url('staff_ticket_controller/overdue?title=Overdue')?>" title="Stale Tickets" id="subnav3">Overdue (<?php echo $this->db->query("SELECT * FROM  ost_ticket_test AS a INNER JOIN ost_help_topic_test AS b  ON b.topic_id = a.topic_id INNER JOIN ost_ticket_status_test AS c  ON c.id = a.status_id INNER JOIN ost_user_test AS d  ON a.user_id = d.user_id INNER JOIN ost_ticket_priority_test AS e  ON e.priority_id = a.priority_id WHERE duedate <= now()")->num_rows();?>)</a></li>
<li><a class="closedTickets" href="<?php echo site_url('staff_ticket_controller/closed?title=Closed')?>" title="Closed Tickets" id="subnav4">Closed</a></li>
<li><a class="newTicket" href="<?php echo site_url('staff_ticket_controller/newticket?title=New')?>" title="Open a New Ticket" id="new-ticket">New Ticket</a></li>

</ul>

</li>
<li class="inactive  dropdown"><a href="#" helpdesk="" scp="" kb.php="" class="dropdown-toggle" data-toggle="dropdown">Knowledgebase <span class="caret"></span></a><ul class="dropdown-menu">
<li><a class="kb" href="<?php echo site_url('staff_faqs_controller/main')?>" title="" id="nav0">FAQs</a></li><li><a class="faq-categories" href="/helpdesk/scp/categories.php" title="" id="nav1">Categories</a></li><li><a class="canned" href="/helpdesk/scp/canned.php" title="" id="nav2">Canned Responses</a></li>
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