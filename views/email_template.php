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
<?php echo $body->row('email');?>

<div style="color:rgb(127, 127, 127)">
	<?php if (isset($signature) && isset($ticketsign)) { ?>
		<?php if ($signature == 'mine' && $ticketsign->row('staffsign') != '') { ?>
		    <?php echo $ticketsign->row('staffsign');?>
		<?php } elseif ($signature == 'dept' && $ticketsign->row('deptsign') != '') { ?>
		    <?php echo $ticketsign->row('deptsign');?>
		<?php } ?>
	<?php } ?>

	<?php echo $template->row('name_template');?><?php echo $template->row('name_template') != ""?"<br>":""; ?>
	<?php echo $template->row('web_template');?><?php echo $template->row('web_template') != ""?"<br>":""; ?>
	<?php echo $template->row('phone_template');?><?php echo $template->row('phone_template') != ""?"<br>":""; ?>
	<?php echo $template->row('address_template');?><?php echo $template->row('address_template') != ""?"<br>":""; ?>
</div>
<hr/>
<div style="color:rgb(127, 127, 127);font-size:small">
	<em>If you wish to provide additional comments or information regarding the issue, please reply to this email or <a href="http://localhost/helpme/index.php/user_controller/login"><span style="color:rgb(84, 141, 212)">login to your account</span></a> for a complete archive of your support requests.</em>
</div> 


</body>
</html>