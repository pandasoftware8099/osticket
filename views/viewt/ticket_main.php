
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
<style type="text/css">
    
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 5px;
}

#container
{

max-width: fit-content;

}

#ttable
{

    width: inherit !important;

}


</style>

<div id="content">

         <div class="search well" style="overflow: auto;">
<div class="flush-left" style="overflow: auto;">
<form action="<?php echo site_url('ticket_controller/searchticket')?>" method="POST" id="ticketSearchForm">
    <div class="col-lg-5" style="padding-top:5px;">
        Ticket Number:
        <input placeholder="Insert Ticket Number" type="text" name="keywords" size="22" value="">
    </div>
    <div class="col-lg-5" style="padding-top:5px;">
        <div>
            Help Topic:
            <select name="searchtopic" class="nowarn" style="width:70%">
                <option value="">— All Help Topics —</option>
                <?php foreach ($helptopic->result() as $helptopic) { ?>
                    <option value="<?php echo $helptopic->topic_guid?>"><?php echo $helptopic->topic?></option>
                <?php } ?> 
                </select>
        </div>
    </div>
    <div class="col-sm-2"><input type="submit" value="Search"></div>
</form>
</div>


</div>

<h1 style="margin:10px 0; overflow:auto;">
    <a href="<?php echo site_url('ticket_controller/main')?>"><i class="refresh icon-refresh"></i>
    Tickets    </a>

<div class="pull-right states">
    <small>

    <i class="icon-file-alt"></i>    
    <a class="state" href="<?php echo site_url('ticket_controller/main')?>">

    Opened (<?php echo $open_count->num_rows();?>)    </a>
        &nbsp;
    <span style="color:lightgray">|</span>
        &nbsp;

    <i class="icon-file-text"></i>
    <a class="state " href="<?php echo site_url('ticket_controller/closed')?>">
    Closed (<?php echo $closed_count->num_rows();?>)    </a>
<!--         &nbsp;
    <span style="color:lightgray">|</span>
        &nbsp;
    Result (<?php echo $result->num_rows();?>)  -->
    </small>
</div>

</h1>
<div style="overflow:auto; overflow-x: hidden;">    
<table class="table table-bordered table-hover" id="ttable" width="800" border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th nowrap="">Ticket #</th>
            <th width="120">Create Date</th>
            <th width="100">Status</th>
            <th width="320">Help Topic</th>
            <th width="120">Department</th>
        </tr>
    </thead>
    <tbody> 
                <?php foreach ($result->result() as $value) { ?>
                <tr id="12">
                <td>
                <!-- <a class="Icon webTicket" title="hugh@pandasoftware.my" href="tickets.php?id=12">201810556863</a> -->
                <a class="Icon webTicket" title="hugh@pandasoftware.my" href="<?php echo site_url('ticket_controller/info');?>?id=<?php echo $value->ticket_guid;?>"><?php echo $value->number;?></a>
                </td>
                <td><?php echo $value->created_at;?></td>
                <td><?php echo $value->name;?></td>
                <td>
                    <div style="max-height: 1.2em; max-width: 350px;" class="link truncate" href="<?php echo site_url('ticket_controller/info');?>?id=<?php echo $value->ticket_guid;?>"><?php echo $value->topic;?></div>
                </td>
                <td><span class="truncate"><?php echo $value->department;?></span></td>
            </tr>
            <?php
        }
    ?> 
            </tbody>
</table>
</div>

        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">        </div>
    </div>
    <div id="footer">
        <p>Copyright © 2018 Panda Ticketing System - All rights reserved.</p>
        <a id="poweredBy" href="http://osticket.com" target="_blank">Helpdesk software - powered by osTicket</a>
    </div>
<div id="overlay" style="opacity: 0.3; top: 0px; left: 0px;"></div>
<div id="loading" style="top: 219px; left: 514.5px;">
    <h4>Please Wait!</h4>
    <p>Please wait... it will take a second!</p>
</div>
<script type="text/javascript">
    getConfig().resolve({"html_thread":true,"lang":"en_US","short_lang":"en","has_rtl":false,"primary_language":"en-US","secondary_languages":[]});
</script>

<script src="<?php echo base_url('asset/plugins/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('asset/plugins/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>


<script>
  $(document).ready(function () {    
    $('#ttable').DataTable({
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : false,
      'ordering'    : true,
      'order'       : [ [1 , 'desc'] ],
      'info'        : true,
      'autoWidth'   : true,
    })
  })
</script>
 

</body></html>