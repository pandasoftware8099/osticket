<div id="content">
<div class="container">
    <?php foreach ($cinfo->result() as $value) { ?>
    <h1>Editing Ticket #<?php echo $value->number;?></h1>
    <?php } ?> 
</div>

<form action="<?php echo site_url('ticket_controller/EditUpdate')?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $_REQUEST['id']; ?>">
    <div id="dynamic-form" style="overflow:auto;">
        <div class="col-lg-12" style="overflow:auto;">
        <hr>
            <div class="form-header" style="margin-bottom:0.5em;">
                <h3>Contact Information</h3>
            </div>
            
            <?php foreach ($cinfo->result() as $info) { ?>
            <div class="form-group">
                <label for="3936ff14708de280" class="col-sm-3 control-label">
                    <span class="">Contact Name</span>                
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_3936ff14708de280" size="40" maxlength="64" placeholder="" name="companyname" value="<?php echo $info->contact;?>">
                </div>            
            </div>

            <div class="form-group">
                <label for="e896ffe018d7180a" class="col-sm-3 control-label" style="padding-top:7px;">
                    <span class="">Phone Numbers</span>
                </label>
                <div class="col-sm-5">
                    <input class="form-control" id="_e896ffe018d7180a" type="tel" name="phoneno" value="<?php echo $info->phone_no;?>">
                </div>
                <div class="col-sm-4" style="padding-left:0px;">
                    <label class="col-sm-3 control-label" style="padding-right:0px;padding-top:7px;">
                        <span class="">Ext</span>
                    </label>
                    <div class="col-sm-9" style="padding-left:0px;padding-right:0px">
                        <input class="form-control" type="text" name="phonenoext" value="<?php echo $info->phone_no_ext;?>">
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="col-lg-12" style="overflow:auto;">
        <hr>
            <div class="form-header" style="margin-bottom:0.5em;">
                <h3>Inventory</h3>
            </div>

            <div class="form-group">
                <label for="625cf22b29d9dc5b" class="col-sm-3 control-label" style="padding-top:7px">
                    <span class="required">
                        Ticket Subtopic
                        <span class="error">*</span>
                    </span>
                </label>
                <div class="col-sm-9">
                    <select class="form-control" name="subinventory" id="_625cf22b29d9dc5b" data-placeholder="Select">
                        <?php foreach ($inventory->result() as $sub) { ?>
                            <option value="<?php echo $sub->list_item_guid?>" <?php echo $sub->list_item_guid == $cinfo->row('subtopic_guid')?"selected":"";?>><?php echo $sub->value?><?php echo $sub->list_item_guid == $cinfo->row('subtopic_guid')?" (Current Selection)":"";?></option>
                        <?php }?>
                    </select>
                </div>            
            </div>     
        </div>
    </div>
    <hr>
    <p style="text-align: center;">
        <input type="submit" value="Update">
        <input type="reset" value="Reset">
    </p>
</form>
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">        </div>
    </div>