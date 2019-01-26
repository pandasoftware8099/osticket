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
          <!-- <i class="fa fa-globe"></i>  -->PANDA TICKETING SYSTEM - FAQ 
          <small class="pull-right">

            Date: <?php echo date("d/m/Y") . "<br>"; ?>
            
          </small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    
 
<?php foreach ($faqinfo->result() as $value1) { ?>
<h1><div class="faq-title flush-left"><?php echo $value1->question;?></div></h1>

<div class="faded">Last Updated    <?php echo $value1->updated;?></div>

<?php } ?>
<br>
<div class="thread-body bleed">

<?php foreach ($faqinfo->result() as $value2) { ?>

<?php 

echo $value2->answer;


?>
<?php } ?>

<!-- <?php foreach ($faqdetails->result() as $value2) { ?>

<?php 

echo $value2->text;

echo '<br><br><img src="data:image/jpeg;base64,'.base64_encode( $value2->image ).'"/><br><br>';

?>
<?php } ?> -->




</div>





  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->


</body></html>