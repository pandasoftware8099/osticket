<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
    <title>' . html_escape($subject) . '</title>
    <style type="text/css">
        body {
            font-family: Arial, Verdana, Helvetica, sans-serif;
            font-size: 16px;
        }
    </style>
</head>

<body>
<p>Dear <?php echo $emailinfo->row('user_name');?>, </p>

<p>Our customer care team has created a ticket, 
    <?php if($allow_auth_tokens=='0'){?>
        <a href="<?php echo site_url('user_controller/login');?>">#<?php echo $emailinfo->row('number');?></a>
    <?php } elseif($allow_auth_tokens=='1'){ ?>
        <a href="<?php echo site_url('user_controller/allow_auth');?>?id=<?php echo $ticketid?>">#<?php echo $emailinfo->row('number');?></a> <?php }; ?>
    on your behalf, with the following details and summary:</p>
}

Topic: <b><?php echo $emailinfo->row('topic');?></b><br>
Subject: <b><?php echo $emailinfo->row('value');?></b>

<p>If need be, a representative will follow-up with you as soon as possible. You can also <a href = "<?php echo site_url('user_controller/login');?>">view this ticket's progress online.</a></p>

<?php if ($signature == 'mine' && $ticketsign->row('staffsign') != '') { ?>
    <p><?php echo $ticketsign->row('staffsign');?></p>
<?php } elseif ($signature == 'dept' && $ticketsign->row('deptsign') != '') { ?>
    <p><?php echo $ticketsign->row('deptsign');?></p>
<?php } ?>

<?php echo $template->row('name_template');?><?php echo $template->row('name_template') != ""?"<br>":""; ?>
<?php echo $template->row('web_template');?><?php echo $template->row('web_template') != ""?"<br>":""; ?>
<?php echo $template->row('phone_template');?><?php echo $template->row('phone_template') != ""?"<br>":""; ?>
<?php echo $template->row('address_template');?>
</body>
</html>