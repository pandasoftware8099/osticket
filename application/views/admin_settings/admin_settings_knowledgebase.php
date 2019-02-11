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
                <i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box');" onmouseleave="MouseOut('tip_box')"></i> 
                Enable Knowledge Base                <div class="error"></div>
                <input type="checkbox" name="restrict_kb" value="1" <?php echo ($restrict_kb == 1)?"checked":""; ?> >
                <i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box1');" onmouseleave="MouseOut('tip_box1')"></i>
                Require Client Login                <div class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-4 control-label">Canned Responses :</label>
        <div class="col-lg-8">
            <input type="checkbox" name="enable_premade" value="1" <?php echo ($enable_premade == 1)?"checked":""; ?>>
                <i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box2');" onmouseleave="MouseOut('tip_box2')"></i>
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

<div class="tip_box" id="tip_box" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Knowledge Base Status</h1>Enable this setting to allow your users self-service access to your public knowledge base articles. <br><br> Knowledge base categories and FAQs can be made internal (viewable only by Agents).
    </div>
</div>

<div class="tip_box" id="tip_box1" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Restrict Access to the Knowledge Base</h1>Enable this setting to prevent unregistered users from accessing your knowledge base articles on the client interface.
    </div>
</div>

<div class="tip_box" id="tip_box2" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Canned Responses</h1>Enable this setting to allow Agents to use <span class="doc-desc-title">Canned Responses</span> when replying to tickets.
    </div>
</div>

<script type="text/javascript">
    function MouseOver(e,divid) {
        var left  = e.clientX  + "px";
        var top  = e.clientY  + "px";
        // alert('test');
        var div = document.getElementById(divid);

        div.style.display = 'block';
        div.style.left = left;
        div.style.top = top;

        // $('#'+divid).css('display', 'block');
    }

    function MouseOut(divid) {
        document.getElementById(divid).style.display = 'none';
    }
</script>