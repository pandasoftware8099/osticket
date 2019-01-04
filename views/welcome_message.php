<div id="content">

         <div id="landing_page">
<div class="col-lg-8">
<div class="search-form">
    <form method="get" action="kb/faq.php">
    <input type="hidden" name="a" value="search">
    <input type="text" name="q" class="search" placeholder="Search our knowledge base">
    <button type="submit" class="green button">Search</button>
    </form>
</div>
    <div class="thread-body">
        <?php echo $landpages->row('body');?> 
    </div>
</div>
<div class="col-lg-4">
    <div>
        <div class="front-page-button flush-right">
<p>
            <a href="<?php echo site_url('open_controller/main')?>" style="display:block" class="blue button">Open a New Ticket</a>
</p>
<p>
            <a href="<?php echo site_url('ticket_controller/main')?>" style="display:block" class="green button">Check Ticket Status</a>
</p>
        </div>
        <div class="content">            <section><div class="header">Featured Questions</div>
            <div><a href="/helpdesk/kb/faq.php?id=3">How to register client account ?</a></div>
            <div><a href="/helpdesk/kb/faq.php?id=4">How to create new ticket ?</a></div>
            <div><a href="/helpdesk/kb/faq.php?id=5">How to reset password ?</a></div>
            <div><a href="/helpdesk/kb/faq.php?id=8">Cannot create new ticket ?</a></div>
            <div><a href="/helpdesk/kb/faq.php?id=6">How to login as agent ?</a></div>
            </section>
</div>
    </div>

</div>
<div class="clear"></div>

<div>
<br><br>
</div>
</div>

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