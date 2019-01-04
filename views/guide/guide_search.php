<div id="content">

         <div class="col-lg-8">
    <h1>Frequently Asked Questions</h1>
    <div><strong>Search Results</strong></div>
<div id="faq">4 FAQs matched your search criteria.
    <ol>

        <?php foreach ($search->result() as $value) { ?>
        <li><a href="<?php echo site_url('staff_faqs_controller/faqinfo');?>?id=<?php echo $value->faq_id;?>" class="previewfaq"><?php echo $value->question;?></a></li>
        <?php } ?>

    </ol>
</div>
</div>

<div class="col-lg-4">
    <div class="sidebar">
    <div class="searchbar">
    <form method="post" action="<?php echo site_url('guide_controller/faqsearch_process');?>">
    <input type="text" name="search" class="search form-control" placeholder="Search our knowledge base">
    <input type="submit" style="display:none" value="search">
    </form>
    </div>

    </div>
</div>        </div>
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