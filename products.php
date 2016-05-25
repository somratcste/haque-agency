<?php
 include("header.php"); 
 include("connection.php");

if (isset($_GET['com_id']) & isset($_GET['cat_id']) & isset($_GET['size_id'])) {
    $com_id =  $_GET['com_id'];
    $cat_id =  $_GET['cat_id'];
    $size_id = $_GET['size_id'];
}else{
    
    location("index.php");
}
?>

<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12 ">

<?php

				$statement = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
				$statement->execute(array($com_id));
				$com_name = $statement->fetch()["com_name"]; 

?>
					
					
				<h2 class="category_header"><?php echo $com_name ; ?><img src="images/shop/category_background.png" class="girl img-responsive category_background" alt="" /></h2>
						
				</div>
					
				</div>
			</div>
		</div>
</section><!--/slider-->
	
<section>
	<div class="container">
		<div class="row">
			
			<div class="col-sm-12">
				<div class="features_items"><!--features_items-->

<?php

				$statement = $db->prepare("SELECT cat_name FROM table_categories WHERE cat_id = ?");
				$statement->execute(array($cat_id));
				$cat_name = $statement->fetch()["cat_name"]; 

				$statement = $db->prepare("SELECT size_name FROM table_sizes WHERE size_id = ?");
				$statement->execute(array($size_id));
				$size_name = $statement->fetch()["size_name"]; 

?>
					<h2 class="title text-center"><?php echo $size_name; ?> - <?php echo $cat_name ; ?></h2>

<?php

				$statement = $db->prepare("SELECT p_id , p_name , p_image FROM table_products WHERE com_id = ? AND cat_id = ? AND size_id = ? ");
				$statement->execute(array($com_id,$cat_id,$size_id));
				$products = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach ($products as $product) {

					    	$p_id = $product["p_id"];					    	
?>
			    	<div class="col-sm-3">
						<div class="product-image-wrapper">
							<div class="single-products">
									<div class="productinfo text-center">
										<a href="product-details.php?p_id=<?php echo $p_id; ?>"><img src="administrator/dist/img/product-images/<?php echo $product["p_image"] ; ?>" alt="" /></a>
										<!--<h2>302 BR</h2>-->
										<h3><?php echo $product["p_name"];?></h3>
									</div>

							</div>

						</div>
					</div>

<?php
					}

?>
					
					
		
					
				</div><!--features_items-->					
			</div>
		</div>
	</div>
</section>
	
<?php include("footer.php");