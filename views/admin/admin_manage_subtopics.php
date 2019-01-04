<div id="content">
        <form action="<?php echo site_url('admin_manage_controller/manage_subtopics_process')?>" method="POST" name="lists">

<div class="sticky placeholder"></div><div class="sticky bar opaque">
    <div class="content" style="width: 908px;">
        <div class="pull-left flush-left">
            <h2>Sub Topics</h2>
        </div>
        <div class="pull-right flush-right">
            <a href="<?php echo site_url('admin_manage_controller/manage_subtopics_add')?>" class="green button action-button"><i class="icon-plus-sign"></i> Add New Sub Topics</a>

            <span class="action-button" data-dropdown="#action-dropdown-more">
                    <i class="icon-caret-down pull-right"></i>
                    <span><i class="icon-cog"></i> More</span>
            </span>
            <div id="action-dropdown-more" class="action-dropdown anchor-right" style="display: none;">
                <ul>
                    <li class="danger">
                            <a id="delete" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=delete">
                                <i class="icon-trash icon-fixed-width"></i>
                                Delete                            </a>
                    </li>
                </ul>
            </div>
        </div>
    <a class="only sticky scroll-up" href="#" data-stop="93"><i class="icon-chevron-up icon-large"></i></a></div>
</div>
<div class="clear"></div>

<div style="overflow:auto;">
<table id="ttable" class="list" border="0" cellspacing="1" cellpadding="0" width="100%" style="    white-space: nowrap;">
    <thead>
        <tr>
            <th width="4%">&nbsp;</th>
            <th width="32%">List Name</th>
            <th width="32%">Created</th>
            <th width="32%">Last Updated</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listitem->result() as $value) { ?>
            <tr>
            <td align="center">
                <input width="7" type="checkbox" class="ckb" name="tids[]" value="<?php echo $value->id ?>">
            </td>
            <td><a href="<?php echo site_url('admin_manage_controller/manage_subtopics_info')?>?id=<?php echo $value->id ?>"><?php echo $value->value ?></a></td>
            <td><?php echo $value->created ?></td>
            <td><?php echo $value->updated ?></td>
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


              <p class="confirm-action" id="delete-confirm">
                <font color="red"><strong>Are you sure you want to DELETE selected API keys?</strong></font>
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
          <input type="hidden" name="status" value="2">
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
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

    });

    

});

</script>