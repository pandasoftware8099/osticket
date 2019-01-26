<div id="content">
        <h2>Company Profile</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/company_update');?>" method="post" enctype="multipart/form-data">

<div class="tab">
    <ul class="clean tabs">
        <li class="active"><a href="#basic-information"><i class="icon-asterisk"></i>
            Basic Information</a></li>
        <li><a href="#site-pages"><i class="icon-file"></i>
            Site Pages</a></li>
        <li><a href="#logos"><i class="icon-picture"></i>
            Logos</a></li>
        <li><a href="#backdrops"><i class="icon-picture"></i>
            Login Backdrop</a></li>
    </ul>
</div>

<div class="tab_content" id="basic-information">
    <div class="col-lg-12">
        <div class="section-break">
            <em>
                <strong>Company Information</strong>: Details available in email templates        </em>
        </div>
    </div>

    <div>
        <!--<td class="multi-line required" style="min-width:120px;" >-->
        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
            <label class="col-lg-3 control-label">
                Company Name<span class="error">*</span>  :
            </label>

            <div class="col-lg-9">
                <input required type="text" class="form-control" id="_aca11d87bd316d95" size="40" maxlength="64" placeholder="" name="cname" value="<?php echo $template->row('name_template')?>">
            </div>
        </div>

        <!--<td class="multi-line " style="min-width:120px;" >-->
        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
            <label class="col-lg-3 control-label">
                Website  :
            </label>

            <div class="col-lg-9">
                <input type="text" class="form-control" id="_84eff1e5c7a4a037" size="40" maxlength="64" placeholder="" name="cwebsite" value="<?php echo $template->row('web_template')?>">
            </div>
        </div>
        
        <!--<td class="multi-line " style="min-width:120px;" >-->
        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
            <label class="col-lg-3 control-label">
                Phone Number  :
            </label>

            <div class="col-lg-9">
                <input id="_a9f98b2a261bcfe2" type="tel" name="cphone" value="<?php echo $template->row('phone_template')?>">
            </div>
        </div>

        <!--<td class="multi-line " style="min-width:120px;" >-->
        <div class="col-lg-12" style="overflow:auto;margin-top:10px;margin-bottom:10px">
            <label class="col-lg-3 control-label">
                Address  :
            </label>
            
            <div class="col-lg-9">
                <span style="display:inline-block;width:100%">
                    <textarea class="form-control" rows="2" cols="40" maxlength="100" placeholder="" id="_1997e7c7fbea0e4d" name="caddress"><?php echo $template->row('address_template')?></textarea>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="hiddens tab_content" id="site-pages">
    <div class="section-break" style="margin-bottom:10px;">
        <em>To edit or add new pages go to <a href="<?php echo site_url('admin_manage_controller/manage_pages')?>"> Manage &gt; Site Pages </a></em>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"> Landing Page&nbsp;<font class="error">*</font> :</label>
        <div class="col-lg-9">
            <span>
                <select name="landing_page_guid" class="form-control" required>
                    <option value="">— Select Landing Page —</option>
                    <?php foreach ($landpages->result() as $lpages) {?>
                        <option value="<?php echo $lpages->content_guid;?>" <?php echo $lpages->content_guid == $orilandpages->row('content_guid')?"selected":"";?>><?php echo $lpages->name;?></option>
                    <?php }?>
                </select>&nbsp;
                <font class="error"></font>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"> Offline Page&nbsp;<font class="error">*</font> :</label>
        <div class="col-lg-9">
            <span>
                <select name="offline_page_guid" class="form-control" required>
                    <option value="">— Select Offline Page —</option>
                    <?php foreach ($offpages->result() as $opages) {?>
                        <option value="<?php echo $opages->content_guid;?>" <?php echo $opages->content_guid == $orioffpages->row('content_guid')?"selected":"";?>><?php echo $opages->name;?></option>
                    <?php }?>
                </select>&nbsp;
                <font class="error"></font>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"> Default Thank-You Page&nbsp;<font class="error">*</font> :</label>
        <div class="col-lg-9">
            <span>
                <select name="thank-you_page_guid" class="form-control" required>
                    <option value="">— Select Thank-You Page —</option>
                    <?php foreach ($typages->result() as $tpages) {?>
                        <option value="<?php echo $tpages->content_guid;?>" <?php echo $tpages->content_guid == $oritypages->row('content_guid')?"selected":"";?>><?php echo $tpages->name;?></option>
                    <?php }?>
                </select>
            </span>
        </div>
    </div>
