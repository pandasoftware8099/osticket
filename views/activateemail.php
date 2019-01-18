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
<?php foreach ($result->result() as $value) { ?>

<p>Hi <?php echo $value->user_name;?>,</p>

<p>Click <a href="<?php echo site_url('user_controller/activateuser');?>?id=<?php echo $value->user_guid;?>">here</a> to activate your account for Panda Ticketing System.</p> 

<p>Thanks for using and have a great day.</p>

<?php } ?>

<?php echo $template->row('name_template');?><?php echo $template->row('name_template') != ""?"<br>":""; ?>
<?php echo $template->row('web_template');?><?php echo $template->row('web_template') != ""?"<br>":""; ?>
<?php echo $template->row('phone_template');?><?php echo $template->row('phone_template') != ""?"<br>":""; ?>
<?php echo $template->row('address_template');?>

</body>
</html>