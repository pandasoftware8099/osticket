<div id="content">
                    
        <form action="<?php echo site_url('admin_manage_controller/manage_api_process')?>" method="POST" name="keys">
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <h2>API Keys</h2>
            </div>
            <div class="pull-right">
                <a href="<?php echo site_url('admin_manage_controller/manage_api_add');?>" class="green button action-button"><i class="icon-plus-sign"></i> Add New API Key</a>
                <span class="action-button" data-dropdown="#action-dropdown-more">
                            <i class="icon-caret-down pull-right"></i>
                            <span><i class="icon-cog"></i> More</span>
                </span>
                <div id="action-dropdown-more" class="action-dropdown anchor-right" style="display: none;">
                    <ul>
                        <li>
                            <a id="enable" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=enable">
                                <i class="icon-ok-sign icon-fixed-width"></i>
                                Enable                            </a>
                        </li>
                        <li>
                            <a id="disable" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=disable">
                                <i class="icon-ban-circle icon-fixed-width"></i>
                                Disable                            </a>
                        </li>
                        <li class="danger">
                            <a id="delete" class="confirm" data-toggle="modal" data-target="#more-modal" href="#?title=delete">
                                <i class="icon-trash icon-fixed-width"></i>
                                Delete                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        <a class="only sticky scroll-up" href="#" data-stop="135"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
    <div class="clear"></div>
 <input type="hidden" name="__CSRFToken__" value="46af836b78c53ca6877eb7bf5b8a4eb1bfd6b7d2"> <input type="hidden" name="do" value="mass_process">
<input type="hidden" id="action" name="a" value="">
<div style="overflow:auto;">
 <table id="ttable" class="list" border="0" cellspacing="1" cellpadding="0" width="100%" style="    white-space: nowrap;">

    <thead>
<tr><td colspan="7">

</td></tr>
        <tr>
            <th nowrap="" width="4%" style="text-align: center;"><input type="checkbox" id="tidsall" onclick="checkedAll ();"></th>
            <th style="padding-left:4px;vertical-align:middle" width="36%">API Key</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">IP Address</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%" nowrap="">Status</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Date Added</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Last Updated</th>
        </tr>
    </thead>
    <tbody class="" data-sort="sort-">
      <?php foreach ($api->result() as $value) { ?>
                <tr>
                  <td align="center">
                    <input type="checkbox" class="ckb" name="tids[]" value="<?php echo $value->api_key_id;?>">
                  </td>
                  <td>
                  <a href="<?php echo site_url('admin_manage_controller/manage_api_info');?>?id=<?php echo $value->api_key_id;?>"><?php echo $value->apikey;?></a>&nbsp;
                  </td>
                  <td>
                  <?php echo $value->ipaddr;?>
                  </td>
                  <td>
                    <?php if ($value->isactive == 1){ ?>

                      Active

                      <?php } else if ($value->isactive == 0) { ?>

                      Disabled

                      <?php } ?>
                          
                  </td>
                  
                
                  <td><?php echo $value->created;?></td>
                  <td><?php echo $value->updated;?></td>
                </tr>
      <?php } ?>
                </tbody><!-- <tfoot>
     <tr>
        <td colspan="7">
                        Select:&nbsp;
            <a id="selectAll" href="#ckb">All</a>&nbsp;&nbsp;
            <a id="selectNone" href="#ckb">None</a>&nbsp;&nbsp;
            <a id="selectToggle" href="#ckb">Toggle</a>&nbsp;&nbsp;
                    </td>
     </tr>
    </tfoot> -->
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
                Are you sure you want to <b>enable</b> selected API keys?    </p>

              <p class="confirm-action" style="display: none;" id="disable-confirm">
                Are you sure you want to <b>disable</b> selected API keys?    </p>

              <p class="confirm-action" style="display: none;" id="delete-confirm">
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
    $('#enable').click(function() {
      checked = $("input[type=checkbox]:checked").length;

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
      checked = $("input[type=checkbox]:checked").length;

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
      checked = $("input[type=checkbox]:checked").length;

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
