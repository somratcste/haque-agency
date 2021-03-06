<?php 
ob_start();
session_start();
error_reporting(0);
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("head.php"); 
include("../connection.php");


if(isset($_POST['search']))
{
  try {
    
    if(empty($_POST['typeahead'])) {
      throw new Exception("Nothing to Search");
    } else {
      $search = $_POST['typeahead'];
    }
    
    $statement = $db->prepare("SELECT * FROM table_products WHERE p_name=?");
    $statement->execute(array($_POST['typeahead']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $com_id = $row['com_id'];
      $cat_id = $row['cat_id'];
      $size_id = $row['size_id'];
      $p_id = $row['p_id'];
    }


    $statement3 = $db->prepare("SELECT * FROM table_companies WHERE com_id = ?");
    $statement3->execute(array($com_id));
    $company_name = $statement3->fetch()["com_name"];

    $statement3 = $db->prepare("SELECT * FROM table_categories WHERE cat_id = ?");
    $statement3->execute(array($cat_id));
    $category_name = $statement3->fetch()["cat_name"];

    $statement3 = $db->prepare("SELECT * FROM table_sizes WHERE size_id = ?");
    $statement3->execute(array($size_id));
    $size_name = $statement3->fetch()["size_name"];
    
    
    $success_message = "See Your Search Result";
    
  
  }


  
  catch(Exception $e) { 
    $error_message = $e->getMessage();
  }
}

?>




<div class="content-wrapper">
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Searching Product</h3>
          </div><!-- /.box-header -->
            
           <?php
              if(isset($error_message))
              { ?>
                <div class="alert alert-danger">
                    <p class=""><?php echo $error_message ; ?></p>
                </div>
            <?php 
               } 
             else if(isset($success_message))
              { ?>
                <div class="alert alert-success">
                    <p class=""><?php echo $success_message ; ?></p>
                </div>
            <?php } ?>
          
            <div class="box-body">
              <div class="row col-md-6 col-md-offset-3" >
              
              <form action="" method="post" enctype="multipart/form-data">
                <div class="input-group bs-example">

                  <input type="text"  name="typeahead" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Search By Product Name... "> <br><br>
    
                 <button type="submit" name="search" class="btn btn-primary pull-right">Search</button>
                </div>
                
              </form>

              
              <!-- /.search form -->
             
              </div>

            </div><!-- /.box-body -->
            
         

          

        </div><!-- /.box -->
    </div>






   <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div align="center" class="box-header with-border">
                  <h3 class="box-title"><?php echo $company_name; ?> / <?php echo $category_name; ?> / <?php echo $size_name; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="table-responsive">  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Price</th>                      
                        <th>Cartoon</th>
                        <th>Piece</th>
                        <th>View</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>

          <?php
        $i=0;
        $statement = $db->prepare("SELECT * FROM table_products WHERE com_id = ? AND cat_id = ? AND size_id = ? AND p_id = ?");
        $statement->execute(array($com_id,$cat_id,$size_id,$p_id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row)
        {
          $i++;
          ?>

            <tr>
              <td><?php echo $i ; ?></td>
                  <td><?php echo $row['p_name']; ?></td>
                  <td><?php echo $row['p_price']; ?></td>
                  

                  <td><?php echo $row['p_cartoon']; ?></td>
                  <td><?php echo $row['p_peice']; ?></td>
                  <td><img src="../dist/img/view.jpg" data-toggle="modal" data-target="#viewModal<?php echo $i ; ?>"></td>


                  
                  <!--product view Modal -->
                  <div class="modal fade" id="viewModal<?php echo $i ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">View Product Details</h4>
                        </div>
                        <div class="modal-body">
                        <p><b>Product Name <span style="margin-left:4em"></span> :</b> <?php echo $row['p_name'] ; ?> </p>

                        <p><b>Selected Company <span style="margin-left:2em"></span> : </b>
                        <?php
                        $statement1 = $db->prepare("SELECT * FROM table_companies WHERE com_id=?");
                        $statement1->execute(array($row['com_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['com_name'];
                        }
                        ?>
                        </p> 

                        <p><b>Selected Category<span style="margin-left:2.2em"></span> : </b>
                        <?php
                        $statement1 = $db->prepare("SELECT * FROM table_categories WHERE cat_id=?");
                        $statement1->execute(array($row['cat_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['cat_name'];
                        }
                        ?>
                        </p>

                        <p><b>Selected Size<span style="margin-left:4.4em"></span> : </b>
                        <?php
                        $statement1 = $db->prepare("SELECT * FROM table_sizes WHERE size_id=?");
                        $statement1->execute(array($row['size_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['size_name'];
                        }
                        ?>
                        </p>

                        <p><b>Price<span style="margin-left:7.9em"></span> : </b><?php echo $row['p_price']; ?> Tk/-</p>
                        <p><b>Featured Image</b><img src="../dist/img/product-images/<?php echo $row['p_image']; ?>" alt="" class="img-responsive" width="304" height="236"></p>
                        <p><b>Cartoon <span style="margin-left:6.7em"></span> : </b><?php echo $row['p_cartoon']; ?></p>
                        <p><b>Piece <span style="margin-left:7.9em"></span> : </b><?php echo $row['p_peice']; ?></p>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--End product view Modal -->

                  <td><a href="product-entry.php?id=<?php echo $row['p_id'];?>" > <img src="../dist/img/price_up.png" alt="" title="" border="0" /></a> || <a href="product-delivary.php?id=<?php echo $row['p_id'];?>" ><img src="../dist/img/price_down.png" alt="" title="" border="0" /></a> </td>

              </tr>
              
          <?php

            }

          ?>
        
              
          </tbody>
                    
        <tfoot>
           <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Price</th>                      
              <th>Cartoon</th>
              <th>Piece</th>
              <th>View</th>
              <th>Action</th>
            </tr>
        </tfoot>
      </table>
    </div><!-- /.box-body -->
    </div>
  </div><!-- /.box -->
</div>
</div>






  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("foo.php"); ?>