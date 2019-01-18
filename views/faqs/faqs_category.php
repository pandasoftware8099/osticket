<div id="content">
        <div class="has_bottom_border" style="margin-bottom:5px; padding-top:5px;">
<div class="pull-left">
  <h2>Frequently Asked Questions</h2>
</div>

<?php if ($faqallow != 0 ) { ?>
<div class="pull-right flush-right">
    <a class="green action-button" href="<?php echo site_url('staff_faqs_controller/faqadd');?>">Add New FAQ</a>
    <span class="action-button" data-dropdown="#action-dropdown-more" style="/*DELME*/ vertical-align:top; margin-bottom:0">
        <i class="icon-caret-down pull-right"></i>
        <span><i class="icon-cog"></i>More</span>
    </span>
    <div id="action-dropdown-more" class="action-dropdown anchor-right" style="display: none;">
        <ul>
            <?php foreach ($faqcate->result() as $value) { ?>  
            <li><a class="user-action" href="<?php echo site_url('staff_faqs_controller/faqeditcate');?>?id=<?php echo $value->category_guid;?>">
                <i class="icon-pencil icon-fixed-width"></i>Edit Category</a>
            </li>
            <li class="danger">
                <a class="user-action" data-toggle="modal" data-target="#delete">
                    <i class="icon-trash icon-fixed-width"></i>Delete Category</a>
            </li>
            <?php } ?>  
        </ul>
    </div>
</div>
<?php } ?>

<div class="clear"></div>

</div>
<div class="faq-category">

<?php foreach ($faqcate->result() as $value) { ?>    
    <div style="margin-bottom:10px;">
        <div class="faq-title pull-left"><?php echo $value->name;?></div>
        <div class="faq-status inline">(

        <?php if($value->ispublic == '1') { ?>

        Public

        <?php } else if ($value->ispublic == '0') { ?>

        Private

        <?php } else if ($value->ispublic == '2') {?>

        Featured

        <?php }?>


        )</div>
        <div class="clear"><time class="faq"> Last Updated </time></div>
    </div>
    <div class="cat-desc has_bottom_border">
    <?php echo $value->description;?></div>
<?php } ?>    

<div id="faq">
            <ol>

            <?php foreach ($faqinfo->result() as $value1) { ?>
            <li><strong><a href="<?php echo site_url('staff_faqs_controller/faqinfo');?>?id=<?php echo $value1->faq_guid;?>" class="previewfaq"><?php echo $value1->question;?><span>- 

                <?php if($value1->ispublished == '1') { ?>

                Published

                <?php } else if ($value1->ispublished == '0') { ?>

                Internal

                <?php } else if ($value1->ispublished == '2') {?>

                Featured

                <?php } ?>

            </span></a> </strong></li>
            <?php } ?>

            </ol>
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
</div>

<!-- delete categories faq popup modal -->
<div class="modal fade" id="delete" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3>Please Confirm</h3>
              </div>
              <div class="modal-body">

                <p class="confirm-action" style="" id="delete-confirm">
                <font color="red"><strong>Are you sure you want to DELETE this category?</strong></font>
                <br><br>Deleted data CANNOT be recovered, including any associated FAQs.    </p>

                <div style="display:block; margin:5px;">
                <form class="mass-action" method="post" name="delete" id="delete" action="<?php echo site_url('staff_faqs_controller/categories_delete_process');?>?cid=<?php echo $_REQUEST['cid'];?>">
                <div class="modal-footer">

                    <p class="full-width">
                      <span class="buttons pull-left">
                          <input type="button" data-dismiss="modal" value ="Close">
                          <input type="reset" value="Reset">
                      </span>
                      <span class="buttons pull-right">
                          <input type="submit" class="red button" value="Delete">
                    <select name="delete" hidden="true" >
                      <option value="5"></option>
                  


                    </select>
                    

                      </span>
                   </p>

                </div>
                </form>
                </div>

              </div>
              
            </div>
           
          </div>
         
</div>
  <!-- delete categories faq popup modal -->


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


</body>