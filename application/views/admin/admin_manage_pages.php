<div id="content">
    <div class="sticky bar opaque">
        <div class="content">
            <div class="pull-left flush-left">
                <h2>Site Pages</h2>
            </div>
            <div class="pull-right flush-right">
                <a href="<?php echo site_url('admin_manage_controller/manage_pages_addupdate?id=')?>" class="green button action-button"><i class="icon-plus-sign"></i> Add New Page</a>
                <span class="action-button" id="enablepages" data-toggle="modal" data-target="#pages"><i class="icon-ok-sign icon-fixed-width"></i>Enable</span>
                <span class="action-button" id="disablepages" data-placement="bottom" data-toggle="modal" data-target="#pages"><i class="icon-ban-circle icon-fixed-width"></i>Disable</span>
                <span class="red button action-button" id="deletepages" data-placement="bottom" data-toggle="modal" data-target="#pages"><i class="icon-trash icon-fixed-width"></i>Delete</span>
            </div>
        </div>
    </div>
    <div class="clear"></div>

<form action="<?php echo site_url('admin_manage_controller/manage_pages_status_process')?>" method="POST" name="tpls">
<div style="overflow:auto;">
 <table class="list" id="ttable" border="0" cellspacing="1" cellpadding="0" width="100%">
    <thead>
        <tr>
            <th width="4%" style="text-align: center;"><input type="checkbox" name="pids[]" id="pidsall" onclick="checkedAll ();"></th>
            <th width="34%">Name</a></th>
            <th width="10%">Type</a></th>
            <th width="16%">Status</a></th>
            <th width="18%" nowrap>Date Added</a></th>
            <th width="18%" nowrap>Last Updated</a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pages->result() as $pagesinfo) { ?>
        <tr>
            <td align="center"><input type="checkbox" class="ckb" name="pids[]" value="<?php echo $pagesinfo->content_guid;?>"></td>
            <td>&nbsp;<a href="<?php echo site_url('admin_manage_controller/manage_pages_addupdate');?>?id=<?php echo $pagesinfo->content_guid;?>"><?php echo $pagesinfo->name;?></a></td>
            <td class="faded"><?php echo $pagesinfo->type;?></td>
            <td>&nbsp;<?php echo $pagesinfo->isactive == 1?"Active":"<b>Disabled</b>";?>&nbsp;&nbsp;<em><?php echo $pagesinfo->in_use == 1?"(in-use)":"";?></em></td>
            <td>&nbsp;<?php echo $pagesinfo->created;?></td>
            <td>&nbsp;<?php echo $pagesinfo->updated;?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>

<!-- assigned ticket  popup modal -->
<div class="modal fade" id="pages" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Pages Status</h3>
            </div>

            <div class="modal-body">
                <p class="confirm-action" style="" id="enable-confirm">
                    Are you sure you want to <b>enable</b> selected site pages?
                    <input type="hidden" id="enable" name="enable" value="1"></p>
                <p class="confirm-action" style="display:none;" id="disable-confirm">
                    Are you sure you want to <b>disable</b> selected site pages?
                    <input type="hidden" id="disable" name="disable" value="1"></p>
                <p class="confirm-action" style="display:none;" id="delete-confirm">
                    <font color="red"><strong>Are you sure you want to DELETE selected site pages?</strong></font>
                    <br><br>Deleted data CANNOT be recovered.
                    <input type="hidden" id="delete" name="delete" value="1"></p>
                <div>Please confirm to continue.</div>
            </div>

            <div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="No, Cancel">
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
</div>
<!-- assgined ticket popup modal -->
</form>

<script>
  $(document).ready(function () {    
    $('#ttable').DataTable({
      "columnDefs": [{ "orderable": false, "targets": 0 }],
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [ [1 , 'desc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<script type="text/javascript">
    var checked=false;
    function checkedAll () {
        var aa =  document.getElementsByName("pids[]");
        checked = document.getElementById('pidsall').checked;
         
        for (var i =0; i < aa.length; i++) 
        {
            aa[i].checked = checked;
        }
    }
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#enablepages').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#enable-confirm").attr('style', '');
      $("#disable-confirm").attr('style', 'display:none');
      $("#delete-confirm").attr('style', 'display:none');
      $("#enable").attr('name', 'enable');
      $("#disable").attr('name', true);
      $("#delete").attr('name', true);

    });
});

$(document).ready(function () {
    $('#disablepages').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#enable-confirm").attr('style', 'display:none');
      $("#disable-confirm").attr('style', '');
      $("#delete-confirm").attr('style', 'display:none');
      $("#enable").attr('name', true);
      $("#disable").attr('name', 'disable');
      $("#delete").attr('name', true);

    });
});

$(document).ready(function () {
    $('#deletepages').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#enable-confirm").attr('style', 'display:none');
      $("#disable-confirm").attr('style', 'display:none');
      $("#delete-confirm").attr('style', '');
      $("#enable").attr('name', true);
      $("#disable").attr('name', true);
      $("#delete").attr('name', 'delete');

    });
});
</script>