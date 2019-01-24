<div id="content">
        
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <h2>Canned Responses</h2>
            </div>
            <div class="pull-right flush-right">
            <a href="<?php echo site_url('staff_faqs_controller/canned_response_add');?>" class="green button"><i class="icon-plus-sign"></i> Add New Response</a>

            <span class="action-button" data-dropdown="#action-dropdown-more" style="/*DELME*/ vertical-align:top; margin-bottom:0">
                    <i class="icon-caret-down pull-right"></i>
                    <span><i class="icon-cog"></i> More</span>
            </span>
            <div id="action-dropdown-more" class="action-dropdown anchor-right" style="display: none;">
                    <ul>
                        <li>
                            <a id="enable" class="confirm" data-form-id="mass-actions" data-name="enable"  data-toggle="modal" data-target="#more-modal">
                                <i class="icon-ok-sign icon-fixed-width"></i>
                                Enable                            </a>
                        </li>
                        <li>
                            <a id="disable" class="confirm" data-form-id="mass-actions" data-name="disable"  data-toggle="modal" data-target="#more-modal">
                                <i class="icon-ban-circle icon-fixed-width"></i>
                                Disable                            </a>
                        </li>

                        <li id="delete" class="danger">
                            <a class="confirm" data-form-id="mass-actions" data-name="delete"  data-toggle="modal" data-target="#more-modal">
                                <i class="icon-trash icon-fixed-width"></i>
                                Delete                            </a>
                        </li>
                    </ul>
                </div>
        </div>
        <a class="only sticky scroll-up" href="#" data-stop="65"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
    <div class="clear"></div>

    <div style="overflow:auto;">
 
        <form id="reply" action="<?php echo site_url('staff_faqs_controller/canned_response_process')?>" name="reply" method="post" enctype="multipart/form-data">
  <table class="list" id="ttable"  border="0" cellspacing="0" cellpadding="0" style="width: 100%">
    <thead>
            <tr>
            
                <th style="text-align: center;" ><input type="checkbox" id="tidsall" onclick="checkedAll ();"></th>
                <th >Title</th>
                <th >Status</th>
                <th >Department</th>
            </tr>
    </thead>
    <tbody> 


      <?php foreach ($faqcanned->result() as $value) { ?>
            <tr>
              
              <td align="center" class="nohover">
                <input class="ckb" type="checkbox" id="tids" name="tids[]" value="<?php echo $value->canned_id;?>"">
              </td>
              
              <td nowrap="">

                <a href="<?php echo site_url('staff_faqs_controller/canned_response_info');?>?id=<?php echo $value->canned_id;?>"><?php echo $value->title;?></a>

              </td>
              
              <td nowrap="">
                
                <?php 

                if ( $value->isenabled == 1) {
                  echo 'Active';
                }

                elseif ($value->isenabled == 0) {
                  echo 'Inactive';
                }


               ?>

              </td>
              
              <td nowrap="">
                <?php if( $value->dept_id == 0 ) { 

                  echo '— All Departments —';

                 } 

                 else{
                   echo $value->name;
                 }?>

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

                <center>
                <p id="enable-confirm">You sure you want to enable selected canned response?</p>
                <p id="disable-confirm">You sure you want to disable selected canned response?</p>
                <p id="delete-confirm">You sure you want to Delete selected canned response?<br>
                  <small>Deleted canned response cannot be retrieve. </small></p>
                </center>

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


<div style="display: none; top: 31px; left: 559px;" class="dialog" id="confirm-action">
    <h3>Please Confirm</h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <p class="confirm-action" style="display:none;" id="make_public-confirm">
        Are you sure you want to make selected categories <b>public</b>?    </p>
    <p class="confirm-action" style="display:none;" id="make_private-confirm">
        Are you sure you want to make selected categories <b>private</b> (internal)?    </p>
    <p class="confirm-action" style="display:none;" id="delete-confirm">
        <font color="red"><strong>Are you sure you want to DELETE selected categories?</strong></font>
        <br><br>Deleted data CANNOT be recovered, including any associated FAQs.    </p>
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
</div>

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

<!-- checkbox required -->
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