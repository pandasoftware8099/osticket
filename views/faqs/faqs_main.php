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
<div>Click on the category to browse FAQs or manage its existing FAQs.</div>
                <ul id="kb">

                <?php foreach ($faqcate->result() as $value) { ?>
                    
                    <li>
                    <h4><a class="truncate" style="max-width:600px" href="<?php echo site_url('staff_faqs_controller/faqcategory');?>?cid=<?php echo $value->category_guid;?>"><?php echo $value->name;?>(<?php echo $this->db->query("SELECT COUNT(*) as total FROM ost_faq_test WHERE category_guid = '".$value->category_guid."'")->row('total');?>)</a> - 
                        <span>


                        <?php if($value->ispublic == '1') { ?>

                        Public

                        <?php } else if ($value->ispublic == '0') { ?>

                        Private

                        <?php } else if ($value->ispublic == '2') {?>

                        Featured

                        <?php }?>

                        </span>
                    </h4>
                    <?php echo $value->description;?>
                    </li>

                <?php } ?>


                </ul>
</div>
</div>

</div>
</div>