</div>
<div class="hiddens tab_content" id="logos">
    <div style="overflow:auto;">
        <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Staff</th>
                    <th>Logo</th>
                    <th style="text-align: center;">Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($logo->result() as $logoimg) { ?>
                <tr>
                    <td>
                        <input type="radio" name="selected-logo" value="<?php echo $logoimg->file_guid;?>" style="margin-left: 1em" <?php echo $defclientlogo->row('file_guid') == "$logoimg->file_guid"?"checked":""; ?>>
                    </td>
                    <td>
                        <input type="radio" name="selected-logo-scp" value="<?php echo $logoimg->file_guid;?>" style="margin-left: 1em" <?php echo $defstafflogo->row('file_guid') == "$logoimg->file_guid"?"checked":""; ?>>
                    </td>
                    <td>
                        <img src="/helpme/uploads/<?php echo $logoimg->name;?>" alt="<?php echo $logoimg->name;?>" valign="middle" style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                            margin: 0.5em; height: 5em;
                            vertical-align: middle">
                    </td>
                    <td style="text-align: center;">
                        <input class="ckb" type="checkbox" name="dellogo[]" value="<?php echo $logoimg->file_guid;?>">
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div><br>

    <b>Upload a new logo:</b>
    <div id="reply_form_attachments" class="attachments">
        <div class="filedrop">
            <div class="files"></div>
            <div class="dropzone" style="color: black;">
                <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="logo[]" id="logo" class="logo" multiple>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
</div>

<div class="hiddens tab_content" id="backdrops">
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Backdrop</th>
                <th style="text-align: center;">Delete</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($backdrop->result() as $backdropimg) { ?>
            <tr>
                <td>
                    <input type="radio" name="selected-backdrop" value="<?php echo $backdropimg->file_guid;?>" style="margin-left: 1em" <?php echo $defstaffbackdrop->row('file_guid') == "$backdropimg->file_guid"?"checked":""; ?>>
                </td>
                <td>
                    <img src="/helpme/uploads/<?php echo $backdropimg->name;?>" alt="<?php echo $backdropimg->name;?>" valign="middle" style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                        margin: 0.5em; height: 6em;
                        vertical-align: middle">
                </td>
                <td style="text-align: center;">
                    <input class="ckb" type="checkbox" name="delbackdrop[]" value="<?php echo $backdropimg->file_guid;?>">
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table><br>

    <b>Upload a new backdrop:</b>
    <div id="reply_form_attachments" class="attachments">
        <div class="filedrop">
            <div class="files"></div>
            <div class="dropzone" style="color: black;">
                <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="backdrop[]" id="backdrop" class="backdrop" multiple>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
</div>

<p style="text-align:center;">
    <input class="button" type="submit" name="submit-button" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>

<div style="display: none; top: 58.0833px; left: 488px;" class="dialog" id="confirm-action">
    <h3>Please Confirm</h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <p class="confirm-action" id="delete-confirm">
        <font color="red"><strong>Are you sure you want to DELETE selected images?</strong></font>
        <br><br>Deleted data CANNOT be recovered.    </p>
    <div>Please confirm to continue.</div>
    <hr style="margin-top:1em">
    <p class="full-width">
        <span class="buttons pull-left">
            <input type="button" value="No, Cancel" class="close">
        </span>
        <span class="buttons pull-right">
            <input type="button" value="Yes, Do it!" class="confirm">
        </span>
     </p>
    <div class="clear"></div>
</div>

<script type="text/javascript">
$(function() {
    $('#save input:submit.button').bind('click', function(e) {
        var formObj = $('#save');
        if ($('input:checkbox:checked', formObj).length) {
            e.preventDefault();
            $('.dialog#confirm-action').undelegate('.confirm');
            $('.dialog#confirm-action').delegate('input.confirm', 'click', function(e) {
                e.preventDefault();
                $('.dialog#confirm-action').hide();
                $('#overlay').hide();
                formObj.submit();
                return false;
            });
            $('#overlay').show();
            $('.dialog#confirm-action .confirm-action').hide();
            $('.dialog#confirm-action p#delete-confirm')
            .show()
            .parent('div').show().trigger('click');
            return false;
        }
        else return true;
    });
});
</script>
</div>
</div>
 