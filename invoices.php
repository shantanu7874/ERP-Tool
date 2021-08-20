
 <?php include "header.php"; ?> 


<?php 
  $db = new Database();
  
  $sql = "SELECT invoice.customer_id,invoice.invoice_no,invoice.amount_to_pay, invoice_items.*,customers.*
   FROM invoice_items INNER JOIN invoice on invoice.id = invoice_items.invoice_id INNER JOIN customers ON customers.id = invoice.customer_id ";
  
    // $sql = "SELECT customers.customer_name,customers.gst_no,customers.contact, orders.*
    // FROM orders INNER JOIN customers on customers.id= orders.customer_id";
  
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
              <h1 class="m-0">Invoices</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Invoices </li>
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
                          <th>Invoice No</th>
                          <th>Total Amount</th>
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
                          <td><?php echo $row['invoice_no'] ?></td>
                          <td><?php echo $row['amount_to_pay'] ?></td>
                          <td> <a href="invoice-print.php?id="<?php.$row['id']?>> INVOICE</a></td>
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
            url: "controller/ajaxController.php?getType=invoiceSearch&name="+a,
            type: 'GET',
            success: function(response) {
              $('#searchedOrder').html(response);
            }
         })
      }

  </script>