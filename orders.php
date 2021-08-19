
 <?php include "header.php"; ?> 


<?php 
  $db = new Database();
  if(isset($_REQUEST['status'])){
  $sql = "SELECT customers.customer_name,customers.gst_no,customers.contact, orders.*
   FROM orders INNER JOIN customers on customers.id= orders.customer_id WHERE orders.status = '".$_REQUEST['status']."' ";
  }else{
    $sql = "SELECT customers.customer_name,customers.gst_no,customers.contact, orders.*
    FROM orders INNER JOIN customers on customers.id= orders.customer_id";
  }
        //print_r($sql); exit();
          $result = mysqli_query($db->getConnection(), $sql);

    $button = '';

?>
<style type="text/css">
  .table tr td, .table thead th {
    padding: 0.25rem;
    border: none;
  }
  .warning {
    background-color: orange;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
  }
  .red {
    background-color: red;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
    
  }
  .yellow {
    background-color: #4169E1;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
    
  } 
  .ok {
    background-color: greenyellow;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
}
  .allok {
    background-color: green;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
}
.display {
  display: none;
}
</style>
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Order List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Order List </li>
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
      <div class="col-md-12">
          <div class="card">
                  <div class="card-header">
                    <h3 class="card-title"><a href="add_order.php" class="btn btn-block bg-gradient-info btn-sm">Add</a></h3>
                    <span style="float:right"> <label>Search: </label> <input oninput="searchInput(this.value)" id="search" type="text" name="search"></span>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered" id="searchedOrder">
                      <thead>
                        <tr style="text-align: center;">
                          <th style="width: 20px">#</th>
                          <th>Customer Name</th>
                          <th>GST NO</th>
                          <th>Order Date</th>
                          <th>Contact No</th>
                          <th>Status</th>
                          <th>Action</th>

                          <!-- <th style="width: 40px">Label</th> -->
                        </tr>
                      </thead>
                      <?php 
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)) {  ?>
                      <tbody>
                        <tr style="text-align: center;" data-toggle="collapse" data-target="#accordion<?php echo $row['id']; ?>" class="clickable">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['customer_name'] ?></td>
                          <td><?php echo $row['gst_no'] ?></td>
                          <td><?php echo date('d-M-y', strtotime($row['order_date'])); ?></td>
                          <td><?php echo $row['contact'] ?></td>


                            <?php switch ($row['status']) {
                              case 'pending':
                                $status = "Move to Process";
                                $url = "edit_process.php?status=pending&id=".$row['id'];
                                $class = "btn-outline-danger";
                                $bg_clor = "yellow";
                                break;
                              case 'processing':
                                $status = "Complete Processing";
                                $url = "controller/orders.php?submitVal=processing&status=completed&id=".$row['id'];
                                $class = "btn-outline-warning";
                                $bg_clor = "warning";
                              break;
                              case 'completed':
                                $status = "Ready to Deliver";
                                $url = "invoice.php?id=".$row['id'];
                                $class = "btn-outline-success";
                                $bg_clor = "ok";
                              break; 
                              case 'cancelled':
                                $status = "Order cancelled";
                                $url = "";
                                $class = "btn-outline-defult";
                                $bg_clor = "red" ;
                              break;
                               case 'delivered':
                                $status = "Invoice";
                                $url = "invoice-print.php?id=".$row['id'];
                                $class = "btn-outline-success";
                                $bg_clor = "allok" ;
                              break;  
                            }
                           ?>
                          <td ><span class="<?php echo $bg_clor; ?>"><?php 
                              echo $row['status'];?></span></td> 
                          <td ><a class="btn <?php echo $class; ?> btn-sm" href="<?php echo $url; ?>"><?php echo $status; ?></a>  <a class="<?php if($row['status'] == "cancelled") {echo "display";} ?> btn btn-outline-danger btn-sm btn-pad" onclick="cancel_order(<?php echo $row['id'] ?>)">Cancel </a>
                            <i class="fa fa-angle-down" style="margin-left: 30px;" aria-hidden="true"></i>
                        </tr>
                        <?php
                          $order_items = "SELECT order_product_items.*, product.product_name, product.aiq FROM order_product_items INNER JOIN product on order_product_items.product_id = product.id WHERE order_product_items.order_id = '".$row['id']."' ";
                          //print_r($_POST); exit();
                          $result_order = mysqli_query($db->getConnection(), $order_items);

                        ?>
                        <?php 
                           while($row_items = mysqli_fetch_assoc($result_order)) {  ?>
                          <tr style="text-align: center;">
                            <td colspan="6">
                              <div id="accordion<?php echo $row['id']; ?>" class="collapse">
                                <div class="row" >
                                  <div class="col-md-4">
                                    <label>Product Name: </label>
                                       <span><?php echo $row_items['product_name']; ?></span>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Quantity(g): </label>
                                      <span><?php echo $row_items['aiq']; ?></span>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Packets: </label>
                                      <span><?php echo $row_items['packets']; ?></span>
                                  </div>
                                </div>
                              </div>
                            </td>
                           </tr>
                        <?php } ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
      </div>       
    </div>
  </div>
</section>
</div>
<?php include "footer.php"; ?> 
<script type="text/javascript">
  
  function (cancel_order){

    var r = confirm('Cancel Order ?')
      if (r){
        $.ajax({
          url: "controller/orders.php?submitVal=processing&status=cancelled&id="+id,
          type: "GET",
          success:function(response){
            if(response){
              window.reload();
            }
          }
        })

      }

  }
</script>
<script>
      function searchInput(a) {
         $.ajax({
            url: "controller/ajaxController.php?getType=orderSearch&name="+a,
            type: 'GET',
            success: function(response) {
              $('#searchedOrder').html(response);
            }
         })
      }

  </script>