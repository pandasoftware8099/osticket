<style type="text/css">
    
select {
  font-family: 'FontAwesome', 'Second Font name'
}

</style>

<div id="content">

<div style="margin-bottom:20px; padding-top:5px;">
    <div class="sticky placeholder"></div>
    <div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <h2>Organizations</h2>
            </div>
            <div class="pull-right">

                <?php if ($creteorgallow != 0 ) { ?>
                <a class="green button action-button add-org" data-toggle="modal" data-target="#organization-modal" href="#organization/add">
                    <i class="icon-plus-sign"></i>
                    Add Organization</a>
                <?php } ?>

                <?php if ($deleteorgallow != 0 ) { ?>
                <span id="checkBtn" class="action-button" data-toggle="modal" data-target="#delete-modal" style="/*DELME*/ vertical-align:top; margin-bottom:0">
                    <span><i class="icon-trash icon-fixed-width"></i>
                        Delete</span>
                </span>
                <?php } ?>

            </div>
            <a class="only sticky scroll-up" href="#" data-stop="107"><i class="icon-chevron-up icon-large"></i></a>
        </div>
    </div>
</div>

<div class="clear"></div>

<form id="orgs-list" action="<?php echo site_url('staff_user_controller/moreorg')?>" method="POST" name="staff">
<div style="overflow:auto; overflow-x: hidden;">    

    <table class="list" id="ttable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
            <th style="text-align: center;" nowrap="" width="4%"><input type="checkbox" name="tids[]" id="tidsall" onclick="checkedAll ();"></th>
            <th width="45%">Name</th>
            <th width="11%">Users</th>
            <th width="20%">Created</th>
            <th width="20%">Last Updated</th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach ($organization->result() as $org) { ?>

            <tr id="23">
                <td nowrap="" align="center">
                    <input type="checkbox" name="tids[]" value="<?php echo $org->organization_guid;?>" class="ckb mass nowarn">
                </td>
                <td>&nbsp;<a href="<?php echo site_url('staff_user_controller/org_info');?>?id=<?php echo $org->organization_guid;?>"><?php echo $org->name;?></a></td>
                <td>&nbsp;<?php echo $this->db->query("SELECT COUNT(*) as totalusers FROM ost_user_test WHERE user_org_guid = '".$org->organization_guid."'")->row('totalusers');?></td>
                <td>&nbsp;<?php echo $org->created;?></td>
                <td>&nbsp;<?php echo $org->updated;?></td>
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
<div class="modal fade" id="delete-modal" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                    <h3>Delete Selected Organization(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Deleted organization(s) CANNOT be recovered</p>
                <input type="hidden" id="delete" name="moreoption" value="4">
                <div><b>Press OK to confirm and continue.</b></div>

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


</div>
</form>

<script type="text/javascript">
$(function() {
    $('input#basic-org-search').typeahead({
        source: function (typeahead, query) {
            $.ajax({
                url: "ajax.php/orgs/search?q="+query,
                dataType: 'json',
                success: function (data) {
                    typeahead.process(data);
                }
            });
        },
        onselect: function (obj) {
            window.location.href = 'orgs.php?id='+obj.id;
        },
        property: "/bin/true"
    });

    $(document).on('click', 'a.add-org', function(e) {
        e.preventDefault();
        $.orgLookup('ajax.php/orgs/add', function (org) {
            var url = 'orgs.php?id=' + org.id;
            $.pjax({url: url, container: '#pjax-container'})
         });

        return false;
     });

    var goBaby = function(action) {
        var ids = [],
            $form = $('form#orgs-list');
        $(':checkbox.mass:checked', $form).each(function() {
            ids.push($(this).val());
        });
        if (ids.length) {
          var submit = function() {
            $form.find('#action').val(action);
            $.each(ids, function() { $form.append($('<input type="hidden" name="ids[]">').val(this)); });
            $form.find('#selected-count').val(ids.length);
            $form.submit();
          };
          $.confirm(__('You sure?')).then(submit);
        }
        else if (!ids.length) {
            $.sysAlert(__('Oops'),
                __('You need to select at least one item'));
        }
    };
    $(document).on('click', 'a.orgs-action', function(e) {
        e.preventDefault();
        goBaby($(this).attr('href').substr(1));
        return false;
    });
});
</script>
</div>



<!-- Add organization popup modal -->
<div class="modal fade" id="organization-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Add New Organization</h3>
            </div>

            <div class="modal-body">
                <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Complete the form below to add a new organization.</p></div>
                    <div id="selected-org-info" style="display:none;margin:5px;">
                        <form method="post" class="org" action="#orgs/lookup">
                            <input type="hidden" id="org-id" name="orgid" value="0">
                            <i class="icon-group icon-4x pull-left icon-border"></i>
                            <a class="action-button pull-right" style="overflow:inherit" id="unselect-org" href="#"><i class="icon-remove"></i>
                                Add New Organization</a>
                            <div><strong id="org-name"></strong></div>
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

                <div id="new-org-form" style="display:block;">
                    <form method="post" class="org" action="<?php echo site_url('staff_user_controller/createorg');?>">
                        <div class="col-lg-12">
                            <div class="section-break">
                                <em><strong>Create New Organization</strong>: Details on user organization</em>
                            </div>
                        </div>

                        <div>
                            <!--<td class="multi-line required" style="min-width:120px;" >-->
                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Name<span class="error">*</span>:</label>
                    
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="_01d47d7d6840c41a" size="40" maxlength="64" placeholder="" name="orgname" value="">
                                </div>
                            </div>

                            <!--<td class="multi-line " style="min-width:120px;" >-->
                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Address  :</label>
                    
                                <div class="col-lg-9">
                                    <span style="display:inline-block;width:100%">
                                        <textarea class="form-control" rows="2" cols="40" maxlength="100" placeholder="" id="_ba9c5ac7bb13afbb" name="orgadd"></textarea></span>
                                </div>
                            </div>

                            <!--<td class="multi-line " style="min-width:120px;" >-->
                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Phone  :</label>

                                <div class="col-lg-9">
                                    <input id="_2e7f428d9bad2227" type="tel" name="orgphone" value="">

                                    Ext:
                                    <input type="text" name="orgphoneext" value="" size="5">
                                </div>
                            </div>

                            <!--<td class="multi-line " style="min-width:120px;" >-->
                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Website  :</label>

                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="_68d3bb3f53883efc" size="40" placeholder="" name="orgweb" value="">
                                </div>
                            </div>

                            <!--<td class="multi-line " style="min-width:120px;" >-->
                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Internal Notes  :</label>
                                
                                <div class="col-lg-9">
                                    <span style="display:inline-block;width:100%">
                                        <textarea class="form-control" rows="4" cols="40" placeholder="" id="_152a648b0b5fda71" name="orgnotes"></textarea></span>
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
                                    <input type="submit" value="Add Organization">
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
