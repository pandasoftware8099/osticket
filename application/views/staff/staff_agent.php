<div id="content">
        

<div class="clear"></div>
<div style="margin-bottom:20px; padding-top:5px;overflow:auto;">
    <div class="pull-left flush-left">
        <h2><i class="help-tip icon-question-sign" href="#staff_members"></i> Agents        </h2>
    </div>
</div>

<div style="overflow:auto; overflow-x: hidden;">    
    <table width="100%" class="list" id="ttable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr >
            <th >Name</th>
            <th >Department</th>
            <th >Email Address</th>
            <th >Phone Number</th>
            <th >Extension</th>
            <th >Mobile Number</th>
            </tr>
        </thead>
        <tbody> 
                <?php foreach ($result->result() as $value) { ?>

                    <tr id="23">

                <td><?php echo $value->firstname;?> <?php echo $value->lastname;?> <?php if ($value->onvacation == 1) { ?> <small>(<i>Vacation</i>)</small> <?php } ?></td>
                <td><?php echo $value->name;?></td>
                <td><?php echo $value->email;?></td>
                <td><?php echo $value->phone;?></td>
                <td><?php echo $value->phone_ext;?></td>
                <td><?php echo $value->mobile;?></td>

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
</div>


</div>
</div>

<script>
  $(document).ready(function () {    
    $('#ttable').DataTable({
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