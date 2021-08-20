<?php 
	include "../config/database.php";
	$conn = new Database();
	$ajaxC = new AjaxController();
	switch($_REQUEST['getType']) {
		case "states": 
			$ajaxC->getStates($_REQUEST['country_id']);
			break;
		case "countrySearch":
			$ajaxC->getCountryByName($_REQUEST['name']);
			break;
		case "supplierSearch":
			$ajaxC->getSupplierByName($_REQUEST['name']);
			break;
		case "customerSearch":
			$ajaxC->getCustomerByName($_REQUEST['name']);
			break;
		case "orderSearch":
			$ajaxC->getOrderByName($_REQUEST['name']);
			break;
			case "invoiceSearch":
			$ajaxC->getInvoiceByName($_REQUEST['name']);
			break;
		case "materials":
			$ajaxC->getMaterial();
			break;
		case "product":
			$ajaxC->getProduct();
			break;
		case "in":
			$ajaxC->getMaterials('in');
			break;
		case "out":
			$ajaxC->getMaterials('out');
			break;
				

	}


	class AjaxController {
		public $conn;

		public function __construct()
		{
			$this->conn=new Database();
		}

		public function getStates($country_id) {
			$sql = "SELECT * FROM states WHERE country_id = '".$country_id."' order by name";
  	   		$result = mysqli_query($this->conn->getConnection(), $sql); ?>

  	   		<select class="form-control" name="country" id="country"> 

  	   			<?php while ($row = mysqli_fetch_assoc($result)) { ?>
  	   				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
  	   			<?php } ?>	
  	   		</select>

  	   		<?php 
  	   		 
		}

		public function getCountryByName($name) {
			$sql = "SELECT * FROM countries WHERE name LIKE '%".$name."%'";
			$result = mysqli_query($this->conn->getConnection(), $sql); ?>
				<table class="table table-bordered" style="margin-top: 10px;">
					<thead>
						<th>Sr.No</th>
						<th>Name</th>
						<th>Action</th>
					</thead>

					<?php 
					$srno=1;
					while ($row=mysqli_fetch_assoc($result))
					{?>
						<tr>
							<td><?php echo $srno++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><a class="btn-sm btn-success" href="country.php?id=<?php echo $row['id']; ?>">Edit</a><!-- <a class="btn-sm btn-danger" href="controller/master.php?id=<?php echo $row['id']; ?>&submit=deleteCountry">Delete</a> --> </td>
						</tr>
					<?php }?>
				</table> 
		<?php }

		public function getMaterial(){
			$sql = " SELECT * FROM materials";
			$result = mysqli_query($this->conn->getConnection(),$sql);

			$response = array();

			while($row =  mysqli_fetch_assoc($result)) {
				$data = array(
					'id' => $row['id'],
					'name' => $row['name']
				);
				array_push($response, $data);
			}
			echo json_encode($response);


		}
		public function getProduct(){
			$sql = " SELECT * FROM product";
			$result = mysqli_query($this->conn->getConnection(),$sql);

			$response = array();

			while($row =  mysqli_fetch_assoc($result)) {
				$data = array(
					'id' => $row['id'],
					'name' => $row['product_name']
				);
				array_push($response, $data);
			}
			echo json_encode($response);


		}	
		public function getSupplierByName($name) {
			$sql = "SELECT * FROM supplier WHERE gst_no LIKE '%".$name."%' OR supplier_name LIKE '%".$name."%'" ;
			//print_r($sql);exit();
			$result = mysqli_query($this->conn->getConnection(), $sql); ?>
				<table class="table table-bordered" id="searchedSupplier">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Supplier Name</th>
                          <th>GST NO</th>
                          <th>Contact No</th>
                          <th>Address</th>
                          <th>Action</th>
                          <th style="width: 40px">Label</th>
                        </tr>
                      </thead>

					<?php 
					$i=1;
					while ($row=mysqli_fetch_assoc($result))
					{?>
						<tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['supplier_name'] ?></td>
                          <td><?php echo $row['gst_no'] ?></td>
                          <td><?php echo $row['contact_no'] ?></td>
                          <td><?php echo $row['address'] ?></td>
                          <td><a href="add_supplier.php?id=<?php echo $row['id']; ?>">Update</a>  /  
                          <a href="controller/product.php?submitVal=delete&id=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
					<?php }?>
				</table> 
		<?php }
		
		public function getOrderByName($name) {
			$sql = "SELECT customers.customer_name,customers.gst_no,customers.contact, orders.*
   					FROM orders INNER JOIN customers on customers.id= orders.customer_id WHERE customer_name LIKE '%".$name."%'";
			$result = mysqli_query($this->conn->getConnection(), $sql); ?>
				<table class="table table-bordered" id="searchedOrder">
                      <thead>
                        <tr>
                          <th style="width: 20px">#</th>
                          <th>Customer Name</th>
                          <th>GST NO</th>
                          <th>Order Date</th>
                          <th>Contact No</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>

					<?php 
					$i=1;
					while ($row=mysqli_fetch_assoc($result))
					{?>
						<tr data-toggle="collapse" data-target="#accordion<?php echo $row['id']; ?>" class="clickable">
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
                                $bg_clor = "red";
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
                                $bg_clor = "allok";
                              break; 
                              case 'cancelled':
                                $status = "Order cancelled";
                                $url = "";
                                $class = "btn-outline-defult";
                                $bg_clor = "red" ;
                              break;  
                            }
                           ?>
                          <td ><span class="<?php echo $bg_clor; ?>"><?php 
                              echo $row['status'];?></span></td> 
                          <td ><a class="btn <?php echo $class; ?> btn-sm" href="<?php echo $url; ?>"><?php echo $status; ?></a>  <a class="<?php if($row['status'] == "cancelled") {echo "display";} ?> btn btn-outline-danger btn-sm btn-pad" onclick="cancel_order(<?php echo $row['id'] ?>)">Cancel </a>

                        </tr>
					<?php }?>
				</table> 
		<?php }

		public function getCustomerByName($name) {
			$sql = "SELECT * FROM customers WHERE customer_name LIKE '%".$name."%'";
			$result = mysqli_query($this->conn->getConnection(), $sql); ?>
				<table class="table table-bordered" id="searchedCustomer">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Customer Name</th>
                          <th>GST No.</th>
                          <th>Contact No.</th>
                          <th>Action</th>
                          <th style="width: 40px">Label</th>
                        </tr>
                      </thead>

					<?php 
					$i=1;
					while ($row=mysqli_fetch_assoc($result))
					{?>
						<tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['customer_name'] ?></td>
                          <td><?php echo $row['gst_no'] ?></td>
                          <td><?php echo $row['contact'] ?></td>
                          <td><a href="add_supplier.php?id=<?php echo $row['id']; ?>">Update</a>  /  
                          <a href="controller/product.php?submitVal=delete&id=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
					<?php }?>
				</table> 
		<?php }
		public function getInvoiceByName($name) {
			$sql = "SELECT invoice.customer_id,invoice.invoice_no,invoice.amount_to_pay, invoice_items.*,customers.*
   						FROM invoice_items INNER JOIN invoice on invoice.id = invoice_items.invoice_id INNER JOIN customers ON customers.id = invoice.customer_id  WHERE customer_name LIKE '%".$name."%'";
			$result = mysqli_query($this->conn->getConnection(), $sql); ?>
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
		<?php }

		public function getMaterials($type){
			

				if ($type == 'out') {
					 $sql = "SELECT SUM(qty_used) as qty ,material_id, materials.id, materials.name FROM processing INNER JOIN 			materials ON processing.material_id = materials.id GROUP BY material_id"; 
					 $result = mysqli_query($this->conn->getConnection(), $sql);?>

					 	<table class="table table-bordered" >
                      <thead>
                        <tr>
                          <th style="width: 20px">#</th>
                          <th>Material Name</th>
                          <th>Qty</th>
                        </tr>
                      </thead>
            <?php 
							$i=1;
								while ($row=mysqli_fetch_assoc($result))
						{?>
						<tr data-toggle="collapse" data-target="#accordion<?php echo $row['id']; ?>" class="clickable">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $row['name'] ?></td>
                          <td><?php echo $row['qty'] ?></td>
                          </tr>
						<?php }?>
					</table> 
					<?php
				}else if ($type == 'in') {
								$sql = "SELECT  materials_in.*, supplier.supplier_name FROM materials_in INNER JOIN supplier on 
     										 materials_in.supplier_id = supplier.id";
     										 $result = mysqli_query($this->conn->getConnection(), $sql);?>
     						<table class="table table-bordered">
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
                          $db = new Database();
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
                    <?php	
				}
				$result = mysqli_query($this->conn->getConnection(),$sql);

		}
	}

?>