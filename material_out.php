<?php include "header.php"  ?>
<?php 
$db = new Database();
$sql = "SELECT order_product_items.*, product.product_name, product.aiq, product.hsn_no FROM order_product_items INNER JOIN product on order_product_items.product_id = product.id";
$result = mysqli_query($db->getConnection(),$sql);

?>

<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> Shrijee Dashboard </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard </li>
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
              
          </div> 
        </div>
      </div>
  </section>
</div>


<?php include "footer.php" ?>