<div id="content">
        <h2>System Settings and Preferences <small>— <span class="ltr">osTicket (v1.10.1)</span></small></h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/main_process')?>" method="post">
<input type="hidden" name="__CSRFToken__" value="a212ae0fdc8a80bf90da74d99bf26871616257ea"><input type="hidden" name="t" value="system">
<div class="section-break" style="margin-bottom:10px;">
    <em><b>General Settings</b></em>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:10px;">
    <label class="col-lg-3 control-label" style="padding-top:0px;"> Helpdesk Status :</label>
    <div class="col-lg-9">
        <span>
            <label>
                <input type="radio" name="isonline" value="1" <?php echo ($isonline->row('value') == "1")?"checked":""; ?>>&nbsp;<b>Online</b>&nbsp;
            </label>
            <label>
                <input type="radio" name="isonline" value="0" <?php echo ($isonline->row('value') == "0")?"checked":""; ?>>&nbsp;<b>Offline</b>
            </label>
            &nbsp;<font class="error"></font>
        </span>
    </div>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        Helpdesk URL <font class="error">*</font> : 
    </label>
    <div class="col-lg-9">
        <input type="text" class="form-control" size="40" name="helpdesk_url" value="<?php echo $helpdesk_url->row('value');?>">
        &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        Helpdesk Name/Title <font class="error">*</font> :
    </label>
    <div class="col-lg-9">
        <input type="text" class="form-control" size="40" name="helpdesk_title" value="<?php echo $helpdesk_title->value;?>">
                &nbsp;<font class="error"></font>
    </div>
</div>

<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        Default Department <font class="error">*</font> :
    </label>
    <div class="col-lg-9">
        <select required="true" name="default_dept_guid" class="form-control" id="department">
            <?php foreach ($department as $value) { ?>
            <?php if ($value['depart_public'] == '1') { ?>
            <option <?php echo ($default_dept_guid->value == $value['depart_id'])?"selected":""; ?> value="<?php echo $value['depart_id'];?>"><?php echo $value['depart_name'];?></option>
            <?php } ?>
            <?php } ?>
            <option value="0">— Add New —</option>
        </select>&nbsp;<font class="error">&nbsp;</font>
    </div>
</div>

<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label" style="padding-top:0px">
        Collision Avoidance Duration <font class="error">*</font> :
    </label>
    <div class="col-lg-8">
        <input type="number" class="form-control no-spin" style="border-right:0px;" name="autolock_minutes" size="4" value="<?php echo $autolock_minutes->row('value');?>">
    </div>
    <div class="col-lg-1">
        <input type="text" class="form-control" style="border-left:0px;background-color:white;text-align:center;margin:0 0 0 -35px;width:83px" value="minutes" disabled>
    </div>
    <font class="error">&nbsp;</font>
</div>

