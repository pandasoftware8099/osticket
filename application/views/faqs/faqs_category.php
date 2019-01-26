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
