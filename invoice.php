
<?php include 'header.php';
      include 'controller/numbertowordconvertsconver.php';
      
  $db = new Database();

  $sql = "SELECT customers.customer_name,customers.gst_no,customers.contact,customers.address,customers.email, orders.*
  FROM orders INNER JOIN customers on customers.id= orders.customer_id WHERE orders.id = '".$_REQUEST['id']."'" ;
  //print_r($sql); 
  $result = mysqli_query($db->getConnection(), $sql);
  //print_r($result); exit();
  $row = mysqli_fetch_assoc($result);
 //print_r($row); exit();
 $order_items = "SELECT order_product_items.*, product.product_name,product.mrp,product.rate,product.gst_no,product.hsn_no FROM order_product_items INNER JOIN product on order_product_items.product_id = product.id WHERE order_product_items.order_id = '".$_REQUEST['id']."' ";
 $result_order = mysqli_query($db->getConnection(), $order_items);
 //$row_order = mysqli_fetch_assoc($result_order);
 //print_r($order_items); exit();
 
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   		<!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h1 class="m-0"> INVOICE </h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
	              <li class="breadcrumb-item active">invoice </li>
	            </ol>
	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
         <div class="row">
          <form action="controller/invoice.php" method="post" enctype="multipart/form-data">
         <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i><img src="dist/img/logo.png" height="40" width="40"></i> SHRIJEE
                    <small class="float-right">Date:<input style="border:0px" id="datepicker" name="date" value="<?php echo date('d-M-y', strtotime($row['deadline'])); ?>" type="text" size="6"> </small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Vasanti Kutir Udyog</strong><br>
                    74 Tapovan Complex, Somalwada<br>
                    Phone: +919325004228<br>
                    Email:vasanikutir@gmail.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <?php //while ($row = mysqli_fetch_assoc($result)) { 
                   // print_r($row); exit();?>
                  To
                  <address>
                    <strong><?php echo $row['customer_name'] ?></strong><br>
                    <?php  echo $row['address'] ?><br>
                    Phone: <?php echo $row['contact'] ?><br>
                    Email: <?php echo $row['email'] ?><input type="hidden" name="customer_id" value="<?php echo $row['customer_id'] ?>">
                  </address>
                  <?php //} ?>
                </div>

                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><input type="hidden" name="invoice_no"><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br><input type="hidden" id="order_id" name="order_id" value="<?php echo $_REQUEST['id'] ?>">
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->

              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr style="text-align: center;">
                      <th>#</th>
                      <th>Description of Goods</th>
                      <th>HSN/SAC</th>
                      <th>MRP</th>
                      <th>Packets</th>
                      <th>Rate</th>
                      <th>Total <small>(Packets x Rate)</small> </th>
                      <th>GST %</th>
                      <th>Final Amount </th>
                    </tr>
                    </thead>
                   
                    <tbody>
                       <?php 
                        $i = 1;
                        $t = 0;
                        $g=0;
                        $gst =0;
                        $st=0;
                        while($row_order = mysqli_fetch_assoc($result_order)) { 
                        //print_r($row_order); ?>
                    <tr style="text-align: center;">
                      <td><?php echo $i++; ?></td><input type="hidden" name="product_id[]" value="<?php echo $row_order['product_id'] ?>">
                      <td><?php echo $row_order['product_name'] ?></td><input type="hidden" name="product_name[]" value="<?php echo $row_order['product_name'] ?>">
                      <td><?php echo $row_order['hsn_no'] ?></td><input type="hidden" name="hsn_no[]" value="<?php echo $row_order['hsn_no'] ?>">
                       <td><?php echo $row_order['mrp'] ?></td><input type="hidden" name="mrp[]" value="<?php echo $row_order['mrp'] ?>">
                      <td><?php echo $row_order['packets'] ?></td><input type="hidden" name="packets[]" value="<?php echo $row_order['packets'] ?>">
                      <td><?php echo $row_order['rate'] ?></td><input type="hidden" name="rate[]" value="<?php echo $row_order['rate'] ?>">
                      <td><strong><?php echo $row_order['packets'] * $row_order['rate']  ?></strong></td><input type="hidden" name="total[]" value="<?php echo $row_order['packets'] * $row_order['rate']  ?>">
                       <td><?php echo $row_order['gst_no'] ?>%</td><input type="hidden" name="gst[]" value="<?php echo $row_order['gst_no'] ?>">
                      <td><strong><?php  $t = $row_order['packets'] * $row_order['rate'] ;
                                $g= $row_order['gst_no']/100 ; 
                                 $st=$t+$st;
                                 $gst = ($t * $g) + $gst;
                                  echo  ($t * $g) + $t; ?></strong></td><input type="hidden" name="final_amt[]" value="<?php echo  ($t * $g) + $t; ?>">
                      
                    </tr>
                    <?php } ?>
                    </tbody>
                    
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              
              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  
                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                  <p class="lead">Payment Methods:</p>
                  <img src="dist/img/credit/upi.png" alt="" height="45" width="50"> 
                  <h5>Amount to be paid <small>(In Words)</small>: <span style="font-size: 18px;" ><?php
                        $class_obj = new numbertowordconvertsconver();
                        //print_r($class_obj); exit();
                        $convert_number = round($st+$gst); 
                        echo $class_obj->convert_number($convert_number);
                        ?></span> </h5>
                </div>
                <!-- /.col -->
                  <div class="col-6">
                  <p class="lead" ></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>₹<?php ;
                            echo $st;
                              ;
                         ?></td><input type="hidden" name="subtotal" value="<?php echo $st;?>">
                      </tr>
                      <tr>
                        <th>GST (5%)</th>
                        <td>₹ <?php echo $gst; ?></td><input type="hidden" name="gst_total" value="<?php echo $gst;?>">
                      </tr>
                      <tr>
                        <th>Amount to be paid</th>
                        <td> <strong style="font-weight: bolder;">₹ <?php echo round($st+$gst); ?></strong></td>
                        <input type="hidden" name="amount_to_pay" value="<?php echo round($st+$gst);?>">
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
            
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <input type="hidden" name="submitVal" value="Add">
                 

                  <button class="btn btn-default" type="submit" target="_blank" href="invoice-print.php?id=<?php echo $_REQUEST['id']; ?>" name=""> <i class="fas fa-print"></i> Print</button> 

                  <input type="hidden" name="print" id="print" value="<?php if(isset($_REQUEST['print'])) { echo $_REQUEST['print']; } ?>">

                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
          </form>


         </div>
  
	    </div>
	</section>
</div>


<?php include "footer.php" ?>
<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
  <script>
    window.onload = function(){
      var p = document.getElementById('print').value;
      var id = document.getElementById('order_id').value;
      console.log(id);
      if (p == 'true') {
         window.open("invoice-print.php?id="+id, "_blank");
      }
        
    }
</script>
