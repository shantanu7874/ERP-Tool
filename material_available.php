
 <?php include "header.php"; ?> 


<?php 
  $db = new Database();
  $material_available = "SELECT t1.materials_id,materials.id, materials.name,SUM(t1.factor*t1.mat_qty) as mat_in_qty FROM (SELECT materials_id, ifnull(SUM(qty),0) as mat_qty, 1 as factor FROM material_in_items GROUP BY materials_id 
      UNION ALL SELECT processing.material_id, ifnull(SUM(processing.qty_used),0) mat_out_qty, -1 as factor FROM processing GROUP by processing.material_id) as t1 INNER JOIN materials ON materials.id = t1.materials_id GROUP BY t1.materials_id";
      //print_r($material_available); echo "<br>";
      $result_available = mysqli_query($db->getConnection(), $material_available);
      //print_r($result_available); exit();

?>
<style type="text/css">
  .table tr td, .table thead th {
    padding: 0.25rem;
    border: none;
  }
  .warning {
    background-color: orange;
    color: #fff;
  }
  .red {
    background-color: red;
    color: #fff;
  } 
  .allok {
    background-color:: green;
    color: #000;
}
</style>
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Materials Available</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Material Available </li>
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
                  
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr >
                          <th style="width: 30px">#</th>
                          <th>Material Name</th>
                          <th>Available qty</th>
                          
                        </tr>
                      </thead>
                      <?php 
                        $i = 1;
                         while($row_available = mysqli_fetch_assoc($result_available)) {  ?>
                      <tbody>
                        <tr  data-toggle="collapse" data-target="#accordion<?php echo $row['id']; ?>" class="clickable">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row_available['name'] ?></td>
                          <td><?php echo $row_available['mat_in_qty'] ?></td>
                          
                        </tr>
                          
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