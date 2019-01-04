<div id="content">
    <div id="landing_page">
        <b><?php echo $ticket_info->row('value');?></b><small> #<?php echo $ticket_info->row('number');?></small>,<br><br>
        <?php echo $thank_you_page->row('body');?>
    </div>
</div>

<div id="footer">
    <p>Copyright © 2018 Panda Ticketing System - All rights reserved.</p>
    <a id="poweredBy" href="http://osticket.com" target="_blank">Helpdesk software - powered by osTicket</a>
</div>

<script type="text/javascript">
    getConfig().resolve({"html_thread":true,"lang":"en_US","short_lang":"en","has_rtl":false,"primary_language":"en-US","secondary_languages":[]});

    setTimeout(function () {
        window.location.href = '<?php echo site_url('ticket_controller/info');?>?id=<?php echo $ticket_info->row('ticket_id');?>'; // the redirect goes here
    },5000); // 5 seconds
</script>

</body>
</html>