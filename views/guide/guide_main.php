<div id="content">

         <div class="col-lg-8">
        <div>Click on the category to browse FAQs.</div>
        <ul id="kb">
            <?php foreach ($faqcate->result() as $value) { ?>    
            <li><i></i>
            <div style="margin-left:45px">
            


                <h4><a href="<?php echo site_url('guide_controller/category')?>?id=<?php echo $value->category_id;?>"><?php echo $value->name ?> (<?php echo $this->db->query("SELECT COUNT(*) as total FROM ost_faq_test WHERE category_id = '".$value->category_id."'")->row('total');?>)</a></h4>
                <div class="faded" style="margin:10px 0">
                <?php echo $value->description ?></div>

            </li>
            <?php } ?>  
            <!-- <li><i></i>
            <div style="margin-left:45px">
            <h4><a href="faq.php?cid=3">Panda Ticketing System - Client (4)</a></h4>
            <div class="faded" style="margin:10px 0">
                Panda Ticketing System Guide - Client            </div>
                <div class="popular-faq"><i class="icon-file-alt"></i>
                <a href="faq.php?id=8">
                Cannot create new ticket ?                </a></div>
                <div class="popular-faq"><i class="icon-file-alt"></i>
                <a href="faq.php?id=4">
                How to create new ticket ?                </a></div>
                <div class="popular-faq"><i class="icon-file-alt"></i>
                <a href="faq.php?id=3">
                How to register client account ?                </a></div>
                <div class="popular-faq"><i class="icon-file-alt"></i>
                <a href="faq.php?id=5">
                How to reset password ?                </a></div>
            </div>
            </li> -->
       </ul>
</div>
<div class="col-lg-4">
<div class="sidebar">
<div class="searchbar">
    <form method="post" action="<?php echo site_url('guide_controller/faqsearch_process');?>">
    <input type="text" name="search" class="search form-control" placeholder="Search our knowledge base">
    <input type="submit" style="display:none" value="search">
    </form>
</div>

<div class="content"></div>
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