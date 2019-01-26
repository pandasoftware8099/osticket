<div id="content">
        
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <h2>FAQ Categories</h2>
                <p>Click title to edit category</p>
            </div>
            <div class="pull-right flush-right">
                <a href="<?php echo site_url('staff_faqs_controller/categories_add')?>" class="green button">
                    <i class="icon-plus-sign"></i>
                    Add New Category                </a>
                <div class="pull-right flush-right">

                    <!-- <span id="checkbtn" class="action-button" data-toggle="modal" data-target="#delete">
                        <i class="icon-trash"></i> Delete
                    </span> -->

                </div>
            </div>
        <a class="only sticky scroll-up" href="#" data-stop="65"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
    <div class="clear"></div>

    <div style="overflow:auto;">
 
        <!-- <form id="reply" action="<?php echo site_url('staff_faqs_controller/categories_delete_process')?>" name="reply" method="post" enctype="multipart/form-data"> -->
  <table class="list" id="ttable"  border="0" cellspacing="0" cellpadding="0" style="width: 100%">
    <thead>
            <tr>
            
                <!-- <th style="text-align: center;" ><input type="checkbox" name="tids[]" id="tidsall" onclick="checkedAll ();"></th> -->
                <th >Title</th>
                <th >Type</th>
                <th >FAQs</th>
                <th >Last Updated</th>
           

            </tr>
    </thead>
    <tbody> 


      <?php foreach ($faqcate->result() as $value) { ?>
            <tr>
              
              <!-- <td align="center" class="nohover">
                <input class="ckb" type="checkbox" name="tids[]" value="<?php echo $value->category_guid;?>"">
              </td> -->
              
              <td nowrap="">

                <a href="<?php echo site_url('staff_faqs_controller/faqeditcate');?>?id=<?php echo $value->category_guid;?>"><?php echo $value->name;?></a>

              </td>
              
              <td nowrap="">
                
                <?php 

                if ( $value->ispublic == 0) {
                  echo 'private';
                }

                elseif ($value->ispublic == 1) {
                  echo 'public';
                }

                elseif ($value->ispublic == 2) {
                  echo 'featured';
                }

               ?>

              </td>
                
              <td>
                <?php

                $count = $this->db->query("SELECT COUNT(*) AS count FROM ost_faq_test WHERE category_guid = '$value->category_guid'")->row('count');
                echo $count;
                ?>

              </td>
              
              <td nowrap="">

                <?php echo $value->updated;?>

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


  <!-- delete categories faq popup modal -->
<!-- <div class="modal fade" id="delete" style="display: none;">
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
                                  <br><div class="redactor-box" role="application"><textarea name="deletenote" id="comments" cols="50" rows="3" wrap="soft" style="width: 100%; display: none;" class="richtext no-bar small" placeholder="Optional reason for deleting selected tickets" dir="ltr"></textarea></div>
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
                    <select name="delete" hidden="true" >
                      <option value="5"></option>
                  


                    </select>
                    

                      </span>
                   </p>

              </div>
            </div>
           
          </div>
         
</div> -->
  <!-- delete categories faq popup modal -->

<!-- </form>  -->

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
      'order'       : [ [0 , 'asc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<!-- checkbox required -->
<!-- <script type="text/javascript">
$(document).ready(function () {
    $('#checkbtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

    });
  }

</script> -->