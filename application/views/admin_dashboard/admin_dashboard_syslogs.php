<div id="content">
<div class="clear"></div>
    <div style="margin-bottom:20px; padding-top:5px;overflow:auto;">
        <div class="sticky placeholder"></div><div class="sticky bar opaque" style="top: 0px;">
            <div class="content" style="width: 908px;">
                <div class="pull-left flush-left">
                    <h2><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box');" onmouseleave="MouseOut('tip_box')"></i> System Logs            </h2>
                </div>
                <div id="actions" class="pull-right flush-right">
                    <span class="red button" id="logsdelete" data-placement="bottom" data-toggle="modal" data-target="#delete" title="Delete"><i class="icon-trash"></i>
                        Delete Selected Entries         </span>
                </div>
            <a class="only sticky scroll-up" href="#" data-stop="136"><i class="icon-chevron-up icon-large"></i></a></div>
        </div>
    </div>
    <form id="reply" action="<?php echo site_url('admin_dashboard_controller/delete_syslog')?>" name="reply" method="post" enctype="multipart/form-data">
 <div style="overflow:auto;">
 <table class="list" id="ttable"  border="0" cellspacing="1" cellpadding="0" style="white-space: nowrap;">
    <thead>
        <tr>
            <th width="4%">&nbsp;</th>
            <th width="40%">Log Title</th>
            <th width="11%">Log Type</th>
            <th width="20%" nowrap="">Log Date</th>
            <th width="20%">IP Address</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($syslog->result() as $value){ ?>
            <tr>
                <td align="center" nowrap="">
                  <input type="checkbox" class="ckb" name="ids[]" value="<?php echo $value->log_guid;?>"> </td>
                <td>&nbsp;<a class="tip" href="#" data-title="<?php echo $value->title ?>" data-log="<?php echo $value->log ?>" data-toggle="modal" data-target="#show"><?php echo $value->title?></a></td>
                <td><?php echo $value->log_type?></td>
                <td><?php echo $value->created?></td>
                <td><?php echo $value->ip_address?></td>
            </tr>  
<?php } ?>
    </tbody>
</table>
</div>


<div class="modal fade" id="delete" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Delete Selected Record(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to DELETE selected record(s)?</p>

                <div style="display:block; margin:5px;">
                    <table width="100%">
                                <tbody>
                            <tr><td colspan="2"><strong><strong>Deleted record(s) CANNOT be recovered, including any associated attachments.</strong></strong></td> </tr>
                        </tbody>
                    </table>
                </div>

              </div>
              <div class="modal-footer">

                    <p class="full-width">
                      <span class="buttons pull-left">
                          <input type="button" data-dismiss="modal" value ="Close">
                      </span>
                      <span class="buttons pull-right">
                          <input type="submit" class="red button" value="Delete">
                    </select>
                    

                      </span>
                   </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
</form>
</div>

</div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="overlay" style="opacity: 0.5; display: none;"></div>
<div id="loading" style="top: 219px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 54.75px; left: 374.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>


<div class="modal fade" id="show" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle" id="log_title"></h3>
              </div>
              <div class="modal-body">
                <div style="display:block; margin:5px;">
                    <table width="100%">
                                <tbody>
                            <tr><strong><strong><td colspan="2" id="log"></strong></strong></td> </tr>
                        </tbody>
                    </table>
                </div>

              </div>
              <div class="modal-footer">

                    <p class="full-width">
                      <span class="buttons pull-left">
                          <input type="button" data-dismiss="modal" value ="Close">
                      </span>
                    </select>
                    

                      </span>
                   </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="tip_box" id="tip_box" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>System Logs</h1>This is where you will find any troubleshooting related logging activity (e.g., Errors, Warnings).
    </div>
</div>

<script>
  $(document).ready(function () {
    $('#ttable').DataTable({
      'columnDefs'  : [{ 'orderable': true, 'targets': 0 }],
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [ [1 , 'desc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: []
    })
  })

  $(document).ready(function () {
    $('#logsdelete').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one record.");
        return false;
      }
  })
});

function MouseOver(e,divid) {
    var left  = e.clientX  + "px";
    var top  = e.clientY  + "px";

    var div = document.getElementById(divid);

    div.style.display = 'block';
    div.style.left = left;
    div.style.top = top;
    $("#" + divid).stop();    
}

function MouseOut(divid) {
    document.getElementById(divid).style.display = 'none';
    $("#" + divid).stop();
}

$(document).on("click", ".tip", function () {
     var title = $(this).data('title');
     var log = $(this).data('log');
     $(".modal-header #log_title").text( title );
     $(".modal-body #log").text( log );
});

</script>