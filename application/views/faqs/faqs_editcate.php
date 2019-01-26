<div id="content">
        <form action="<?php echo site_url('staff_faqs_controller/faqeditcate_process');?>?id=<?php echo $_REQUEST['id'];?>" method="post" class="save">
 <?php foreach ($faqcate->result() as $value) { ?>    
 <h2>Update Category     <small>
    — <?php echo $value->name ?></small>
         </h2>

    <div style="margin:8px 0"><strong>Category Type:</strong>
        <span class="error">*</span></div>
    <div style="margin-left:5px">


    
    <input type="radio" name="ispublic" value="2" <?php echo ($value->ispublic == 2)?"checked":""; ?>><b>Featured</b> (on front-page sidebar)    <br>
    <input type="radio" name="ispublic" value="1" <?php echo ($value->ispublic == 1)?"checked":""; ?>><b>Public</b> (publish)    <br>
    <input type="radio" name="ispublic" value="0" <?php echo ($value->ispublic == 0)?"checked":""; ?>>Private (internal)    <br>
    <?php } ?>
    <div class="error"></div>
    </div>

<div style="margin-top:20px"></div>

<div class="tab">
    <ul class="tabs clean" style="margin-top:9px;">
        <li class="active"><a href="#info">Category Information</a></li>
        <li><a href="#notes">Internal Notes</a></li>
    </ul>
</div>

<div class="tab_content" id="info">



    <div class="" id="lang-en_US">
    <div style="padding-bottom:8px;">
        <b>Category Name</b>:
        <span class="error">*</span>
        <div class="faded">Short descriptive name.</div>
    </div>
    <?php foreach ($faqcate->result() as $value1) { ?>

    <input required="true" type="text" size="70" class="form-control" style="font-size:110%;width:100%;box-sizing:border-box" name="catename" value="<?php echo $value1->name;?>">

    <?php } ?>
    <div class="error"></div>

    <div style="padding:8px 0;">
        <b>Category Description</b>:
        <span class="error">*</span>
        <div class="faded">Summary of the category.</div>
        <div class="error"></div>
    </div>
        <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                <?php foreach ($faqcate->result() as $value1) { ?>
                <textarea name="catedescrip" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $value1->description;?></textarea>
                <?php } ?>
              
            </div>
          </div>


    
    </div>
</div>


<div class="tab_content" id="notes" style="display:none;">
    <b>Internal Notes</b>:
    <span class="faded">Be liberal, they're internal</span>

        <?php foreach ($faqcate->result() as $value1) { ?>
                <textarea name="catenotes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $value1->notes;?></textarea>
        <?php } ?>

</div>


<p style="text-align:center">
    <input type="submit" name="submit" value="Save Changes">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;categories.php&quot;">
</p>
</form>
</div>

</div>
</div>