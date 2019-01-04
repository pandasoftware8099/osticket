<div id="content">
        <div style="overflow:auto"><div class="has_bottom_border" style="padding-top:5px;">
<div class="pull-left"><h2>Frequently Asked Questions</h2></div>
<div class="pull-right flush-right">
    <a href="<?php echo site_url('staff_faqs_controller/printprewviewfaq');?>?id=<?php echo $_REQUEST['id'];?>" class="no-pjax action-button">
    <i class="icon-print"></i>
        Print    </a>

    <?php if ($faqallow != 0 ) { ?>
    <a href="<?php echo site_url('staff_faqs_controller/faqeditfaq');?>?id=<?php echo $_REQUEST['id'];?>" class="action-button">
    <i class="icon-edit"></i>
        Edit FAQ    </a>
    <a data-toggle="modal" data-target="#deletefaqs" class="action-button">
    <i class="icon-trash"></i>
        Delete FAQ </a>
    <?php } ?>

</div><div class="clear"></div>

</div>

<div id="breadcrumbs">
    <a href="<?php echo site_url('staff_faqs_controller/main');?>">All Categories</a>
    » <a href="<?php echo site_url('staff_faqs_controller/faqcategory');?>?cid=<?php echo $faqcate->category_id;?>"><?php echo $faqcate->name;?></a>
    <span class="faded">(Public)</span>
</div>

<div class="col-lg-8">

<?php foreach ($faqinfo->result() as $value1) { ?>
<div class="faq-title flush-left"><?php echo $value1->question;?></div>

<div class="faded">Last Updated    <?php echo $value1->updated;?></div>

<?php } ?>
<br>
<div class="thread-body bleed">

<?php foreach ($faqinfo->result() as $value2) { ?>

<?php 

echo $value2->answer;


?>
<?php } ?>

<!-- <?php foreach ($faqdetails->result() as $value2) { ?>

<?php 

echo $value2->text;

echo '<br><br><img src="data:image/jpeg;base64,'.base64_encode( $value2->image ).'"/><br><br>';

?>
<?php } ?> -->




</div>

</div>
<div class="col-lg-4 sidebar faq-meta">



<section>
<div>
    <strong>Extra</strong>
</div>

<?php foreach ($faqinfo->result() as $value1) { ?>
    <?php 
        $file = $this->db->query("SELECT * FROM ost_file_test AS b
            INNER JOIN ost_faq_test AS a
            ON a.faq_id = b.faq_id
            WHERE b.faq_id = '".$value1->faq_id."'");
    ?>

    <?php 
        if ($file->num_rows() > 0)
        { ?>
            <div class="attachments">

            <?php foreach ($file->result() as $val) {
                $name = $val->name;
            ?>    

                <i class="icon-paperclip icon-flip-horizontal"></i>
                <a href="<?php echo base_url('uploads/').$name;?>" download="<?php echo $name;?>" ><?php echo $name;?></a>

            <?php } ?>
            </div>
    <?php } ?>
<?php } ?>



</section>

</div>
<hr>
</div>        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>
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
<div class="modal fade" id="deletefaqs" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3>Please Confirm</h3>
              </div>
              <div class="modal-body">

                <p class="confirm-action" style="" id="delete-confirm">
                <font color="red"><strong>Are you sure you want to DELETE this FAQ?</strong></font>
                <br><br>Deleted data CANNOT be recovered.    </p>

                <div style="display:block; margin:5px;">
                <form class="mass-action" method="post" name="delete" id="delete" action="<?php echo site_url('staff_faqs_controller/faqdelete_process');?>?id=<?php echo $_REQUEST['id'];?>">
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

<div id="overlay"></div>
<div id="loading" style="top: 219px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 54.75px; left: 374.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 54.75px; left: 618.5px;" class="dialog" id="alert">
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