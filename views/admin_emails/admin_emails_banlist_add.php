<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_banlist_add_process')?>" method="post">
 <input type="hidden" name="__CSRFToken__" value="904b7d1db6a1823f46704c8f27b30c1f9525f6d8"> <input type="hidden" name="do" value="add">
 <input type="hidden" name="a" value="add">
 <input type="hidden" name="id" value="">

    <h2><i class="help-tip icon-question-sign" href="#ban_list"></i> Add New Email Address to Ban List    </h2>
    <div class="section-break" style="margin-bottom:10px;">
        <em>Valid email address is required</em>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Ban Status <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="isactive" value="1" checked="checked"><strong>Active</strong>
            <input type="radio" name="isactive" value="0">Disabled        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Email Address <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input required="true" name="val" class="form-control" type="text" size="24" value="">
                 &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Internal Notes</strong>: Admin Notes&nbsp;</em>
    </div>
    <div class="col-lg-12">
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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                
              
            </div>
            </div>
    </div>
<p style="text-align:center;">
    <input type="submit" name="submit" value="Add">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;banlist.php&quot;">
</p>
</form>
</div>

</div>