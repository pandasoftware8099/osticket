<div id="content">

         <div class="col-lg-8">
    <h1>Frequently Asked Questions</h1>
    <!-- <div><strong>Search Results</strong></div> -->
<div id="faq"><?php echo $search->num_rows() ?> FAQs matched your search criteria.
    <ol>

        <?php foreach ($search->result() as $value) { ?>
        <li><a href="<?php echo site_url('guide_controller/info')?>?id=<?php echo $value->faq_guid;?>" class="previewfaq"><?php echo $value->question;?></a></li>
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
