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


<p>Hi <?php echo $name;?>,</p> 

<p>Your ticket number #<?php echo $number?> had been replied by one of our staff </p> 

<p>Click <a href="<?php echo site_url('ticket_controller/info');?>?id=<?php echo $ticketid?>">here</a> go to our ticketing system and check for message.</p> 

<p>Thanks for using and have a great day.</p>


<?php echo $template->row('name_template');?><?php echo $template->row('name_template') != ""?"<br>":""; ?>
<?php echo $template->row('web_template');?><?php echo $template->row('web_template') != ""?"<br>":""; ?>
<?php echo $template->row('phone_template');?><?php echo $template->row('phone_template') != ""?"<br>":""; ?>
<?php echo $template->row('address_template');?>

</body>
</html>