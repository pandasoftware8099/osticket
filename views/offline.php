<html lang="en_US"><head>
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
    <script type="text/javascript"></script>
</head>

<body>
    <div id="container" class="container">
        <div id="header">
            <a class="pull-left" id="logo" href="<?php echo site_url('welcome/index')?>" title="Support Center">
                <span class="valign-helper"></span>
                <img src="/helpdesk/logo.php" border="0" alt="Panda Ticketing System">
            </a>
        </div>

        <div class="clear"></div>
        <hr>

        <div id="content">
            <div id="landing_page">
                <?php echo $offpages->row('body');?>
            </div>
        </div>
    </div>

    <div id="footer">
        <p>Copyright © 2018 Panda Ticketing System - All rights reserved.</p>
        <a id="poweredBy" href="http://osticket.com" target="_blank">Helpdesk software - powered by osTicket</a>
    </div>

<script type="text/javascript">
    getConfig().resolve({"html_thread":true,"lang":"en_US","short_lang":"en","has_rtl":false,"primary_language":"en-US","secondary_languages":[]});
</script>

</body>
</html>