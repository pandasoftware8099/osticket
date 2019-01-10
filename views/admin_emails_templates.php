<div id="content">
    <form action="<?php echo site_url('admin_emails_controller/emails_templates_process')?>" method="POST" name="roles">
<div class="sticky placeholder"></div><div class="sticky bar">
    <div class="content" style="width: 908px;">
        <div class="pull-left">
            <h2></i> Email Template Sets
            </h2>
        </div>
        <div class="pull-right flush-right">
            <a href="<?php echo site_url('admin_emails_controller/emails_templates_add')?>" class="green button action-button"><i class="icon-plus-sign"></i> Add New Template Set</a>
            <span class="action-button" data-dropdown="#action-dropdown-more">
                <i class="icon-caret-down pull-right"></i>
                <span><i class="icon-cog"></i> More</span>
            </span>
            <div id="action-dropdown-more" class="action-dropdown anchor-right" style="display: none;">
                <ul>
                    <li>
                        <a id="enable" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=enable">
                            <i class="icon-ok-sign icon-fixed-width"></i>
                            Enable</a>
                    </li>
                    <li>
                        <a id="disable" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=disable">
                            <i class="icon-ban-circle icon-fixed-width"></i>
                            Disable</a>
                    </li>
                    <li class="danger">
                        <a id="delete" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=delete">
                            <i class="icon-trash icon-fixed-width"></i>
                            Delete</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    <a class="only sticky scroll-up" href="#" data-stop="135"><i class="icon-chevron-up icon-large"></i></a></div>
</div>

<div style="overflow:auto;">
<table id="ttable" class="list" border="0" cellspacing="1" cellpadding="0" width="100%" style="white-space: nowrap;">
    <thead>
        <tr>
            <th nowrap="" width="4%" style="text-align: center;"><input type="checkbox" id="tidsall" onclick="checkedAll ();"></th>
            <th style="padding-left:4px;vertical-align:middle" width="30%">Name</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Status</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">In-use</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Date Added</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Last Updated</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($templategroup->result() as $value) { ?>
            <tr>
                <td align="center"><input type="checkbox" class="ckb" id="tids" name="tids[]" value="<?php echo $value->tpl_id?>" <?php echo $default_template_id->row('value') == $value->tpl_id?"disabled":"";?>></td>
                <td>&nbsp;<a href="<?php echo site_url('admin_emails_controller/emails_templates_info')?>?id=<?php echo $value->tpl_id?>"><?php echo $value->name?></a> <?php echo $default_template_id->row('value') == $value->tpl_id?" <small>(System Default)</small>":"";?></td>
                <td><?php if ($value->isactive == 1){ ?>
                        Active
                    <?php } else if ($value->isactive == 0) { ?>
                        Inactive
                    <?php } ?></td>
                <td><?php echo $default_template_id->row('value') == $value->tpl_id?"Yes":"No";?></td>
                <td><?php echo $value->created?></td>
                <td><?php echo $value->updated?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<!-- more popup modal -->
<div class="modal fade" id="more-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h3>Please Confirm</h3>
            </div>
            <div class="modal-body">
                <p class="confirm-action" style="display: block;" id="enable-confirm">
                Are you sure you want to <b>enable</b> selected team(s)?</p>

                <p class="confirm-action" style="display: none;" id="disable-confirm">
                Are you sure you want to <b>disable</b> selected team(s)?</p>

                <p class="confirm-action" style="display: none;" id="delete-confirm">
                    <font color="red"><strong>Are you sure you want to DELETE selected team(s)? </strong></font>
                </p>
            <div>Please confirm to continue.</div>
            </div>

            <div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" value="No, Cancel" class="close">
                    </span>
                    <span class="buttons pull-right">
                        <input type="submit" value="Yes, Do it!" class="confirm">
                    </span>
                </p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <input type="hidden" name="status">
</div>
<!-- more popup modal -->

</form>

</div>
</div>

<script type="text/javascript">
  
var checked=false;
function checkedAll () {
    var aa =  document.getElementsByName("tids[]");
    checked = document.getElementById('tidsall').checked;
     
    for (var i =0; i < aa.length; i++) 
    {
        if (aa[i].value != <?php echo $default_template_id->row('value');?>)
        {
            aa[i].checked = checked;
        }
    }
 }

</script>

<script>
  $(document).ready(function () {    
    $('#ttable').DataTable({
      "columnDefs": [{ "orderable": false, "targets": 0 }],
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [ [1 , 'asc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#enable').click(function() {
        checked = $("input[id=tids]:checked").length;

        if(!checked) {
          alert("You must check at least one ticket.");
          return false;
        }
        document.getElementById("disable-confirm").style.display = "none";
        document.getElementById("delete-confirm").style.display = "none";
        document.getElementById("enable-confirm").style.display = "block";
        $('#more-modal').find("[name=status]").val(1);
    });

    $('#disable').click(function() {
        checked = $("input[id=tids]:checked").length;

        if(!checked) {
          alert("You must check at least one ticket.");
          return false;
        }
        document.getElementById("enable-confirm").style.display = "none";
        document.getElementById("delete-confirm").style.display = "none";
        document.getElementById("disable-confirm").style.display = "block";
        $('#more-modal').find("[name=status]").val(0);
    });

    $('#delete').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }
      document.getElementById("enable-confirm").style.display = "none";
      document.getElementById("disable-confirm").style.display = "none";
      document.getElementById("delete-confirm").style.display = "block";
      $('#more-modal').find("[name=status]").val(2);
    });
});

</script>
