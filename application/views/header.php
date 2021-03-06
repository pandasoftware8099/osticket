<html lang="en_US"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $this->db->query("SELECT * FROM ost_config_test WHERE id ='3'")->row('value') ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?php echo base_url('assets/default/images/logo.png');?>" >
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/bootstrap/dist/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/default/css/theme.css?9ae093d');?>" media="screen">
    <link rel="stylesheet" href="<?php echo base_url('assets/default/css/print.css?9ae093d');?>" media="print">
    <link rel="stylesheet" href="<?php echo base_url('css/osticket.css?9ae093d');?>" media="screen"> 
    <link type="text/css" href="<?php echo base_url('css/ui-lightness/jquery-ui-1.10.3.custom.min.css?9ae093d');?>" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="<?php echo base_url('css/thread.css?9ae093dd');?>" media="screen">
    <link rel="stylesheet" href="<?php echo base_url('css/redactor.css?9ae093d');?>" media="screen">
    <link rel="stylesheet" href="<?php echo base_url('css/font-awesome.min.css?9ae093d');?>" media="screen">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/flags.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/rtl.css?9ae093d');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/select2.min.css?9ae093d');?>">
    <link rel="stylesheet" href="<?php echo base_url('scp/css/typeahead.css?9ae093d');?>" media="screen">  
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.2.min.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/jquery-ui-1.10.3.custom.min.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/osticket.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/filedrop.field.js?9ae093d');?>"></script>
    <script src="<?php echo base_url('scp/js/bootstrap-typeahead.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/redactor.min.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/redactor-plugins.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/redactor-osticket.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/select2.min.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('js/fabric.min.js?9ae093d');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/dist/js/bootstrap.min.js');?>"></script>

<!-- include summernote css/js -->
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
    
input[type="button"], input[type="reset"], input[type="submit"] {

    color: black !important;
}


.thread-entry > .pull-right {

     float: left!important; 
}

.thread-entry > .pull-left {

     float: right!important; 
}

.note-editor > .modal > .modal-dialog > .modal-content > .modal-body > .note-group-select-from-files
{

display: none;

}

</style>

</head>
<body>
    <?php
        $data = array(
            'offpages' => $this->db->query("SELECT body FROM ost_content_test WHERE type = 'offline' AND in_use = '1' AND field = 'pages'"),
        );
        $offline = $this->db->query("SELECT value FROM ost_config_test WHERE id = '12'");
        
        if ($offline->row('value') == '0')
        {   
            redirect("user_controller/login", $data);
        }

        $time = $_SERVER['REQUEST_TIME'];
        $timeout = $this->db->query("SELECT value FROM ost_config_test WHERE id = '20'")->row('value');

        if($timeout <> 0)
        {
            $timeout_duration = $timeout*60;
            if (isset($_SESSION['LAST_ACTIVITY']) && 
               ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
                session_unset();
                session_destroy();
                session_start();
                echo "<script> alert('You have been IDLE for too long, please log in to continue.');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/user_controller/login' </script>";
            }
            else
            {
            $_SESSION['LAST_ACTIVITY'] = $time;
            }
        } 
    ;?>

    <div id="container" class="container">

        <?php $logoclient = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' AND default_client = '1'");?>
        
        <?php if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != ''){ ?>
        <div id="header">
            <div class="pull-right flush-right">
            <p>
             <?php echo $_SESSION["username"] ?>&nbsp;| <a href="<?php echo site_url('user_controller/edit')?>">Profile</a> |
                <a href="<?php echo site_url('ticket_controller/main')?>">Tickets <b><!-- (2) --></b></a> -
                <a href="<?php echo site_url('logout_c/logout')?>">Sign Out</a>
                        </p>
            <p>
            </p>
            </div>
            <a class="pull-left" id="logo" href="<?php echo site_url('welcome/index')?>" title="Support Center">
                <span class="valign-helper"></span>
                <img src="/helpme/uploads/<?php echo $logoclient->row('name');?>" border="0" alt="Panda Ticketing System">
            </a>
        </div>

    <?php } else {?>
        <!-- no login session-->
        <div id="header">
            <div class="pull-right flush-right">
            <p>
                Guest User | <a href="<?php echo site_url('user_controller/login')?>">Sign In</a>
            </p>
            <p>
            </p>
            </div>
            <a class="pull-left" id="logo" href="<?php echo site_url('welcome/index')?>" title="Support Center">
                <span class="valign-helper"></span>
                <img src="/helpdesk/logo.php" border="0" alt="Panda Ticketing System">
            </a>
        </div>
        <!-- no login session-->

    <?php } ?>


    <?php 

    if ($this->uri->segment(1) == 'welcome' OR $this->uri->segment(1) == 'user_controller' OR $this->uri->segment(1) == '' )

    {

        $home = 'active';
        $knowledgebase = 'inactive';
        $open = 'inactive';
        $ticket = 'inactive';


    }

    else if ($this->uri->segment(1) == 'guide_controller')

    {

        $home = 'inactive';
        $knowledgebase = 'active';
        $open = 'inactive';
        $ticket = 'inactive';

    }

    else if ($this->uri->segment(1) == 'open_controller')

    {

        $home = 'inactive';
        $knowledgebase = 'inactive';
        $open = 'active';
        $ticket = 'inactive';

    }

    else if ($this->uri->segment(1) == 'ticket_controller')

    {

        $home = 'inactive';
        $knowledgebase = 'inactive';
        $open = 'inactive';
        $ticket = 'active';

    }

    ?>


        <div class="clear"></div>
                <section class="">
            <ol class="breadcrumb" id="navs" style="background-color:#ebeaea;">
                <li><a class="<?php echo $home ?> home" href="<?php echo site_url('welcome/index')?>">Support Center Home</a></li>

                <?php if (  
                    
                    $this->db->query("SELECT value FROM ost_config_test WHERE id='26'")->row('value') == '1'

                ) {  ?>
                <li><a class="<?php echo $knowledgebase ?> kb" href="<?php echo site_url('guide_controller/main')?>">Knowledgebase</a></li>

                <?php } ?>

                <li><a class="<?php echo $open ?> new" href="<?php echo site_url('open_controller/main')?>">Open a New Ticket</a></li>
                <li><a class="<?php echo $ticket ?> tickets" href="<?php echo site_url('ticket_controller/main')?>">Tickets <!-- (2) --></a></li>
            </ol>
      </section>
