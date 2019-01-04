<div id="content">

         
<div class="col-lg-8">
    <h1>Frequently Asked Questions</h1>
    <h2><strong><?php echo $faqcate->name ?></strong></h2>
<p>
<?php echo $faqcate->description ?></p>
<hr>

         <h2>Further Articles</h2>
         <div id="faq">
            <ol>
                <?php foreach ($faq->result() as $value) { ?>    
                    <li><a href="<?php echo site_url('guide_controller/info')?>?id=<?php echo $value->faq_id;?>"><?php echo $value->question ?> &nbsp;</a></li>  
                <?php } ?>    
            </ol>
         </div></div>

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