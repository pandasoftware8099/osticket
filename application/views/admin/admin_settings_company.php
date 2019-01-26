<div id="content">
        <h2>Company Profile</h2>
<form class="form-horizontal" action="settings.php?t=pages" method="post" enctype="multipart/form-data">

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
                        Company Name                             <span class="error">*</span>
                         :
                    </label>
                    <div class="col-lg-9">        <input type="text" class="form-control" id="_aca11d87bd316d95" size="40" maxlength="64" placeholder="" name="aca11d87bd316d95" value="Panda Ticketing System">
                                </div>
                        </div>
                            <!--<td class="multi-line " style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Website  :
                    </label>
                    <div class="col-lg-9">        <input type="text" class="form-control" id="_84eff1e5c7a4a037" size="40" maxlength="64" placeholder="" name="84eff1e5c7a4a037" value="http://www.pandasoftware.my/">
                                </div>
                        </div>
                            <!--<td class="multi-line " style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Phone Number  :
                    </label>
                    <div class="col-lg-9">        <input id="_a9f98b2a261bcfe2" type="tel" name="a9f98b2a261bcfe2" value="">                        </div>
                        </div>
                            <!--<td class="multi-line " style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Address  :
                    </label>
                    <div class="col-lg-9">        <span style="display:inline-block;width:100%">
        <textarea class="form-control" rows="2" cols="40" maxlength="100" placeholder="" id="_1997e7c7fbea0e4d" name="1997e7c7fbea0e4d"></textarea>
        </span>
                                </div>
                        </div>
    </div></div>
<div class="hiddens tab_content" id="site-pages">
    <div class="section-break" style="margin-bottom:10px;">
        <em>To edit or add new pages go to <a href="pages.php"> Manage &gt; Site Pages </a></em>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#landing_page"></i> Landing Page&nbsp;<font class="error">*</font> :</label>
        <div class="col-lg-9">
            <span>
                <select name="landing_page_guid" class="form-control">
                    <option value="">— Select Landing Page —</option>
                    <option value="1" selected="selected">Landing</option>                </select>&nbsp;<font class="error"></font>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#offline_page"></i> Offline Page&nbsp;<font class="error">*</font> :</label>
        <div class="col-lg-9">
            <span>
                <select name="offline_page_guid" class="form-control">
                    <option value="">— Select Offline Page —</option>
                    <option value="3" selected="selected">Offline</option>                </select>&nbsp;<font class="error"></font>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#default_thank_you_page"></i> Default Thank-You Page&nbsp;<font class="error">*</font> :</label>
        <div class="col-lg-9">
            <span>
                <select name="thank-you_page_guid" class="form-control">
                    <option value="">— Select Thank-You Page —</option>
                    <option value="2" selected="selected">Thank You</option>                </select>&nbsp;<font class="error"></font>
            </span>
        </div>
    </div>
</div>
<div class="hiddens tab_content" id="logos">
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#logos"></i> System Default Logo</em>
    </div>
    <div style="overflow:auto;">
        <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
            <tbody>
                <tr>
                    <td colspan="2">
                        <table style="width:100%">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Staff</th>
                                    <th>Logo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="selected-logo" value="0" style="margin-left: 1em" checked="checked">
                                    </td>
                                    <td>
                                        <input type="radio" name="selected-logo-scp" value="0" style="margin-left: 1em" checked="checked">
                                    </td>
                                    <td>
                                        <img src="/helpdesk/assets/default/images/logo.png" alt="Default Logo" valign="middle" style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                                                    margin: 0.5em; height: 5em;
                                                    vertical-align: middle">
                                        <img src="/helpdesk/scp/images/ost-logo.png" alt="Default Logo" valign="middle" style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                                                    margin: 0.5em; height: 5em;
                                                    vertical-align: middle">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3">
                                        <em><i class="help-tip icon-question-sign" href="#upload_a_new_logo"></i> Use a custom logo</em>
                                    </th>
                                </tr>
                                                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">
            <b>Upload a new logo:</b>
        </label>
        <div class="col-lg-9">
            <input type="file" name="logo[]" class="form-control" size="30" value="">
            <font class="error"><br></font>
        </div>
    </div>
</div>

<div class="hiddens tab_content" id="backdrops">
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#backdrops"></i> System Default Backdrop</em>
    </div>
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
        <tbody>
            <tr>
                <td colspan="2">
                    <table style="width:100%">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Backdrop</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="radio" name="selected-backdrop" value="0" style="margin-left: 1em" checked="checked">
                                </td>
                                <td>
                                    <img src="/helpdesk/scp/images/login-headquarters.jpg" alt="Default Backdrop" valign="middle" style="box-shadow: 0 0 0.5em rgba(0,0,0,0.5);
                                                margin: 0.5em; height: 6em;
                                                vertical-align: middle">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <em><i class="help-tip icon-question-sign" href="#upload_a_new_backdrop"></i> Use a custom backdrop</em>
                                </th>
                            </tr>
                                                    </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <label class="col-lg-3 control-label">
            <b>Upload a new backdrop:</b>
        </label>
        <div class="col-lg-9">
            <input type="file" name="backdrop[]" size="30" value="" class="form-control">
            <font class="error"><br></font>
        </div>
    </div>
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
 