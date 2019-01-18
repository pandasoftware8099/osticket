<meta http-equiv="refresh" content="<?php echo $_SESSION['auto_refresh_rate']?>">
<div id="content" style="height: fit-content;">
        

<div class="clear"></div>
<div style="margin-bottom:20px; padding-top:5px;">
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="col-lg-12">
                <div class="pull-left">
                    <h2><a href="/helpdesk/scp/tickets.php?status=open&amp;_pjax=%23pjax-container" title="Refresh"><i class="icon-refresh"></i> <?php echo $_REQUEST['title'];?> Tickets</a></h2>
                </div>

                <?php if ($editallow != 0 ) { ?>
                <div class="pull-right">
                                
                <span class="action-button" data-toggle="modal" data-target="#cstatus" id="checkBtn" title="Change Status"><i class="icon-flag"></i></span>

                <?php if ($assignallow != 0 ) { ?>
                <span class="action-button" id="assign" data-toggle="modal"  data-target="#claim" title=" Assign"><i class="icon-user"></i></span>
                <?php } ?>

                <?php if ($transferallow != 0 ) { ?>
                <span class="action-button" id="tickets-transfer" data-placement="bottom" data-toggle="modal" data-target="#transfer" title="Transfer"><i class="icon-share"></i></span>
                <?php } ?>

                <?php if ($deleteallow != 0 ) { ?>
                <span class="red button action-button" id="tickets-delete" data-placement="bottom" data-toggle="modal" data-target="#delete" title="Delete"><i class="icon-trash"></i></span>
                <?php } ?>

                <script type="text/javascript">
                $(function() {

                    $(document).off('.tickets');
                    $(document).on('click.tickets', 'a.tickets-action', function(e) {
                        e.preventDefault();
                        var $form = $('form#tickets');
                        var count = checkbox_checker($form, 1);
                        if (count) {
                            var tids = $('.ckb:checked', $form).map(function() {
                                    return this.value;
                                }).get();
                            var url = 'ajax.php/'
                            +$(this).attr('href').substr(1)
                            +'?count='+count
                            +'&tids='+tids.join(',')
                            +'&_uid='+new Date().getTime();
                            console.log(tids);
                            $.dialog(url, [201], function (xhr) {
                                $.pjax.reload('#pjax-container');
                             });
                        }
                        return false;
                    });
                });
                </script>
                </div>
                <?php } ?>
            </div>
        <a class="only sticky scroll-up" href="#" data-stop="106"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
</div>
<div class="clear" style="padding:5px;"></div>

<form action="<?php echo site_url('staff_ticket_controller/changeticketstatus')?>" method="POST" name="tickets" id="tickets">



