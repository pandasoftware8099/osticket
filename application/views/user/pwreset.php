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
<div id="brickwall"></div>
<div id="loginBox">
    <div id="blur">
        <div id="background"></div>
    </div>
    <h1 id="logo"><a href="index.php">
        <span class="valign-helper"></span>
        <img src="/helpme/uploads/<?php echo $logostaff->row('name');?>" alt="osTicket :: Agent Password Reset">
    </a></h1>
    <h3>Enter your username or email address below</h3>
    <form action="<?php echo site_url('user_controller/forgot_pw')?>" method="post">
        <fieldset>
            <input type="text" name="useremail" value="" placeholder="Email or Username" autocorrect="off" autocapitalize="off">
        </fieldset>
        <input class="submit" type="submit" name="submit" value="Send Email">
    </form>

    <div id="company">
        <div class="content">
            Copyright © Panda Ticketing System        </div>
    </div>
</div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (undefined === window.getComputedStyle(document.documentElement).backgroundBlendMode) {
            document.getElementById('loginBox').style.backgroundColor = 'white';
        }
    });
    </script>


</body></html>