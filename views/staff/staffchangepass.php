<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Panda Ticketing System</title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="/helpdesk/assets/default/images/logo.png">
    <link rel="apple-touch-icon" href="/helpdesk/assets/default/images/logo.png">

    <link type="text/css" rel="stylesheet" href="/helpdesk/assets/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/helpdesk/css/osticket.css?9ae093d" media="screen">
    <link rel="stylesheet" href="/helpdesk/assets/default/css/theme.css?9ae093d" media="screen">
    <link rel="stylesheet" href="/helpdesk/assets/default/css/print.css?9ae093d" media="print">
    <link rel="stylesheet" href="/helpdesk/scp/css/typeahead.css?9ae093d" media="screen">   
    <link type="text/css" href="/helpdesk/css/ui-lightness/jquery-ui-1.10.3.custom.min.css?9ae093d" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="/helpdesk/css/thread.css?9ae093d" media="screen">
    <link rel="stylesheet" href="/helpdesk/css/redactor.css?9ae093d" media="screen">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/font-awesome.min.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/flags.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/rtl.css?9ae093d">
    <link type="text/css" rel="stylesheet" href="/helpdesk/css/select2.min.css?9ae093d">
    <script type="text/javascript" src="/helpdesk/js/jquery-1.11.2.min.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
    <script src="/helpdesk/js/osticket.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/filedrop.field.js?9ae093d"></script>
    <script src="/helpdesk/scp/js/bootstrap-typeahead.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/redactor.min.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/redactor-plugins.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/redactor-osticket.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/select2.min.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/js/fabric.min.js?9ae093d"></script>
    <script type="text/javascript" src="/helpdesk/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <meta name="csrf_token" content="12c2cebeb988fe44d2dcd7b6e47f5400f54c6921">

<style type="text/css">
    
input[type="button"], input[type="reset"], input[type="submit"] {

    color: black !important;
}


.thread-entry > .pull-right {

     float: left!important; 
}

.thread-entry > .pull-left {

     float: right!important; 
}

</style>

</head>

<div id="content">

         <div class="col-lg-12"><center>
<h1>Reset your password</h1>
<p>Password change is required for login</p>
<p>Use the forms below to reset</p></center>
</div>

<?php 
if(isset($_REQUEST['id']))
    { ?>
        <form action="<?php echo site_url('staff_controller/staffchangepassword')?>?id=<?php echo $_REQUEST['id']?>" method="post" class="form-horizontal">
<?php }
    else if(isset($staffid))
    { ?>
        <form action="<?php echo site_url('staff_controller/staffchangepassword')?>?id=<?php echo $staffid?>" method="post" class="form-horizontal">
<?php }; ?>

<!-- <div class="col-lg-12">
    <div><hr><h3>Preferences</h3></div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">
        Time Zone      </label>
    </div>
    </div> -->
<div class="col-xs-12">
    <div style="margin-bottom:10px;"><hr><h3>Access Credentials</h3></div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">
            Original Password          </label>
          <div class="col-sm-9">
            <input type="password" size="18" class="form-control" name="oripasswd" value="" >
            &nbsp;<span class="error">&nbsp;</span>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">
            New Password          </label>
          <div class="col-sm-9">
            <input type="password" size="18" class="form-control" name="passwd1" value="">
            &nbsp;<span class="error">&nbsp;</span>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">
            Confirm New Password          </label>
          <div class="col-sm-9">
            <input type="password" size="18" name="passwd2" value="" class="form-control">
        &nbsp;<span class="error">&nbsp;</span>
          </div>
        </div>
</div>
<hr>
<p style="text-align: center;">
    <input type="submit" value="Update">
    <input type="reset" value="Reset">
</p>
</form>
        </div>
    </div>
    <div id="footer">
        <p>Copyright © 2018 Panda Ticketing System - All rights reserved.</p>
        <a id="poweredBy" href="http://osticket.com" target="_blank">Helpdesk software - powered by osTicket</a>
    </div>
<div id="overlay" style="opacity: 0.3; top: 0px; left: 0px;"></div>
<div id="loading" style="top: 219px; left: 514.5px;">
    <h4>Please Wait!</h4>
    <p>Please wait... it will take a second!</p>
</div>
<script type="text/javascript">
    getConfig().resolve({"html_thread":true,"lang":"en_US","short_lang":"en","has_rtl":false,"primary_language":"en-US","secondary_languages":[]});
</script>


</body></html>