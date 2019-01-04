<div id="content">
        
<h2>
    <i class="help-tip icon-question-sign" href="#help_topic_information"></i> 
    Update Help Topic    <small>
    — <?php echo $helptopic->topic;?></small>
</h2>

<div class="tab">
    <ul class="clean tabs" id="topic-tabs">
        <li class="active"><a href="#info"><i class="icon-info-sign"></i> Help Topic Information</a></li>
    </ul>
</div>

<form class="form-horizontal" action="<?php echo site_url('admin_manage_controller/manage_helptopics_info_process')?>?id=<?php echo $_REQUEST['id'] ?>" method="post">
<div id="topic-tabs_container">
<div class="tab_content" id="info">
    <div class="form-group" style="margin-bottom:0px;">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#topic"></i> Topic <span class="error">*</span>:</label>
        <div class="col-lg-10">
            <input type="text" size="30" name="topic" class="form-control" value="<?php echo $helptopic->topic;?>" autofocus="" data-translate-tag="a60996104b207ba6">
                &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#status"></i> Status <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="isactive" value="1" <?php echo ($helptopic->isactive == 1)?"checked":""; ?>> Active            
            <input type="radio" name="isactive" value="0" <?php echo ($helptopic->isactive == 0)?"checked":""; ?>> Disabled        
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#type"></i> Type <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="ispublic" value="1" <?php echo ($helptopic->ispublic == 1)?"checked":""; ?>> Public            
            <input type="radio" name="ispublic" value="0" <?php echo ($helptopic->ispublic == 0)?"checked":""; ?>> Private/Internal        
        </div>
    </div>
    <div class="col-lg-12">
        <div class="section-break" style="margin-bottom:10px;">
            <strong>Internal Notes:</strong>
                Be liberal, they're internal        </div>
        <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                
                <textarea name="notes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $helptopic->notes;?></textarea>
                
              
            </div>
          </div>
    </div>
</div>

</div>

<p style="text-align:center;">
    <input type="submit" name="submit" value="Save Changes">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;helptopics.php&quot;">
</p>
</form>
</div>
