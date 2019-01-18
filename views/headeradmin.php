<html lang="en-US"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-pjax-version" content="9ae093d">
    <title>Panda Admin Control Panel</title>
    <link rel="icon" type="image/png" href="/helpdesk/assets/default/images/logo.png">
    <link rel="apple-touch-icon" href="/helpdesk/assets/default/images/logo.png">
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="/helpdesk/assets/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/helpdesk/css/thread.css?9ae093d" media="all">
    <link rel="stylesheet" href="/helpdesk/scp/css/scp.css?9ae093d" media="all">
    <link rel="stylesheet" href="/helpdesk/css/redactor.css?9ae093d" media="screen">
    <link rel="stylesheet" href="/helpdesk/scp/css/typeahead.css?9ae093d" media="screen">
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

    <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
    
	<!-- export data table -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="/helpdesk/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- export data table -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">



 <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">


<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

<script type="text/javascript">
    
$(document).ready(function() {
  $('.textarea').summernote();
});

</script>

<style type="text/css">
    
[class^="icon-"], [class*=" icon-"] {

    line-height: unset;

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

.action-dropdown {

    z-index: 1;
}

.no-spin::-webkit-inner-spin-button, .no-spin::-webkit-outer-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important;
    -moz-appearance:textfield !important;
}

</style>

</head>
<body>

    <?php
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
    ?>
<div id="container" class="container">

    <?php $logostaff = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' AND default_staff = '1'");?>

        <div id="header">
        <div class="log-lg-8">
            <p id="info" class="pull-right no-pjax">Welcome, <strong><?php echo $_SESSION["staffname"] ?></strong>.
                | <a href="<?php echo site_url('staff_ticket_controller/main?title=Open&direct=open')?>" class="no-pjax">Agent Panel</a>
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
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li class="inactive  dropdown"><a href="#" helpdesk="" scp="" logs.php="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dashboard <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a class="logs" href="/helpdesk/scp/logs.php" title="" id="nav0">System Logs</a></li>
                <li><a class="preferences" href="<?php echo site_url('admin_dashboard_controller/agents_dashboard')?>" title="" id="nav1">Information</a></li>
            </ul>
            </li>

            <li class="inactive  dropdown"><a href="#" helpdesk="" scp="" settings.php="" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a class="pages" href="<?php echo site_url('admin_settings_controller/settings_company')?>" title="" id="subnav0">Company</a></li>
                <li><a class="preferences active" href="<?php echo site_url('admin_settings_controller/main')?>" title="" id="subnav1">System</a></li>
                <li><a class="ticket-settings" href="<?php echo site_url('admin_settings_controller/settings_ticket')?>">Tickets</a></li>
                <li><a class="lists" href="<?php echo site_url('admin_settings_controller/settings_task')?>" title="" id="subnav3">Tasks</a></li>
                <li><a class="teams" href="<?php echo site_url('admin_settings_controller/settings_agent')?>" title="" id="subnav4">Agents</a></li>
                <li><a class="groups" href="<?php echo site_url('admin_settings_controller/settings_user')?>" title="" id="subnav5">Users</a></li>
                <li><a class="kb-settings" href="<?php echo site_url('admin_settings_controller/settings_knowledgebase')?>" title="" id="subnav6">Knowledgebase</a></li>
            </ul>
            </li>

            <li class="inactive  dropdown"><a href="#" helpdesk="" scp="" helptopics.php="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Manage <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a class="helpTopics" href="<?php echo site_url('admin_manage_controller/manage_helptopics')?>" title="" id="nav0">Help Topics</a></li>
                <li><a class="lists" href="<?php echo site_url('admin_manage_controller/manage_subtopics')?>" title="" id="nav6">Subtopics</a></li>
                <li><a class="sla" href="<?php echo site_url('admin_manage_controller/manage_sla')?>" title="" id="nav2">SLA Plans</a></li>
                <li><a class="api" href="<?php echo site_url('admin_manage_controller/manage_api')?>" title="" id="nav3">API Keys</a></li>
                <li><a class="pages" href="<?php echo site_url('admin_manage_controller/manage_pages')?>" title="Pages" id="nav4">Pages</a></li>
                <!-- <li><a class="ticketFilters" href="/helpdesk/scp/filters.php" title="Ticket Filters" id="nav1">Ticket Filters</a></li>
                <li><a class="forms" href="/helpdesk/scp/forms.php" title="" id="nav5">Forms</a></li>
                <li><a class="api" href="/helpdesk/scp/plugins.php" title="" id="nav7">Plugins</a></li> -->
            </ul>
            </li>

            <li class="inactive  dropdown"><a href="#" helpdesk="" scp="" emails.php="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Emails <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a class="emailSettings" href="<?php echo site_url('admin_emails_controller/emails_emails')?>" title="Email Addresses" id="nav0">Emails</a></li>
                <li><a class="email-settings" href="<?php echo site_url('admin_emails_controller/emails_settings')?>" title="" id="nav1">Settings</a></li>
                <li><a class="emailDiagnostic" href="<?php echo site_url('admin_emails_controller/emails_banlist')?>" title="Banned Emails" id="nav2">Banlist</a></li>
                <li><a class="emailTemplates" href="<?php echo site_url('admin_emails_controller/emails_templates')?>" title="Email Templates" id="nav3">Templates</a></li>
                <li><a class="emailDiagnostic" href="<?php echo site_url('admin_emails_controller/emails_diagnostic')?>" title="Email Diagnostic" id="nav4">Diagnostic</a></li>
            </ul>
            </li>

            <li class="inactive  dropdown"><a href="#" helpdesk="" scp="" staff.php="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Agents <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a class="users" href="<?php echo site_url('admin_agents_controller/agents_agents')?>" title="" id="nav0">Agents</a></li>
                <li><a class="teams" href="<?php echo site_url('admin_agents_controller/agents_teams')?>" title="" id="nav1">Teams</a></li>
                <li><a class="lists" href="<?php echo site_url('admin_agents_controller/agents_roles')?>" title="" id="nav2">Roles</a></li>
                <li><a class="departments" href="<?php echo site_url('admin_agents_controller/agents_departments')?>" title="" id="nav3">Departments</a></li>
            </ul>
            </li>
        </ul>
    </div>
  </div>
</nav>
 