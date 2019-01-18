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

                <td><?php echo $value->firstname;?> <?php echo $value->lastname;?></td>
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
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2018&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="overlay"></div>
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



</body></html>