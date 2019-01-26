<div id="content">
        <form id="kbSearch" action="<?php echo site_url('staff_faqs_controller/faqsearch_process');?>" method="post">

        <div id="basic_search" style="overflow:auto;">
            <div class="attached input">
                <input id="query" type="text" size="20" name="search" autofocus="" value="">
                <button class="attached button" id="searchSubmit" type="submit">
                    <i class="icon icon-search"></i>
                </button>
            </div>

        </div>
        </form>
    <div class="has_bottom_border" style="margin-bottom:5px; padding-top:5px;">
        <div class="pull-left">
            <h2>Frequently Asked Questions</h2>
        </div>
        <div class="clear"></div>
    </div>
<div>
<div><strong>Search Results</strong></div><div class="clear"></div><div id="faq">
                <ol>
                    <?php foreach ($search->result() as $value) { ?>
                    <li><a href="<?php echo site_url('staff_faqs_controller/faqinfo');?>?id=<?php echo $value->faq_guid;?>" class="previewfaq"><?php echo $value->question;?></a> - <span>

                         <?php if($value->ispublished == '1') { ?>

                        Public

                        <?php } else if ($value->ispublished == '0') { ?>

                        Private

                        <?php } else if ($value->ispublished == '2') {?>

                        Featured

                        <?php }?>

                    </span></li>
                    <?php } ?>
                </ol>
             </div></div>
</div>
</div>