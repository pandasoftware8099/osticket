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
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2018&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>

<div id="overlay" style="opacity: 0.5; display: none;"></div>
<div id="loading" style="top: 219px; left: 533px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 54.75px; left: 383px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 54.75px; left: 627px;" class="dialog" id="alert">
    <h3><i class="icon-warning-sign"></i> <span id="title"></span></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <div id="body" style="min-height: 20px;"></div>
    <hr style="margin-top:3em">
    <p class="full-width">
        <span class="buttons pull-right">
            <input type="button" value="OK" class="close ok">
        </span>
     </p>
    <div class="clear"></div>
</div>

<script type="text/javascript" src="/helpdesk/js/jquery.pjax.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-typeahead.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/scp.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/filedrop.field.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/select2.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/tips.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-osticket.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-plugins.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.translatable.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.dropdown.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-tooltip.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/fabric.min.js?9ae093d"></script>
<link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/tooltip.css?9ae093d">
<script type="text/javascript">
    getConfig().resolve({"lock_time":3600,"html_thread":true,"date_format":"Y-MM-dd","lang":"en_US","short_lang":"en","has_rtl":false,"lang_flag":"us","primary_lang_flag":"us","primary_language":"en-US","secondary_languages":[],"page_size":25});
</script>


</body></html>