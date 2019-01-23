

<div id="content">



<div style="margin-bottom:20px; padding-top:5px;">
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="col-sm-6 flush-left">
                <h2>User Directory</h2>
            </div>
            <div class="col-sm-6" style="text-align:right">
                <?php if ($adduserallow != 0 ) { ?>
                <a class="green button action-button popup-dialog" data-toggle="modal" data-target="#user-modal" href="#users/add">
                    <i class="icon-plus-sign"></i> Add User
                </a>



                <a class="action-button popup-dialog" data-toggle="modal" data-target="#import-modal" href="#users/import">
                    <i class="icon-upload"></i> Import              
                </a>

                <?php } ?>
                    <span id="checkBtn" class="action-button" data-toggle="modal" data-target="#more-modal" style="/*DELME*/ vertical-align:top; margin-bottom:0">
                    <a data-toggle="modal" data-target="#more-modal" class="tickets-action"  title="" href="#tickets/mass/transfer" data-original-title="Transfer"><i class="icon-cog"></i> More</a>
                </span>
                
            </div>

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

        <a class="only sticky scroll-up" href="#" data-stop="107"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
</div>
<div class="clear"></div>

<form action="<?php echo site_url('staff_user_controller/more')?>" method="POST" name="tickets" id="tickets">

<div style="overflow:auto; overflow-x: hidden;">  
    <form id="reply" action="<?php echo site_url('staff_user_controller/more')?>" name="reply" method="post" enctype="multipart/form-data">


    <table class="list" id="ttable" border="0" cellspacing="0" cellpadding="0" style="white-space: nowrap;">
        <thead>
            <tr>
                <th nowrap="" width="4%" style="text-align: center;"><input type="checkbox" name="tids[]" id="tidsall" onclick="checkedAll ();"></th>
                <th width="45%">Name</th>
                <th width="22%">Status</th>
                <th width="20%">Created</th>
                <th width="20%">Updated</th>
            </tr>
        </thead>
        <tbody> 

                <?php foreach ($result->result() as $value) { ?>

                    <tr>
                    <td nowrap="" align="center">
                        <input type="checkbox" value="<?php echo $value->user_guid;?>" name="tids[]" class="ckb">
                    </td>
                    <td>&nbsp;
                        <a class="preview" href="<?php echo site_url('staff_user_controller/user_info');?>?id=<?php echo $value->user_guid;?>"><?php echo $value->user_name;?></a>
                        &nbsp;
                        
                        <?php 
                        if ($this->db->query("SELECT COUNT(*) as total FROM ost_ticket_test WHERE user_guid = '".$value->user_guid."'")->row('total') != '0')
                        { ?>
                            <i class="icon-fixed-width icon-file-text-alt"></i>
                            <small>(<?php echo $this->db->query("SELECT COUNT(*) as total FROM ost_ticket_test WHERE user_guid = '".$value->user_guid."'")->row('total');?>)</small>
                        <?php } ?>
                        </td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo $value->user_created_at;?></td>
                    <td><?php echo $value->user_updated_at;?></td>
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

                <div id="deleteticket1" style="display:none;"><p id="msg_warning">Deleted users and tickets CANNOT be recovered</p></div>

                <p class="confirm-action">Choose the action you want</p>

                <select name="moreoption"  onchange="admSelectCheck(this);">\
                    <?php if ($activeallow != 0 ) { ?>
                    <option value="0">&#xf0e0; Send Password Reset Email </option>
                    <option value="1">&#xf118; Register </option>
                    <?php } ?>

                    <?php if ($edituserallow != 0 ) { ?>
                    <option value="2">&#xf023; Lock </option>
                    <option value="3">&#xf09c; Unlock </option>
                    <?php } ?>

                    <?php if ($deleteallow != 0 ) { ?>
                    <option id="delete" value="4">&#xf12a; Delete </option>
                    <?php } ?>
                </select>

                <div id="deleteticket2" style="display:none;"><br><input value="1" type="checkbox" name="deletetickets">&nbsp;Also delete all associated tickets and attachments</div>

                <br>
                    <div class="popup_selected_username" style="font-size: 15px;background-color: lightyellow;"></div>
                <br>

                <div><br><b>Press OK to confirm and continue.</b></div>

                <script type="text/javascript">
                    
                        function admSelectCheck(nameSelect)
                        {
                            if(nameSelect){
                                admOptionValue = document.getElementById("delete").value;
                                if(admOptionValue == nameSelect.value){
                                    document.getElementById("deleteticket1").style.display = "block";
                                    document.getElementById("deleteticket2").style.display = "block";
                                }
                                else{
                                    document.getElementById("deleteticket1").style.display = "none";
                                    document.getElementById("deleteticket2").style.display = "none";
                                }
                            }
                            else{
                                document.getElementById("deleteticket1").style.display = "none";
                                document.getElementById("deleteticket2").style.display = "none";
                            }
                        }


                </script>


              </div>

                <div class="modal-footer">
 
                    <p class="full-width">
                        <span class="buttons pull-left">
                            <input type="button" class="close" value="Cancel">
                        </span>
                        <span class="buttons pull-right">
                            <input type="submit" value="OK">
                        </span>
                    </p>
                </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- more popup modal -->

</form> 

</div>

</form>

</div> 


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
</div>



<!-- Add user popup modal -->
<div class="modal fade" id="user-modal" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Lookup or create a user</h3>
              </div>
              <div class="modal-body">
                    <div id="selected-user-info" style="display:none;margin:5px;">
                        <form method="post" class="user" action="#users/lookup">
                            <input type="hidden" id="user-id" name="id" value="0">
                            <i class="icon-user icon-4x pull-left icon-border"></i>
                            <a class="action-button pull-right" style="overflow:inherit" id="unselect-user" href="#"><i class="icon-remove"></i>
                                Add New User</a>
                            <div class="clear"></div>
                            <hr>
                            <p class="full-width">
                                <span class="buttons pull-left">
                                    <input type="button" name="cancel" class="close" value="Cancel">
                                </span>
                                <span class="buttons pull-right">
                                    <input type="submit" value="Continue">
                                </span>
                             </p>
                        </form>
                    </div>

                    <div id="new-user-form" style="display:block;">
                        <form action="<?php echo site_url('staff_user_controller/createuser');?>?>&direct=user" method="post" class="user">
                            <div class="col-lg-12">
                            <div class="section-break">
                                <em> <strong>Create New User</strong>:         </em>
                            </div>
                            </div>
            <div>
                            <!--<td class="multi-line required" style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Email Address                             <span class="error">*</span>
                         :
                    </label>
                    <div class="col-lg-9">        <input type="email" class="form-control" id="_9cecd7ca5fcc96b6" size="40" maxlength="64" placeholder="" name="email" value="" required="true">
                    </div>
                </div>
                            <!--<td class="multi-line required" style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Full Name                             <span class="error">*</span>
                         :
                    </label>
                    <div class="col-lg-9">        <input type="text" class="form-control" id="_343f482466a3d4f1" size="40" maxlength="64" placeholder="" name="fullname" value="" required="true">
                    </div>
                </div>
                            <!--<td class="multi-line " style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Phone Numbers  :
                    </label>
                    <div class="col-lg-9">        <input id="_459bd8d15e4ee311" type="tel" name="phone" value=""> Ext:
            <input type="text" name="phoneext" value="" size="5">
                    </div>
                </div>

                <?php if ($_SESSION['staffdept'] == '1') { ?>

                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Department  :
                    </label>
                    <div class="col-lg-9">        


                    <select name="dept" >
                        <?php foreach ($department->result() as $value) { ?>
                        <option value="<?php echo $value->department_guid?>"><?php echo $value->name?></option>
                        <?php } ?>

                    </select>


                    </div>
                </div>

                <?php } ?>


                            <!--<td class="multi-line " style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Internal Notes  :
                    </label>
                    <div class="col-lg-9">       
                         <span style="display:inline-block;width:100%">
                        <textarea class="form-control" rows="4" cols="40" placeholder="" id="_2f9131add31b7f7d" name="note"></textarea>
                        </span>
                    </div>
                </div>
            </div>
                <table width="100%" class="fixed"></table>
              <br><div class="modal-footer">
 
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Close">
                        <input type="reset" value="Reset">
                        
                    </span>

                    <span class="buttons pull-right">
                        <input type="submit" value="Add User">
                    </span>
                </p>
              </div>

                </form>
                </div>

                
              </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- Add user popup modal -->


<!-- Import user popup modal -->
<div class="modal fade" id="import-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3 class="drag-handle">Import Users</h3>
            </div>
            <div class="modal-body">

                <div class="tab_1">
                    <ul class="tabs_1" id="user-import-tabs">
                        <li class="active"><a href="#copy-paste"><i class="icon-edit"></i>&nbsp;Copy Paste</a></li>
                        <li><a href="#upload"><i class="icon-fixed-width icon-cloud-upload"></i>&nbsp;Upload</a></li>
                        </ul>
                </div>

                
                <div id="user-import-tabs_container">
                 <form method="post" action="<?php echo site_url('staff_user_controller/importcopy?direct=user')?>" enctype="multipart/form-data">
                <div class="tab_content_1" id="copy-paste" style="margin:5px;">
                <h2 style="margin-bottom:10px">Name and Email</h2>
                <p>Enter one name, email address and phone number per line.<br><em>To import more other fields, use the Upload tab.</em>
                </p>
                 <?php if ($_SESSION['staffdept'] == '1') { ?>

                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Department  :
                    </label>

                    <select name="dept" >
                        <?php foreach ($department->result() as $value) { ?>
                        <option value="<?php echo $value->department_guid?>"><?php echo $value->name?></option>
                        <?php } ?>

                    </select>

                </div>

                <?php } ?>
                <textarea name="pasted" style="display:block;width:100%;height:8em" placeholder="e.g. John Doe, john.doe@osticket.com, 012-3456789"></textarea>

               
                    
                    <br>
                    <div class="modal-footer">
     
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="button" data-dismiss="modal" value ="Close">
                                <input type="reset" value="Reset">
                                
                            </span>

                            <span class="buttons pull-right">
                                
                                
                                <input type="submit" name="submit_file" value="Submit"/>
                    
                            </span>
                        </p>
                    </div>
                
                </div>
                </form>

                <div class="hiddens tab_content_1" id="upload" style="margin:5px;">
                <h2 style="margin-bottom:10px">Import a CSV File</h2>
                <p>
                <em>Use the columns shown in the table below. To add more fields, visit the Admin Panel -&gt; Manage -&gt; Forms -&gt; Contact Information page to edit the available fields.  Only fields with `variable` defined can be imported.</em></p><em>
                <table class="list" style="border: 1px solid black">
                <tbody>
                    <tr>
                        <th style="border: 1px solid black;padding: 5px;">Name</th>
                        <th style="border: 1px solid black;padding: 5px;">Email</th>
                        <th style="border: 1px solid black;padding: 5px;">Phone</th>
                        <th style="border: 1px solid black;padding: 5px;">Notes</th>
                    </tr>

                    <tr>
                        <td style="border: 1px solid black">John Doe</td>
                        <td style="border: 1px solid black">john.doe@osticket.com</td>
                        <td style="border: 1px solid black">012-3456789</td>
                        <td style="border: 1px solid black">Notes</td>
                    </tr>
                </tbody>
                </table>
                
                <br>
                <form method="post" action="<?php echo site_url('staff_user_controller/importcsv?direct=user')?>" enctype="multipart/form-data">
                    <?php if ($_SESSION['staffdept'] == '1') { ?>

                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Department  :
                    </label>
    


                    <select name="dept" >
                        <?php foreach ($department->result() as $value) { ?>
                        <option value="<?php echo $value->department_guid?>"><?php echo $value->name?></option>
                        <?php } ?>

                    </select>


                </div>

                <?php } ?>
                    <input type="file" name="file" required="true">
                    <br>
                    <div class="modal-footer">
     
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="button" data-dismiss="modal" value ="Close">
                                <input type="reset" value="Reset">
                                
                            </span>

                            <span class="buttons pull-right">
                                
                                
                                <input type="submit" name="submit_file" value="Submit"/>
                    
                            </span>
                        </p>
                    </div>
                </form>

                <div id="wrapper">
                 
                  
                 
                </div>




                </em></div><em>
                </em></div><em>


                </em>
                



            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- Import user popup modal -->

<div id="loading" style="top: 219px; left: 533px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 54.75px; left: 383px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
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
    "columnDefs": [{ "orderable": false, "targets": 0 }],
    'paging'      : true,
    'pageLength'  : <?php echo $max_page_size;?>,
    'searching'   : true,
    'ordering'    : true,
    'order'       : [ [3 , 'desc'] ],
    'info'        : true,
    'autoWidth'   : true,
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

    });

    

});

</script>

<script type="text/javascript">
  
                  $(".action-button").click(function(){

                  var check = [];

                  $.each($(".ckb:checked"), function(){        

                  check.push($(this).val());

                  /*+ check.join(", ")*/
                  });
                       

                        $.ajax({
                          url : "<?php echo site_url('staff_user_controller/selected_users_ajax?user_guid_string='); ?>" + check,
                          success : function(result){
                            
                          result = JSON.parse(result);

                          html = "";
                          a = 1;
                          for(i = 0; i < result.length; i++)
                          {
                            //console.log(result[i].invoice_number);
                            
                            html += "<span style='margin: 2px;'><b> "+a+")"+ result[i] +"</b></span>";
                            

                            a++
                          }

                          $('.popup_selected_username').html(html);
                          }
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


<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div><ul class="typeahead dropdown-menu"></ul></body></html>