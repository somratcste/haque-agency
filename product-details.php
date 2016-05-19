<?php
include("header.php"); 
include("connection.php");
if(isset($_GET["p_id"])){
	$product_id = $_GET["p_id"];
}
else {
	location("index.php");
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
					<div class="col-sm-4">
						<div class="view-product">
							<img id="zoom_01" src="images/product-details/<?php echo $product_image ; ?>"  alt="" data-zoom-image="images/product-details/<?php echo $product_image ; ?>" />
						</div>

					</div>
					<div class="col-sm-8">
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
								<tr>	
									  <td><a href="orders.php?p_id= <?php echo $product_id ; ?>" class="btn btn-primary btn-lg active" role="button">ORDER</a></td>	
								</tr>
							</table>
											
							
						</div><!--/product-information-->
					</div>

				</div><!--/product-details-->


				
			</div>

		</div>
	</div>
</section>

<?php include("footer.php"); ?>