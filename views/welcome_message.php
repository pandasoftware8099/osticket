<div id="content">

         <div id="landing_page">
<div class="col-lg-8">
<div class="search-form">


    <?php if ($enable_kb == '1') {  ?>

    <form method="post" action="<?php echo site_url('guide_controller/faqsearch_process');?>">
    <input type="text" name="search" class="search" placeholder="Search our knowledge base">
    <button type="submit" class="green button">Search</button>

    </form>

    
    <?php } ?>


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

<?php if ($enable_kb == '1') {  ?>
        <div class="content">            
            <section>
            <div class="header">Featured Questions</div>
            <?php foreach ($feature_question->result() as $value ) { ?>
                <div><a href="<?php echo site_url('guide_controller/info?id=');echo $value->faq_guid ?>"><?php echo $value->question ?> ?</a></div>
            <?php } ?>
            </section>
        </div>
<?php } ?>

    </div>

</div>
<div class="clear"></div>

<?php if ($enable_kb == '1') {  ?>

<div class="col-lg-8">
<br><br>
<div class="thread-body">
<?php if($feature_kb->num_rows() > '0'  ) { ?>

<h1>Featured Knowledge Base Articles</h1>

<?php } ?>

<?php foreach ($feature_kb->result() as $value) { ?>

<div class="featured-category front-page">
        <i class="icon-folder-open icon-2x"></i>
        <div class="category-name"><?php echo $value->name ?></div>

        <?php foreach ( $this->db->query("SELECT * FROM ost_faq_test WHERE ispublished = '2' AND category_guid = '$value->category_guid' ")->result() as $faq) { ?>

        <div class="article-headline">
            <div class="article-title"><a href="<?php echo site_url('guide_controller/info?id=');echo $faq->faq_guid ?>"><?php echo $faq->question ?></a></div>
            <div class="article-teaser"><?php echo strip_tags($faq->answer) ?></div>
        </div>

        <?php } ?>
        
    </div>



<?php } ?>
</div>   
</div>

<?php }  ?>

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