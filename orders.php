<?php
include("header.php"); 
include("connection.php");
if(isset($_GET["p_id"])){
	$product_id = $_GET["p_id"];
}
else {
	location("index.php");
}

if(isset($_POST['form1']))
{
	try {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$user_name = test_input($_POST['user_name']);
		$user_email = test_input($_POST['user_email']);
		$user_mobile = test_input($_POST['user_mobile']);
		$user_quantity = test_input($_POST['user_quantity']);
		$user_address = test_input($_POST['user_address']);


		

		$p_date = date('Y-m-d');
		
		$statement = $db->prepare("INSERT INTO table_orders (p_id,user_name,user_email,user_mobile,user_quantity,user_address,order_date) VALUES (?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['p_id'],$user_name,$user_email,$user_mobile,$user_quantity,$user_address,$p_date));


		$success_message = "Thanks , As early as possible we CONTACT with you.";
		
	
	}
	
	catch(Exception $e) { 
		$error_message = $e->getMessage();
	}
} 
?>


<section>
	<div class="container">
		<div class="row">
			
			<div class="col-sm-12">

<?php

			$statement = $db->prepare("SELECT * FROM table_products WHERE p_id = ?");
			$statement->execute(array($product_id));
			$products = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach ($products as $product) {
					$product_name = $product["p_name"];
					$product_image = $product["p_image"];
					$product_price = $product["p_price"];
					$com_id = $product["com_id"];
					$cat_id = $product["cat_id"];
					$size_id = $product["size_id"];
					}

			$statement = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
			$statement->execute(array($com_id));
			$com_name = $statement->fetch()["com_name"]; 

			$statement = $db->prepare("SELECT cat_name FROM table_categories WHERE cat_id = ?");
			$statement->execute(array($cat_id));
			$cat_name = $statement->fetch()["cat_name"]; 

			$statement = $db->prepare("SELECT size_name FROM table_sizes WHERE size_id = ?");
			$statement->execute(array($size_id));
			$size_name = $statement->fetch()["size_name"];  

?>
				<div class="product-details"><!--product-details-->
					<div class="col-sm-5">
					<h2 class="title text-center">Your Orders Information</h2>
						<div class="product-information"><!--/product-information-->
							<table>
								<tr>
									<td><h3><span class="product_name">Product Name</span></h3></td>
									<td><h3><span class="product_name">&nbsp;&nbsp;:&nbsp;&nbsp;</span></h3></td>
									<td><h3><?php echo $product_name ; ?></h3></td>
								</tr>
								<tr>
									<td><h4><span class="product_name">Company Name</span></h4></td>
									<td><h4><span class="product_name">&nbsp;&nbsp;:&nbsp;&nbsp;</span></h4></td>
									<td><h4><?php echo $com_name ; ?></h4></td>
								</tr>
								<tr>
									<td><h4><span class="product_name">Category Name</span></h4></td>
									<td><h4><span class="product_name">&nbsp;&nbsp;:&nbsp;&nbsp;</span></h4></td>
									<td><h4><?php echo $cat_name ; ?></h4></td>
								</tr>
								<tr>
									<td><h4><span class="product_name">Size Name</span></h4></td>
									<td><h4><span class="product_name">&nbsp;&nbsp;:&nbsp;&nbsp;</span></h4></td>
									<td><h4><?php echo $size_name; ?></h4></td>
								</tr>
								<tr>
									<td><h4><span class="product_name">Price</span></h4></td>
									<td><h4><span class="product_name">&nbsp;&nbsp;:&nbsp;&nbsp;</span></h4></td>
									<td><h4><?php echo $product_price; ?> Tk.</h4></td>
								</tr>
							</table>
											
							
						</div><!--/product-information-->
					</div>


					<div class="col-sm-7">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Order Here </h2>
	    				<?php
						if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
						if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
						?>
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<form id="main-contact-form" class="contact-form row" method="post" action="" enctype="multipart/form-data">
				            <div class="form-group col-md-6">
				                <input type="text" name="user_name" class="form-control" required="required" placeholder="Name">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" name="user_email" class="form-control" required="required" placeholder="Email">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="text" name="user_mobile" class="form-control" required="required" placeholder="Mobile No">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="text" name="user_quantity" class="form-control" required="required" placeholder="Quantity (Like : 20C 5P)">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="user_address" id="message" required="required" class="form-control" rows="7" placeholder="Delivary Address within 10 words."></textarea>
				            </div> 
				            <div class="form-group col-md-12">
				                <input type="hidden" name="p_id" class="form-control" value="<?php echo $product_id ; ?>">
				            </div>                       
				            <div class="form-group col-md-12">
				                <input type="submit" name="form1" class="btn btn-primary pull-right" value="Submit">
				            </div>
				        </form>
	    			</div>
	    		</div>


				</div><!--/product-details-->


				
			</div>

		</div>
	</div>
</section>

<?php include("footer.php"); ?>