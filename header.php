<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | HAQUE-Agencies</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/sub-menu.css">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> 01712-866293</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> haqeagency01712@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/logo.png" alt="" /></a>
							
						</div>

					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="index.php"><i class="fa fa-user"></i> Home</a></li>
								<li><a href="contact-us.php"><i class="fa fa-crosshairs"></i>Contact</a></li>
								<li><a href="login.php"><i class="fa fa-lock"></i> Login</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>



						<div class="mainmenu pull-left" id="cssmenu">

							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="active">Home</a></li>

							<!--
								<ul class="nav navbar-nav collapse navbar-collapse">
									<li><a href="index.php" class="active">Home</a></li>  -->

							<?php
							include("connection.php");


							$statement = $db->prepare("SELECT DISTINCT com_id FROM table_products");
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
									<li><a href="products.php?com_id=<?php echo $company_id; ?>"><?php echo $company_name; ?></a></li>
							<?php
								}
								else
								{
							?>
									<li class="dropdown has-sub"><a href="products.php?com_id=<?php echo $company_id; ?>"><?php echo $company_name; ?></a>
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
							  				<li class="has-sub"><a href="products.php?com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a></li>
							<?php
								  		}
								  		else
								  		{
							?>
							  				<li class="has-sub"><a href="products.php?com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a>
							  				<ul>
							<?php
											foreach ($sizes as $s) {

												$size_id = $s["size_id"];	

												$statement4 = $db->prepare("SELECT * FROM table_sizes where size_id = ?");
												$statement4->execute(array($size_id));

												$size_name = $statement4->fetch()["size_name"];
							?>		
												<li><a href="products.php?com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>&amp;size_id=<?php echo $size_id; ?>"><span><?php echo $size_name; ?></span></a></li>
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




					
					
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->