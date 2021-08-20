
 <?php include "header.php"; ?> 


<?php 
  $db = new Database();
  $sql = "SELECT  materials_in.*, supplier.supplier_name FROM materials_in INNER JOIN supplier on 
      materials_in.supplier_id = supplier.id";
  $result = mysqli_query($db->getConnection(), $sql);

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
              <h1 class="m-0">Materials List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Materials List </li>
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
                    <h3 class="card-title"><a href="add_material_in.php" class="btn btn-block bg-gradient-info btn-sm">Add</a></h3>
                    <div style="float:right">
                      <input type="radio" onclick="getType('in')" id="in" name="materials" value="">
                        <label for="html">IN</label>
                        <input type="radio" id="out" onclick="getType('out')" name="materials" value="">
                        <label for="css">OUT</label>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered" id="asd">
                      <thead>
                        <tr >
                          <th style="width: 30px">#</th>
                          <th>Supplier Name</th>
                          <th>Bill No.</th>
                          <th>Payment </th>
                          <th>Action</th> 
                        </tr>
                      </thead>
                      <?php 
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)) {  ?>
                      <tbody>
                        <tr  data-toggle="collapse" data-target="#accordion<?php echo $row['id']; ?>" class="clickable">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['supplier_name'] ?></td>
                          <td><?php echo $row['bill_no'] ?></td>
                          <td><?php echo $row['payment'] ?></td>
                          <td><a href="add_material_in.php?id=<?php echo $row['id']; ?>">Update</a>  /  
                          <a href="controller/material_in.php?submitVal=delete&id=<?php echo $row['id']; ?>">Delete</a> <i class="fa fa-angle-down" style="margin-left: 30px;" aria-hidden="true"></i>
                          </td>
                        </tr>
                          <?php
                            $mat_items = "SELECT material_in_items.*, materials.name FROM material_in_items INNER JOIN materials on material_in_items.materials_id = materials.id WHERE material_in_items.materials_in_id = '".$row['id']."' ";
                            //print_r($mat_items); exit();
                            $result_items = mysqli_query($db->getConnection(), $mat_items);

                           ?>
                           <?php 
                             while($row_items = mysqli_fetch_assoc($result_items)) {  ?>
                        <tr>
                          <td colspan="5">
                            <div id="accordion<?php echo $row['id']; ?>" class="collapse">
                              <div class="row">
                                <div class="col-md-3">
                                  <label>Material Name</label>
                                  <span><?php echo $row_items['name']; ?></span>
                                </div>
                                <div class="col-md-3">
                                  <label>Quantity</label>
                                  <span><?php echo $row_items['qty']; ?></span>
                                </div>
                                <div class="col-md-3">
                                  <label>Amount</label>
                                  <span><?php echo $row_items['amt']; ?></span>    
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

function getType(a) {
  //var a =  $('input[type=radio]:checked');
  var url = '';
  if(a =='in') {
    url = "controller/ajaxController.php?getType=in";
  } else {
    url = "controller/ajaxController.php?getType=out";
  }
//alert(url);             
        
$.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
              //alert(response);
              $('#asd').html(response);

            }
         })
}

</script>