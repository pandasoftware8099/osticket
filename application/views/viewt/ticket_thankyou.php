<div id="content">
    <div id="landing_page">
        <h1><b><?php echo $ticket_info->row('value');?> </b><small>#<?php echo $ticket_info->row('number');?>,</small></h1>
        <?php echo $thank_you_page->row('content');?>
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