<div id="content">
<form class="form-horizontal"
    <?php if (empty($pages->row('id'))) {?>
        action="<?php echo site_url('admin_manage_controller/manage_pages_addnew_process')?>"
    <?php }
    else {?>
        action="<?php echo site_url('admin_manage_controller/manage_pages_update_process')?>?id=<?php echo $_REQUEST['id'];?>"
    <?php }?>
    method="post" class="save">

 <h2><?php if (empty($pages->row('id'))) {?>
        Add New Page
     <?php }
     else {?>
        Update Page <small>— <?php echo $pages->row('name');?></small>
     <?php }?>
 </h2>

    <div class="section-break" style="margin-bottom:10px;">
        <em>Page information</em>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">Name <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="text" size="40" name="name" class="form-control" value="<?php if (!empty($pages->row('id'))) {?> <?php echo $pages->row('name');?> <?php }?>" autofocus data-translate-tag=""/>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">Type <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <span>
                <select name="type" class="form-control">
                    <option value="">&mdash; Select Page Type &mdash;</option>
                    <option value="landing" <?php echo $pages->row('type') == 'landing'?"selected":"";?>>Landing Page</option>
                    <option value="offline" <?php echo $pages->row('type') == 'offline'?"selected":"";?>>Offline Page</option>
                    <option value="thank-you" <?php echo $pages->row('type') == 'thank-you'?"selected":"";?>>Thank-You Page</option>
                    <option value="other" <?php echo $pages->row('type') == 'other'?"selected":"";?>>Other</option>
                </select>
                &nbsp;<span class="error"></span>
            </span>
        </div>
    </div>
        <div class="form-group">
        <label class="col-lg-2 control-label" style="padding-top: 0px">Status 
            <span class="error">*</span> :
        </label>

        <div class="col-lg-10">
            <input type="radio" name="isactive" value="1" <?php echo $pages->row('isactive') == '1'?"checked":"";?>>
            <strong>Active</strong>
            <input type="radio" name="isactive" value="0" <?php echo $pages->row('isactive') == ('0' || '')?"checked":"";?>>
            Disabled&nbsp;
            <span class="error"></span>
        </div>
    </div>
<div style="margin-top: 10px">
  <div class="tab">
    <ul class="tabs clean">
      <li class="active"><a href="#page-content">Page Content</a></li>
      <li><a href="#notes">Internal Notes</a></li>
    </ul>
  </div>
  <div class="tab_content active" id="page-content">

    <div id="translations_container">
        <div id="translation-en_US" lang="en_US">
            <textarea required="true" name="content" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                <?php if (!empty($pages->row('id'))) {?>
                    <?php echo $pages->row('body');?>
                <?php }?>
            </textarea>
        </div>

      <div id="msg_info">
        <em><i class="icon-info-sign"></i> Ticket variables are only supported in thank-you pages.</em>
      </div>

      <div class="error" style="margin: 5px 0"></div>
      <div class="clear"></div>
    </div>
  </div>

    <div class="tab_content" style="display:none" id="notes">
        <em><strong>Internal Notes</strong>:
            Be liberal, they're internal</em>
            <textarea name="notes" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                <?php if (!empty($pages->row('id'))) {?>
                    <?php echo $pages->row('notes');?>
                <?php }?>
            </textarea>
    </div>
</div>

<p style="text-align:center">
    <input type="submit" name="submit" value="<?php echo $pages->row('id') == ''?"Add Page":"Save Changes";?>">
    <input type="reset"  name="reset"  value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick='window.location.href="<?php echo site_url('admin_manage_controller/manage_pages')?>"'>
</p>
</form>
</div>
</div>