<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label"> Default Page Size :</label>
    <div class="col-lg-9">
        <select name="max_page_size" class="form-control">
            <?php for ($i=5;$i<=50;$i+=5) { ?>
            <option value=<?php echo $i;?> <?php echo $max_page_size->row('value') == $i?"selected":"";?>><?php echo $i;?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label"> Default Log Level :</label>
    <div class="col-lg-9">
        <select name="log_level" class="form-control">
            <option value="0">None (Disable Logger)</option>
            <option value="3"> DEBUG</option>
            <option value="2" selected="selected"> WARN</option>
            <option value="1"> ERROR</option>
        </select>
        <font class="error">&nbsp;</font>
    </div>
</div>
<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label"> Purge Logs :</label>
    <div class="col-lg-9">
        <select name="log_graceperiod" class="form-control">
            <option value="0" selected="">Never Purge Logs</option>
                            <option value="1">
                    After 1 month                </option>
                                <option value="2">
                    After 2 months                </option>
                                <option value="3">
                    After 3 months                </option>
                                <option value="4">
                    After 4 months                </option>
                                <option value="5">
                    After 5 months                </option>
                                <option value="6">
                    After 6 months                </option>
                                <option value="7">
                    After 7 months                </option>
                                <option value="8">
                    After 8 months                </option>
                                <option value="9">
                    After 9 months                </option>
                                <option value="10">
                    After 10 months                </option>
                                <option value="11">
                    After 11 months                </option>
                                <option selected="selected" value="12">
                    After 12 months                </option>
                        </select>
    </div>
</div>
<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label" style="padding-top: 0px"> Show Avatars :</label>
    <div class="col-lg-9">
        <input type="hidden" name="enable_avatars" value="0">
        <input type="checkbox" name="enable_avatars" value="1" <?php echo $enable_avatars->row('value') == 1?"checked":"";?>>
        Show Avatars on thread view.    </div>
</div>
<!-- <div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#enable_richtext"></i> Enable Rich Text :</label>
    <div class="col-lg-9">
        <input type="checkbox" name="enable_richtext" checked="checked">
                Enable html in thread entries and email correspondence.    </div>
</div> -->

<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label" style="padding-top:0px"> Maximum File Size :</label>
    <div class="col-lg-9">
        <select name="max_file_size" class="form-control">
            <option value="262144" <?php echo $max_file_size->row('value') == 262144?"selected":"";?>>256 kB</option>
            <option value="524288" <?php echo $max_file_size->row('value') == 524288?"selected":"";?>>512 kB</option>
            <option value="1048576" <?php echo $max_file_size->row('value') == 1048576?"selected":"";?>>1 MB</option>
            <option value="2097152" <?php echo $max_file_size->row('value') == 2097152?"selected":"";?>>2 MB</option>
        </select>
        <div class="error"></div>
    </div>
</div>

<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label" style="padding-top:0px"> Maximum Files :</label>
    <div class="col-lg-9">
        <input type="number" class="form-control no-spin" size="40" name="max_files" value="<?php echo $max_files->row('value');?>">
        <div class="error"></div>
    </div>
</div>

<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>

<!-- add new department popup modal -->
<div class="modal fade" id="new_department"">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <h3 class="drag-handle">Add New Department</h3>
            </div>

            <form action="<?php echo site_url('admin_settings_controller/add_new_department?direct=admin_settings_system');?>" method="POST">
            <div class="modal-body">
                <table class="grid form">
                    <tbody>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <select class="form-control" name="main_department">
                                        <option value="0">— Top-Level Department —</option>
                                        <?php foreach ($department as $value) { ?>
                                        <option value="<?php echo $value['depart_id'];?>"><?php echo $value['depart_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <input type="text" class="form-control" size="16" maxlength="128" placeholder="Name" name="department_name" required>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <br><label>Email Mailbox:</label>

                                    <select class="form-control" name="department_email">
                                        <option value="0">— System Default —</option>
                                        <?php foreach ($department_email->result() as $email) {?>
                                        <option value="<?php echo $email->email_guid;?>"><?php echo $email->email;?></option>
                                        <?php }?>
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <br><label class="checkbox" style="padding-left:43px">
                                        <input type="hidden" name="department_internal" value="1">
                                        <input type="checkbox" name="department_internal" value="0">
                                        This department is for internal use
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Cancel">
                        <input type="reset" value="Reset">
                    </span>
                    <span class="buttons pull-right">
                        <input type="submit" value="Create">
                    </span>
                </p>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- add new department popup modal -->
  
<script type="text/javascript">
$(function() {
    $('#secondary_langs').sortable({
        cursor: 'move'
    });
    var prev = [];
    $('input.date-format-preview').keyup(function() {
        var name = $(this).attr('name'),
            div = $('span.date-format-preview[data-for='+name+']'),
            current = $(this).val();
        if (prev[name] && prev[name] == current)
            return;
        prev[name] = current;
        div.text('...');
        $.get('ajax.php/config/date-format', {format:$(this).val()})
            .done(function(html) { div.html(html); });
    });

    $('#department').change(function() {
        var depart_id = $(this).val();
        if(depart_id == '0')
        {
            $('#new_department').modal("show");
        }
    });
});
</script>
</div>
</div>
    