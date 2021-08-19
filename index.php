<?php include "header.php" ;

$db = new Database();
$sql_new_order_count = "SELECT COUNT(id) as count_id  FROM orders where status = 'pending' ";
$result = mysqli_query($db->getConnection(),$sql_new_order_count);
//print_r($result); exit(); 
$row = mysqli_fetch_assoc($result);
//print_r($row); exit(); 
$sql_processing_count = "SELECT COUNT(id) as count_id_processing  FROM orders where status = 'processing' ";
$result_pro = mysqli_query($db->getConnection(),$sql_processing_count);
//print_r($result); exit(); 
$row_pro = mysqli_fetch_assoc($result_pro);
$sql_ready_count = "SELECT COUNT(id) as count_id_ready  FROM orders where status = 'completed' ";
$result_ready = mysqli_query($db->getConnection(),$sql_ready_count);
//print_r($result); exit(); 
$row_ready = mysqli_fetch_assoc($result_ready);
$sql_mate = "SELECT materials.name, materials.id as mat_id,SUM(material_in_items.qty) as total_qty, material_in_items.* FROM materials INNER JOIN material_in_items ON materials.id = material_in_items.materials_id GROUP BY material_in_items.materials_id ";
$result_mate = mysqli_query($db->getConnection(),$sql_mate);
//$row_mate = mysqli_fetch_assoc($result_mate); 


 ?>

<!-- Content Wrapper. Contains page content -->
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
	              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $row ['count_id'] ?></h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="orders.php?status=pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning ">
              <div class="inner">
                <h3> <?php echo $row_pro ['count_id_processing']  ?> <sup style="font-size: 20px"></sup></h3>

                <p>Processing Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="orders.php?status=processing" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $row_ready['count_id_ready'] ?></h3>

                <p>Ready to Deliver</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="orders.php?status=completed" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3> Material Alert  </h3>

                <?php while($row_mate = mysqli_fetch_assoc($result_mate)) {
                  if ($row_mate['total_qty'] <= 100){ ?>
                      <span class= "col-md-6"><?php echo $row_mate ['name']; ?></span>
                       <span class="col-md-6"> <?php echo $row_mate['total_qty']; ?></span>
                       <?php
                  }
                }
                  ?>
                
                
                 <p><?php //echo $row_mate['total_qty'] ?></p>
                <?php ?>
              </div>
          		
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
	    </div>
	</section>
</div>


<?php include "footer.php" ?>