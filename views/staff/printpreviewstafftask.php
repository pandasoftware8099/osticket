<html><head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Panda Ticketing System | Printed Ticket</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <link rel="stylesheet" href="<?php echo base_url('asset/dist/css/AdminLTE.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/dist/css/ionicons.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/dist/css/font-awesome.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/dist/css/bootstrap.min.css')?>">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style type="text/css">
  
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    display: inline-block;}

</style>

</head>
<body onload="window.print();" style="    overflow-x: unset;
    overflow-y: unset;">
<div class="wrapper" style="overflow-x: unset;
    overflow-y: unset;"">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <!-- <i class="fa fa-globe"></i>  -->PANDA TICKETING SYSTEM 
          <small class="pull-right">

            Date: <?php echo date("d/m/Y") . "<br>"; ?>
            
          </small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>Panda Software House Sdn. Bhd.</strong><br>
          NO 28-1 & 30-1, Jalan PPM13<br>
          Plaza Pandan Malim Business Park<br>
          Balai Panjang,75250 Melaka<br>
          Plaza Pandan Malim Business Park,75250 Malacca<br>
          <b>Phone:</b> 06-332 3966<br>
          <b>Email:</b> account@pandasoftware.my
   
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <?php foreach ($result->result() as $value) { ?>
        <b>TASK #<?php foreach ($result->result() as $value) { ?><?php echo $value->task_guid;?><?php } ?></b>
        <br>
        <b>Status:</b> <?php echo $status;?><br>
        <b>Department:</b> <?php echo $value->name;?><br>
        <b>Create Date:</b> <?php echo $value->task_created;?><br>
        <b>Due Date:</b> <?php echo $value->duedate;?> <br>
        <?php } ?>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <address>
          <?php foreach ($user->result() as $value1) { ?>
          <strong>Assigned To: 
            <?php 
              if ($value1->staff_guid != '0')
              { ?>
                <?php echo $value1->firstname;?> 
                <?php echo $value1->lastname;?>
              <?php }
              if ($value1->team_guid != '0')
              { ?>
                <?php echo $value1->name;?>
            <?php } ?>
          </strong><br>
          <b>Email:</b> <?php echo $value1->email;?><br>
          <b>Phone:</b> <?php echo $value1->phone;?><br>
        <?php } ?>
        </address>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Name</th>
            <th style=" width: 525px;">Description</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($thread->result() as $value1) { ?>
          <tr>
            <td><?php echo $value1->poster;?></td>
            <td style=" width: 525px; overflow: hidden;word-break: break-all;">
              <?php echo $value1->body;?></td>
            <td><?php echo $value1->created;?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->


</body></html>