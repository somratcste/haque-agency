<?php 
include("header.php"); 
include("connection.php");

?>
<div class="mainmenu pull-left" id="cssmenu">

<ul class="nav navbar-nav collapse navbar-collapse">
	<li><a href="index.php" class="active">Home</a></li>

<!--
	<ul class="nav navbar-nav collapse navbar-collapse">
		<li><a href="index.php" class="active">Home</a></li>  -->

<?php

$statement = $db->prepare("SELECT DISTINCT com_id FROM table_companies");
$statement->execute(array());

$companies = $statement->fetchAll(PDO::FETCH_ASSOC);
//echo count($companies);

foreach ($companies as $com) {

	$company_id = $com['com_id'];

	$statement1 = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
	$statement1->execute(array($company_id));

	$company_name = $statement1->fetch()["com_name"];

	$statement2 = $db->prepare("SELECT DISTINCT cat_id FROM table_products WHERE com_id = ?");
	$statement2->execute(array($company_id));

	$categories= $statement2->fetchAll(PDO::FETCH_ASSOC);

	if(count($categories) == 0)
	{
?>
		<li><a href="/products.php?com_id=<?php echo $company_id; ?>"><?php echo $company_name; ?></a></li>
<?php
	}
	else
	{
?>
		<li class="dropdown has-sub"><a href="/products.php?com_id=<?php echo $company_id; ?>"><?php echo $company_name; ?></a>
		<ul role="menu" class="sub-menu">
<?php

		foreach ($categories as $cat) {

			$category_id = $cat["cat_id"];

			$statement3 = $db->prepare("SELECT * FROM table_categories WHERE cat_id = ?");
			$statement3->execute(array($category_id));

			$category_name = $statement3->fetch()["cat_name"];

			$statement3 = $db->prepare("SELECT DISTINCT size_id FROM table_products WHERE cat_id = ? AND com_id = ? ");
			$statement3->execute(array($category_id, $company_id));

	  		$sizes= $statement3->fetchAll(PDO::FETCH_ASSOC);

	  		if(count($sizes) == 0)
	  		{
?>
  				<li class="has-sub"><a href="products.php/com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a></li>
<?php
	  		}
	  		else
	  		{
?>
  				<li class="has-sub"><a href="products.php/com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a>
  				<ul>
<?php
				foreach ($sizes as $s) {

					$size_id = $s["size_id"];	

					$statement4 = $db->prepare("SELECT * FROM table_sizes where size_id = ?");
					$statement4->execute(array($size_id));

					$size_name = $statement4->fetch()["size_name"];
?>		
					<li><a href="products.php/com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>&amp;size_id=<?php echo $size_id; ?>"><span><?php echo $size_name; ?></span></a></li>
<?php
				}
?>
				</ul>
				</li>
<?php
			}
  		}
?>
		</ul>
		</li>
<?php
	}
}
?>
</ul>
</div>
	
