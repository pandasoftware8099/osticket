<div id="content">
        <h2>System Settings and Preferences <small>— <span class="ltr">osTicket (v1.10.1)</span></small></h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/main_process')?>" method="post">
<input type="hidden" name="__CSRFToken__" value="a212ae0fdc8a80bf90da74d99bf26871616257ea"><input type="hidden" name="t" value="system">
<div class="section-break" style="margin-bottom:10px;">
    <em><b>General Settings</b></em>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#helpdesk_status"></i> Helpdesk Status :</label>
    <div class="col-lg-9">
        <span>
            <label>
                <input type="radio" name="isonline" value="1" <?php echo ($isonline->row('value') == "1")?"checked":""; ?>>&nbsp;<b>Online</b>&nbsp;
            </label>
            <label><input type="radio" name="isonline" value="0" <?php echo ($isonline->row('value') == "0")?"checked":""; ?>>&nbsp;<b>Offline</b></label>
            &nbsp;<font class="error"></font>
        </span>
    </div>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        <i class="help-tip icon-question-sign" href="#helpdesk_url"></i> 
        Helpdesk URL <font class="error">*</font> : 
    </label>
    <div class="col-lg-9">
        <input type="text" class="form-control" size="40" name="helpdesk_url" value="https://panda-estore.com/helpdesk/">
        &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        <i class="help-tip icon-question-sign" href="#helpdesk_name_title"></i>
        Helpdesk Name/Title <font class="error">*</font> :
    </label>
    <div class="col-lg-9">
        <input type="text" class="form-control" size="40" name="helpdesk_title" value="<?php echo $helpdesk_title->value;?>">
                &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        <i class="help-tip icon-question-sign" href="#default_department"></i>
        Default Department <font class="error">*</font> :
    </label>
    <div class="col-lg-9">
        <select required="true" name="default_dept_id" class="form-control" data-quick-add="department">
                                <?php foreach ($department->result() as $value) { ?>
                                <option <?php echo ($default_dept_id->value == $value->id)?"selected":""; ?> value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                <?php } ?>
                            <option value="0" data-quick-add="">— Add New —</option>
        </select>&nbsp;<font class="error">&nbsp;</font>
    </div>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label">
        <i class="help-tip icon-question-sign" href="#collision_avoidance"></i>
        Collision Avoidance Duration <font class="error">*</font> :
    </label>
    <div class="col-lg-9">
        <input type="text" class="form-control" name="autolock_minutes" size="4" value="60">minutes        <font class="error"></font>
    </div>
</div>

<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#default_log_level"></i> Default Log Level :</label>
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
    <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#purge_logs"></i> Purge Logs :</label>
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
    <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#enable_avatars"></i> Show Avatars :</label>
    <div class="col-lg-9">
        <input type="checkbox" name="enable_avatars" checked="checked">
        Show Avatars on thread view.    </div>
</div>
<!-- <div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#enable_richtext"></i> Enable Rich Text :</label>
    <div class="col-lg-9">
        <input type="checkbox" name="enable_richtext" checked="checked">
                Enable html in thread entries and email correspondence.    </div>
</div> -->


<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>
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
});
</script>
</div>
</div>
    