<div style="overflow:auto; overflow-x: hidden;">    
  <!-- <table class="table table-bordered table-hover" id="ttable"  border="0" cellspacing="0" cellpadding="0"> -->

      <form id="reply" action="<?php echo site_url('staff_ticket_controller/changeticketstatus')?>" name="reply" method="post" enctype="multipart/form-data">
  <table class="list" id="ttable"  border="0" cellspacing="0" cellpadding="0" style="white-space: nowrap;">
    <thead>
            <tr>
            
                <th style="text-align: center;" ><input type="checkbox" name="tids[]" id="tidsall" onclick="checkedAll ();"></th>
                <th >Number</th>
                <th >Last Updated</th>
                <th >Subject</th>
                <th >From</th>
                <th >Priority</th>
                <th >Assigned To</th>            

            </tr>
    </thead>
    <tbody> 


      <?php foreach ($result->result() as $value) { ?>
            <tr id="14">
              
              <td align="center" class="nohover">
                <input class="ckb" type="checkbox" name="tids[]" value="<?php echo $value->ticket_guid;?>"">
              </td>
              
              <td nowrap="">
                <a class="Icon webTicket" title="<?php echo $value->user_email;?>" href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $value->ticket_guid;?>"><?php echo $value->number;?></a>
              </td>
              
              <td align="center" nowrap=""><?php echo $value->ticket_updated;?></td>
              
              <td>
                 <a style="text-overflow: ellipsis;overflow: hidden;width: 300px;" title="<?php echo $value->user_email;?>" href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $value->ticket_guid;?>"><?php echo $value->topic;?></a>


              <?php 
                if ($this->db->query("SELECT COUNT(*) as total FROM ost_thread_entry_test WHERE ticket_guid = '".$value->ticket_guid."' AND type != 'E'")->row('total') != '0' && $this->db->query("SELECT COUNT(*) as total FROM ost_thread_entry_test WHERE ticket_guid = '".$value->ticket_guid."' AND type != 'E'")->row('total') != '1')
                { ?>

                <span class="pull-right faded-more">
                  <i class="icon-comments-alt"></i>
                    <small><?php echo $this->db->query("SELECT COUNT(*) as total FROM ost_thread_entry_test WHERE ticket_guid = '".$value->ticket_guid."' AND type != 'E'")->row('total');?></small>
                </span>
              <?php } ?>
              </td>
              
              <td nowrap=""><div><span class="truncate" style="max-width:67px"><?php echo $value->user_name;?></span></div>
              </td>
              
              <td class="nohover" align="center" style="background-color:<?php echo $value->priority_color;?>;"><?php echo $value->priority_desc;?></td>
              
              <td nowrap=""><span class="truncate" style="max-width: 113px">
                <?php 
                if ($value->team_guid == '0')
                { ?>
                  <?php echo $this->db->query("SELECT firstname FROM ost_staff_test AS a
                    INNER JOIN ost_ticket_test AS b ON b.assigned_to = a.staff_guid
                    WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('firstname');?> 
                  <?php echo $this->db->query("SELECT lastname FROM ost_staff_test AS a
                    INNER JOIN ost_ticket_test AS b ON b.assigned_to = a.staff_guid
                    WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('lastname');?>
                <?php }

                if ($value->assigned_to == '0')
                { ?>
                  <?php echo $this->db->query("SELECT name FROM ost_team_test AS a
                    INNER JOIN ost_ticket_test AS b ON b.team_guid = a.team_guid
                    WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('name');?>
                <?php } ?>
                </span>
              </td>
            </tr>
          <?php } ?>
    </tbody>

<!--         <tfoot>
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

  <!-- change ticket status popup modal -->
<div class="modal fade" id="cstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Change Selected Ticket(s) Status</h3>
              </div>
              <div class="modal-body">
                <div id="ticket-status" style="display:block; margin:5px;">
                <table width="100%">
                  <tbody>
                  <tr>
                    <td colspan="2">
                        <span>
                          <strong>Status:&nbsp;</strong>
                            <select name="status_guid" id="status_guid">
                              <option value="">— Select —</option>
                              <?php foreach ($status->result() as $status) { ?>
                              <option value="<?php echo $status->status_guid;?>"><?php echo $status->name;?></option>
                              <?php } ?> 
                            </select>
                            <font class="error">*&nbsp;</font>
                        </span>
                    </td>
                  </tr>
                  </tbody>

                  <tbody>
                  <tr>
                    <td colspan="2">
                      <br><textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for status change (internal note)" id="_e8f5989ca9fa6fe1" name="statusnote"></textarea>
                    </td>
                  </tr>
                  </tbody>
                </table>
               
                </div>
              </div>
              
              <div class="modal-footer">
                <p class="full-width">
                <span class="buttons pull-left">
                  <input type="button" data-dismiss="modal" value ="Close">
                  <input type="reset" value="Reset">
                </span>
                <span class="buttons pull-right">
                <input id="opennn" type="submit" value="Open">
                </span>
                </p>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
  </div>
  <!-- change ticket status popup modal -->

    <!-- assigned ticket  popup modal -->
<div class="modal fade" id="claim" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Assign Selected Ticket(s)</h3>
              </div>
              <div class="modal-body">

                <div style="display:block; margin:5px;">
                  <form class="mass-action" method="post" name="assign" id="assign" action="#tickets/mass/assign/agents">
                      <table width="100%">
                                  <tbody>
                              <tr><td colspan="2">
                               <div class="form-simple">
                              <div class="flush-left custom-field" id="field_da489cda559d4795">
                          <div>
                            <div class="field-label required">
                          <label for="da489cda559d4795">
                              Assignee:
                                <span class="error">*</span>
                            </label>
                          </div>
                                    </div><div>
                                  <select class="form-control" name="assignto" id="assignto" data-placeholder="Select an Agent">
                                          <option value="">— Select an Agent —</option>
                              <optgroup label="Agents (<?php echo $staff->num_rows() ?>)">
                              <?php foreach ($staff->result() as $staff) { ?>
                              <option value="a<?php echo $staff->staff_guid;?>"><?php echo $staff->firstname;?> <?php echo $staff->lastname;?></option>
                              <?php } ?> 
                              </optgroup>    
                              <optgroup label="Team (<?php echo $team->num_rows() ?>)">         
                              <?php foreach ($team->result() as $team) { ?>
                              <option value="t<?php echo $team->team_guid;?>"><?php echo $team->name;?></option>
                              <?php } ?> 
                              </optgroup>  

                                  </select>
                                  </div>
                                  </div>
                              <div class="flush-left custom-field" id="field_d8bf82dc954436ab">
                          <div>
                                    </div><div>
                                  <span style="display:inline-block;width:100%">
                          <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the assignment" id="_d8bf82dc954436ab" name="assignnote"></textarea>
                          </span>
                                  </div>
                                  </div>
                              <script type="text/javascript">
                            $(function() {
                                              $(document).off('change.assign');
                                  $(document).on('change.assign',
                                      'form#assign :input',
                                      function() {
                                          //Clear any current errors...
                                          var errors = $('#field'+$(this).attr('id')+'_error');
                                          if (errors.length)
                                              errors.slideUp('fast', function (){
                                                  $(this).remove();
                                                  });
                                          //TODO: Validation input inplace or via ajax call
                                          // and set any new errors AND visibilty changes
                                      }
                                     );
                                          });
                          </script>
                          </div>
                              </td> </tr>
                          </tbody>
                      </table>
                  </form>
                  </div>

              </div>
              <div class="modal-footer">

                <p class="full-width">
                  <span class="buttons pull-left">
                      <input type="button" data-dismiss="modal" value ="Close">
                      <input type="reset" value="Reset">
                  </span>
                  <span class="buttons pull-right">
                      <input type="submit" value="Assign">
                  </span>
                </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- assgined ticket popup modal -->

  <!-- assigned ticket to department popup modal -->
<div class="modal fade" id="transfer" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Transfer Selected Ticket(s)</h3>
              </div>
              <div class="modal-body">

                <div style="display:block; margin:5px;">

              <table width="100%">
                <tbody>
            <tr><td colspan="2">
             <div class="form-simple">
            <div class="flush-left custom-field" id="field_b7a7b14540f04e3c">
          <div>
            <div class="field-label required">
          <label for="b7a7b14540f04e3c">
              Department:
                <span class="error">*</span>
            </label>
          </div>
                  </div><div>
                <select class="form-control" name="departmentid" id="departmentid" data-placeholder="Select">
                  <option value="">— Select —</option>
                  <option value="<?php echo $default_depart->row('name');?>"><?php echo $default_depart->row('name');?></option>
                  <?php foreach ($department->result() as $ticketdept) { ?>
                    <option value="<?php echo $ticketdept->name;?>"><?php echo $ticketdept->name;?></option>
                  <?php } ?>
                </select>
                </div>
                </div>
            <div class="flush-left custom-field" id="field_e8f5989ca9fa6fe1">
          <div>
                    </div><div>
                  <span style="display:inline-block;width:100%">
          <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the transfer" id="_e8f5989ca9fa6fe1" name="transfernote"></textarea>
          </span>
                  </div>
                </div>
            <script type="text/javascript">
          $(function() {
                            $(document).off('change.transfer');
                $(document).on('change.transfer',
                    'form#transfer :input',
                    function() {
                        //Clear any current errors...
                        var errors = $('#field'+$(this).attr('id')+'_error');
                        if (errors.length)
                            errors.slideUp('fast', function (){
                                $(this).remove();
                                });
                        //TODO: Validation input inplace or via ajax call
                        // and set any new errors AND visibilty changes
                    }
                   );
                        });
            </script>
              </div>
                  </td> </tr>
              </tbody>
          </table>
          </div>
              </div>

              <div class="modal-footer">
                <p class="full-width">
                  <span class="buttons pull-left">
                      <input type="button" data-dismiss="modal" value ="Close">
                      <input type="reset" value="Reset">
                  </span>
                  <span class="buttons pull-right">
                      <input type="submit" value="Transfer">
                  </span>
               </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- assigned ticket to department popup modal -->

  <!-- delete ticket to department popup modal -->
<div class="modal fade" id="delete" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Delete Selected Ticket(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to DELETE selected ticket(s)?</p>

                <div style="display:block; margin:5px;">
                <form class="mass-action" method="post" name="delete" id="delete" action="#tickets/mass/delete">
                    <table width="100%">
                                <tbody>
                            <tr><td colspan="2"><strong><strong>Deleted ticket(s) CANNOT be recovered, including any associated attachments.</strong></strong></td> </tr>
                        </tbody>
                                <tbody>
                            <tr>
                                <td colspan="2">
                                  <br><textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for deleting selected tickets" id="_e8f5989ca9fa6fe1" name="deletenote"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                </div>

              </div>
              <div class="modal-footer">

                    <p class="full-width">
                      <span class="buttons pull-left">
                          <input type="button" data-dismiss="modal" value ="Close">
                          <input type="reset" value="Reset">
                      </span>
                      <span class="buttons pull-right">
                          <input type="submit" class="red button" value="Delete">
                    <select name="deleteticket" hidden="true" id="deleteticket">
                      <option value="5"></option>
                  


                    </select>
                    

                      </span>
                   </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- delete ticket to department popup modal -->




</form> 


</div>

</form>
</div>

<div style="display: none; top: 54.75px; left: 567.5px;" class="dialog" id="confirm-action">
    <h3>Please Confirm</h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <p class="confirm-action" style="display:none;" id="mark_overdue-confirm">
        Are you sure you want to flag the selected tickets as <font color="red"><b>overdue</b></font>?    </p>
    <div>Please confirm to continue.</div>
    <hr style="margin-top:1em">
    <p class="full-width">
        <span class="buttons pull-left">
            <input type="button" value="No, Cancel" class="close">
        </span>
        <span class="buttons pull-right">
            <input type="button" value="Yes, Do it!" class="confirm">
        </span>
     </p>
    <div class="clear"></div>
</div>
<script type="text/javascript">
$(function() {
    $('[data-toggle=tooltip]').tooltip();
});
</script>

        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">

</div>
</div>
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2018&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>


<div id="loading" style="top: 219px; left: 533px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>

<div style="display: none; top: 54.75px; left: 627px;" class="dialog" id="alert">
    <h3><i class="icon-warning-sign"></i> <span id="title"></span></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <div id="body" style="min-height: 20px;"></div>
    <hr style="margin-top:3em">
    <p class="full-width">
        <span class="buttons pull-right">
            <input type="button" value="OK" class="close ok">
        </span>
     </p>
    <div class="clear"></div>
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
      'columnDefs'  : [{ 'orderable': false, 'targets': 0 }],
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

<!-- checkbox required -->
<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', true);
      $("#departmentid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#deleteticket").attr('required', false);
      $("#status_guid").attr('name', 'status_guid');
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#deleteticket").attr('name', true);

    });

    $('#assign').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#departmentid").attr('name', true);
      $("#status_guid").attr('name', true);
      $("#assignto").attr('required', true);
      $("#assignto").attr('name', 'assignto');
      $("#deleteticket").attr('required', false);
      $("#deleteticket").attr('name', true);

    });


    $('#tickets-transfer').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', true);
      $("#deleteticket").attr('required', false);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', 'departmentid');
      $("#assignto").attr('name', true);
      $("#deleteticket").attr('name', true);

    });

    $('#tickets-delete').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#deleteticket").attr('required', true);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#deleteticket").attr('name', 'deleteticket');

    });

});

</script>

<script type="text/javascript" src="/helpdesk/js/jquery.pjax.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-typeahead.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/scp.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/filedrop.field.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/select2.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/tips.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-osticket.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-plugins.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.translatable.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.dropdown.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-tooltip.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/fabric.min.js?9ae093d"></script>
<link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/tooltip.css?9ae093d">
<script type="text/javascript">
    getConfig().resolve({"lock_time":3600,"html_thread":true,"date_format":"Y-MM-dd","lang":"en_US","short_lang":"en","has_rtl":false,"lang_flag":"us","primary_lang_flag":"us","primary_language":"en-US","secondary_languages":[],"page_size":25});
</script>


<ul class="typeahead dropdown-menu" style="display: none;"></ul></body></html>