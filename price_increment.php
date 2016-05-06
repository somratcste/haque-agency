<?php
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
	header('location: index.php');
} 
include("header.php"); 
include("connection.php");
include ("left-sidebar-set.php") ;

if(!isset($_REQUEST['id'])) {
	header("location:manage-product.php");
}
else {
	$id = $_REQUEST['id'];
}

if(isset($_POST['form1'])) {


	try {
	
		

		if(empty($_POST['p_price'])) {
			throw new Exception("Price Cat not be empty");
			
		}
		else {
			$p_price = $_POST['p_price'];
		}

		$p_price_inc = 0 ;

		$statement = $db->prepare("SELECT p_price FROM table_products WHERE p_id=?");
		$statement->execute(array($id));
		$product_price = $statement->fetch()["p_price"];
		$p_price_inc = $product_price + $p_price ;
	



		$statement = $db->prepare("UPDATE table_products SET p_price = ? WHERE p_id =? ");
		$statement->execute(array($p_price_inc,$id));
		$success_message = "Price Increment has been successfully added.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}


}

?>

<?php
$statement = $db->prepare("SELECT p_price FROM table_products WHERE p_id=?");
$statement->execute(array($id));
$p_price = $statement->fetch()["p_price"];
?>

<div class="content-wrapper">
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Increment Price</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Product Price (Tk.) </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_price">
                </div>
              </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right" name="form1">UPDATE</button>
            </div><!-- /.box-footer -->
          </form>

        </div><!-- /.box -->
    </div>

    <div class="box box-default">
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Unit Price</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Product Price (Tk.) </label>
                <div class="col-sm-6">
                  <input type="email" class="form-control" id="inputEmail3" value="<?php echo $p_price ; ?>" readonly>
                </div>
              </div>

            </div><!-- /.box-body -->
             <div class="box-footer">
              <button class="btn btn-primary pull-right" onclick="history.go(-1);">Back</button>
            </div><!-- /.box-footer -->
          </form>

        </div><!-- /.box -->
    </div>


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>