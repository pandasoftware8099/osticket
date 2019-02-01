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
                    <li><a href="<?php echo site_url('guide_controller/info')?>?id=<?php echo $value->faq_guid;?>"><?php echo $value->question ?> &nbsp;</a></li>  
                <?php } ?>    
            </ol>
         </div></div>

      </div>
    </div>
