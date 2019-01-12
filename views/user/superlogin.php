<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="7200">
<title>Agent Login</title>
<link rel="icon" type="image/png" href="/helpdesk/assets/default/images/logo.png">
<link rel="apple-touch-icon" href="/helpdesk/assets/default/images/logo.png">

<link rel="stylesheet" href="<?php echo base_url() ?>/css/login.css" type="text/css">
<link type="text/css" rel="stylesheet" href="/helpdesk/css/font-awesome.min.css?9ae093d">
<meta name="robots" content="noindex">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="/helpdesk/js/jquery-1.11.2.min.js?9ae093d"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("input:not(.dp):visible:enabled:first").focus();
     });
</script>
<script type="text/javascript"></script></head>

<?php $logostaff = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'logo' AND default_staff = '1'");?>
<?php $backdropstaff = $this->db->query("SELECT * FROM ost_file_test WHERE type = 'backdrop' AND default_staff = '1'");?>

<body id="loginBody" style="background-image: url(<?php echo base_url('/uploads/'.$backdropstaff->row('name'))?>);background-repeat: no-repeat;background-size: cover;">

<div id="loginBox">
    <div id="blur">
        <div id="background"></div>
    </div>
    <a href="<?php echo site_url('user_controller/login')?>" style="float:right;margin-right:5px;">
        <i class="icon-signout" style="color:#4380B8;text-decoration: none;font-size: 26px;"></i>
    </a>
    <h1 id="logo">
        <a href="<?php echo site_url('user_controller/superlogin')?>">
            <span class="valign-helper"></span>
            <img src="/helpme/uploads/<?php echo $logostaff->row('name');?>" alt="osTicket :: Staff Control Panel">
        </a>
    </h1>
    <?php 
        if ($offline->row('value') == '0')
        { ?>
            <h3>System Offline</h3>
        <?php }
        else if ($offline->row('value') == '1' && isset($_SESSION['blocked']))
        { ?>
            <h3>Access Denied for <?php echo $block_period?> minutes after several wrong login attempts.</h3>
        <?php } 
        else if ($offline->row('value') == '1')
        { ?>
            <h3>Authentication Required</h3>
    <?php } ?>

    <div class="banner">
        <small><?php echo $this->db->query("SELECT * FROM ost_content_test WHERE type = 'banner-staff'")->row('body');?></small>
    </div>

    <form action="<?php echo site_url('user_controller/super_login_form')?>" method="post" id="login">
        <fieldset>
            <input type="text" name="userid" id="name" value="" placeholder="Email or Username" autofocus="" autocorrect="off" autocapitalize="off">
            <input type="password" name="passwd" id="pass" placeholder="Password" autocorrect="off" autocapitalize="off">
            <?php if(isset($allow_pw_reset)){ 
            if($allow_pw_reset == '1' && isset($_SESSION['loginsecond'])){?>
            <a id="forgotpw" href="<?php echo site_url('user_controller/forgot_pw') ?>" style="font-size: 12px;">Forgot Your Password?</a>
            <?php }} ?>
            <button class="submit button pull-right" type="submit" name="submit">
                <i class="icon-signin"></i> Log In
            </button>

        </fieldset>
    </form>

    <div id="company">
        <div class="content">
            Copyright © Panda Ticketing System
        </div>
    </div>
</div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (undefined === window.getComputedStyle(document.documentElement).backgroundBlendMode) {
            document.getElementById('loginBox').style.backgroundColor = 'white';
        }
    });
    </script>
    <!--[if IE]>
    <style>
        #loginBox:after { background-color: white !important; }
    </style>
    <![endif]-->

</body></html>