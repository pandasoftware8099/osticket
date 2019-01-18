<div id="content">
        <h2>Knowledge Base Settings and Options</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/settings_knowledgebase_process')?>" method="post">

    <div class="section-break" style="margin-bottom:10px;">
        <em>Disabling knowledge base disables clients' interface.</em>
    </div>
    <div class="form-group">
        <label class="col-lg-4 control-label">Knowledge Base Status :</label>
        <div class="col-lg-8">
            <input type="checkbox" name="enable_kb" value="1" <?php echo ($enable_kb == 1)?"checked":""; ?>>
                <i class="help-tip icon-question-sign" href="#knowledge_base_status"></i> 
                Enable Knowledge Base                <div class="error"></div>
                <input type="checkbox" name="restrict_kb" value="1" <?php echo ($restrict_kb == 1)?"checked":""; ?> >
                <i class="help-tip icon-question-sign" href="#restrict_kb"></i> 
                Require Client Login                <div class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-4 control-label">Canned Responses :</label>
        <div class="col-lg-8">
            <input type="checkbox" name="enable_premade" value="1" <?php echo ($enable_premade == 1)?"checked":""; ?>>
                <i class="help-tip icon-question-sign" href="#canned_responses"></i>
                Enable Canned Responses                &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>
</div>

</div>