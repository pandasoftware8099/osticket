<div id="content">
<div style="margin-bottom:20px; padding-top:5px;">
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <h2>Emails</h2>
            </div>
            <div class="pull-right">
                <a class="button action-button" href="<?php echo site_url('admin_emails_controller/emails_emails_add')?>">
                <i class="icon-plus-sign"></i>
                Add New Email</a>
                <a class="button action-button" data-form-id="mass-actions" data-name="delete"  data-toggle="modal" data-target="#more-modal" id="delete"><i class="icon-trash icon-fixed-width"></i>
                Delete</a>
            </div>
            </div>

    </div>
</div>
<div class="clear"></div>

<form id="mass-actions" action="<?php echo site_url('admin_emails_controller/emails_emails_process')?>" method="POST" name="staff">

 <input type="hidden" id="action" name="a" value="">
 <div style="overflow:auto;">
<table id="ttable" class="list" border="0" cellspacing="1" cellpadding="0" width="100%" style="    white-space: nowrap;">
    <thead>

        <tr>
            <th nowrap="" width="4%" style="text-align: center;"><input type="checkbox" id="tidsall" onclick="checkedAll ();"></th>
            <th style="padding-left:4px;vertical-align:middle" width="40%">Email</th>
            <th style="padding-left:4px;vertical-align:middle" width="10%">Priority</th>
            <th style="padding-left:4px;vertical-align:middle" width="20%">Department</th>
            <th style="padding-left:4px;vertical-align:middle" width="10%">Created</th>
            <th style="padding-left:4px;vertical-align:middle" width="10%">Last Login</th>
        </tr>
    </thead>
     <tbody class="" data-sort="sort-">
      <?php foreach ($email->result() as $value) { ?>
                <tr>
                  <td align="center">
                    <input id="tids" type="checkbox" class="ckb" name="tids[]" value="<?php echo $value->email_id;?>">
                  </td>
                  <td>
                  <a href="<?php echo site_url('admin_emails_controller/emails_emails_info');?>?id=<?php echo $value->email_id;?>"><?php echo $value->name;?> (<?php echo $value->email;?>)</a>
                  </td>
                  <td>
                  <?php echo $value->priority_desc;?>
                  </td>
                  <td><?php echo $value->dept_name;?></td>
                  <td><?php echo $value->created;?></td>
                  <td><?php echo $value->updated;?></td>
                </tr>
      <?php } ?>
                </tbody>
                <tfoot>
    </tfoot>
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
              <p class="confirm-action" style="display: none;" id="delete-confirm">
                <font color="red"><strong>Are you sure you want to DELETE selected email(s)?</strong></font>
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



     <script type="text/javascript">
  
var checked=false;
function checkedAll () {
    var aa =  document.getElementsByName("tids[]");
    checked = document.getElementById('tidsall').checked;
     
    for (var i =0; i < aa.length; i++) 
    {
        aa[i].checked = checked;
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
    $('#delete').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one email.");
        return false;
      }
      document.getElementById("delete-confirm").style.display = "block";
      $('#more-modal').find("[name=status]").val(2);

    });
});

</script>
   