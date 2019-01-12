<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="7200">
<title>Reset Password</title>
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

<body id="loginBody" style="background-image: url(<?php echo base_url('/uploads/'.$backdropstaff->row(
'name'))?>);background-repeat: no-repeat;background-size: cover;">

<div id="loginBox">
    <div id="blur">
        <div id="background"></div>
    </div>
    <h1 id="logo">
        <a href="index.php">
            <span class="valign-helper"></span>
            <img src="/helpme/uploads/<?php echo $logostaff->row('name');?>" alt="osTicket :: Staff Control Panel">
        </a>
    </h1>
       

    <div class="banner"><small></small></div>
    <form action="<?php echo site_url('user_controller/resetforgotpassword')?>" method="post" id="login">
        <fieldset>
            <input type="hidden" name="id" value="<?php if(isset($id))
            {  
                echo $id;
            }
            else if(isset($staffid)){
                echo $staffid;
            }?>">
            <input type="password" name="old_pw"  placeholder="Old/Temporary Password" autofocus="" autocorrect="off" autocapitalize="off" required>
            <input type="password" name="new_pw" placeholder="New Password" autofocus="" autocorrect="off" autocapitalize="off" required>
            <input type="password" name="confirm" placeholder="Confirm New Password" autocorrect="off" autocapitalize="off" required>
            <button class="submit button pull-right" type="submit" name="submit">
                <i class="icon-signin"></i> Confirm
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