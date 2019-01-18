<div id="content">

        <form action="<?php echo site_url('admin_agents_controller/agents_departments_process')?>" method="POST" name="roles">
<div class="sticky placeholder"></div><div class="sticky bar">
    <div class="content" style="width: 908px;">
        <div class="pull-left">
            <h2><i class="help-tip icon-question-sign notsticky" href="#teams"></i> Department            </h2>
        </div>
        <div class="pull-right flush-right">
            <a href="<?php echo site_url('admin_agents_controller/agents_departments_add')?>" class="green button action-button"><i class="icon-plus-sign"></i> Add New Department</a>
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
        <div class="clear"></div>
    <a class="only sticky scroll-up" href="#" data-stop="135"><i class="icon-chevron-up icon-large"></i></a></div>
</div>
 <input type="hidden" name="__CSRFToken__" value="38085840b2360c7feb275921f1bf8b02c276d728"> <input type="hidden" name="do" value="mass_process">
 <input type="hidden" id="action" name="a" value="">
 <div style="overflow:auto;">

<table id="ttable" class="list" border="0" cellspacing="1" cellpadding="0" width="100%" style="    white-space: nowrap;">

    <thead>

        <tr>
            <th nowrap="" width="4%" style="text-align: center;"><input type="checkbox" id="tidsall" onclick="checkedAll ();"></th>
            <th style="padding-left:4px;vertical-align:middle" width="28%">Name</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Type</th>
          
            <th style="padding-left:4px;vertical-align:middle" width="8%">Agents</th>
            <th style="padding-left:4px;vertical-align:middle" width="30%">Email Address</th>
            <th style="padding-left:4px;vertical-align:middle" width="22%">Manager</th>
        </tr>
    </thead>
    <tbody>     <?php foreach ($department->result() as $value) { ?>
                <tr>
                <td align="center">
                  <input id="tids" type="checkbox" class="ckb" name="tids[]" value="<?php echo $value->department_guid?>"> </td>
                <?php foreach ($depart_name as $name) { ?>
                <?php if ($value->department_guid == $name['depart_id']) { ?>
                <td><a href="<?php echo site_url('admin_agents_controller/agents_departments_info')?>?id=<?php echo $name['depart_id']?>"><?php echo $name['depart_name']?></a> &nbsp;</td>
                <?php } ?>
                <?php } ?>
                <td>&nbsp;<?php if ($value->ispublic == 1){ ?>

                      Public

                      <?php } else if ($value->ispublic == 0) { ?>

                      Private

                      <?php } ?></td>
                
                <td>&nbsp;&nbsp;
                    <b>
                    <a href="staff.php?did=2"><?php echo $this->db->query("SELECT COUNT(*) as total FROM ost_staff_test WHERE dept_guid = '".$value->department_guid."'")->row('total');?></a>
                    </b>
                </td>
                <td>
                  <span class="ltr">
                  <a href="emails.php?id=<?php echo $value->email_guid?>"><?php echo $value->emailname?> <br> <?php echo $value->email?></a></span>
                </td>
                <td><a href="<?php echo site_url('admin_agents_controller/agents_agents_info');?>?id=<?php echo $value->staff_guid?>"><?php echo $value->firstname?>&nbsp;<?php echo $value->lastname?></a></td>
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
                Are you sure you want to <b>enable</b> selected department(s)?     </p>

              <p class="confirm-action" style="display: none;" id="disable-confirm">
                Are you sure you want to <b>disable</b> selected department(s)?    </p>

              <p class="confirm-action" style="display: none;" id="delete-confirm">
                <font color="red"><strong>Are you sure you want to DELETE selected department(s)??</strong></font>
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
