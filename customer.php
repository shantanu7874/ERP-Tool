
 <?php include "header.php"; ?> 


<?php 
  $db = new Database();
  $sql = 'SELECT * FROM customers';
  $result = mysqli_query($db->getConnection(), $sql);

?>

<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Customer List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Customer List </li>
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
                    <h3 class="card-title"><a href="add_customer.php" class="btn btn-block bg-gradient-info btn-sm">Add</a></h3>
                    <span style="float:right"> <label>Search: </label> <input oninput="searchInput(this.value)" id="search" type="text" name="search"></span>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered" id="searchedCustomer">
                      <thead>
                        <tr style="text-align: center;">
                          <th style="width: 10px">#</th>
                          <th>Customer Name</th>
                          <th>GST No.</th>
                          <th>Contact No.</th>
                          <th>Action</th>
                          <th style="width: 40px">Label</th>
                        </tr>
                      </thead>
                      <?php 
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)) {  ?>
                      <tbody>
                        <tr style="text-align: center;">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['customer_name'] ?></td>
                          <td><?php echo $row['gst_no'] ?></td>
                          
                          <td><?php echo $row['contact'] ?></td>
                          <td><a href="add_customer.php?id=<?php echo $row['id']; ?>">Update</a>  /  
                          <a href="controller/product.php?submitVal=delete&id=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
                      </tbody>
                      <?php } ?>
                    </table>
                  </div>
                </div>
      </div>       
    </div>
  </div>
</section>
</div>
<?php include "footer.php"; ?> 
<script>
      function searchInput(a) {
         $.ajax({
            url: "controller/ajaxController.php?getType=customerSearch&name="+a,
            type: 'GET',
            success: function(response) {
              $('#searchedCustomer').html(response);
            }
         })
      }

  </script>