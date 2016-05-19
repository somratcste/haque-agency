

/* ===================== Pagination Code Starts ================== */
<?php 
			$adjacents = 7;
										
			
			$statement = $db->prepare("SELECT * FROM tbl_add_post ORDER BY post_id DESC");
			$statement->execute();
			$total_pages = $statement->rowCount();
							
			
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 3;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
						
			$statement = $db->prepare("SELECT * FROM tbl_add_post ORDER BY post_id DESC LIMIT $start, $limit");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}


/* ===================== Pagination Code Ends ================== */

<div class="pagination">
<?php 
echo $pagination; 
?>
</div>



?>
/* ====================== Pagination Style Starts ====================== */

div.pagination {
    padding: 3px;
    margin: 3px;
	z-index: 1000;
	font-size: 14px;
	margin-bottom: 20px;	
}

div.pagination a {
    padding: 5px 7px;
    margin: 2px;
    border: 1px solid #A6A6A6;
    text-decoration: none; /* no underline */
	background-color: #0C86AC;
    color: #fff;
	font-weight: bold;
}

div.pagination a:hover, div.pagination a:active {
    border: 1px solid #A6A6A6;
    color: #FD5E1C;
	background-color: #0C86AC;
}

div.pagination span.current {
    padding: 9px 9px;
    margin: 2px;
	border: 1px solid #A6A6A6;
	font-weight: bold;
	background-color: #0C86AC;
	color: #FD5E1C;
	font-size: 18px;
}

div.pagination span.disabled {
	padding: 5px 7px;
	margin: 2px;
	border: 1px solid #A6A6A6;
	color: #000;
}
/* ====================== Pagination Style Ends ====================== */	



/*======================= Database insert query Starts======================== */
<?php

$statement = $db->prepare("INSERT INTO tbl_add_post (post_title,post_description,post_img,cat_id,tag_id,post_date,post_timestamp) VALUES (?,?,?,?,?,?,?)");
		
$statement->execute(array($_POST['post_title'],$_POST['description'],$f1,$_POST['cat_id'], $tag_ids,$post_date,$post_timestamp));
?>

/*======================= Database insert query End======================== */



/*======================Database select/search query Starts========================*/
<?php

$statement = $db->prepare("SELECT * FROM tbl_add_post WHERE id = ?");
$statement->execute(array($id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
	echo $row['post_title'];
		}

?>
/*======================Database select/search query End========================*/



/*======================Database update query Starts========================*/
<?php

$statement = $db->prepare("UPDATE tbl_add_post SET post_title=?,post_description=?,post_img=?,cat_id=?,tag_id=? WHERE post_id=?");
$statement->execute(array($_POST['edit_title'],$_POST['edit_description'],$f1,$_POST['cat_id'],$tag_ids,$id));

?>

/*======================Database update query Ends========================*/



/*======================Database Delete query stars========================*/
<?php

$statement = $db->prepare("SELECT * FROM tbl_add_post WHERE post_id=?");
$statement->execute(array($id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$real_path = "../uploads/".$row['post_img'];
	unlink($real_path);
}

$statement = $db->prepare("DELETE FROM tbl_add_post WHERE post_id=?");
$statement->execute(array($id));

?>

/*======================Database delete query Ends========================*/


/*======================Upload Image/File>3MB Starts==============================*/
<?php

    $up_filename = $_FILES["post_img"]["name"];
    $file_basename = substr($up_filename, 0, strripos($up_filename, '.'));
    $file_ext = substr($up_filename, strripos($up_filename,'.'));
    $f1 = $file_basename . $file_ext;

    if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif')&&($file_ext!='.JPEG')&&($file_ext!='.JPG'))
    {
      throw new Exception("Only jpg , jpeg , png , gif format images are allowed for all images.");
    }
      $post_date = date('Y-m-d');

      $tempName = $_FILES["post_img"]["tmp_name"];
      $pathAndName = "../uploads/".$f1;
      $moveResult = move_uploaded_file($tempName, $pathAndName);

      if($moveResult == true){
         

          $statement = $db->prepare("INSERT INTO tbl_photo_galary (photo_name,photo_caption,cat_id,date) VALUES (?,?,?,?)");
          $statement->execute(array($f1,$_POST['caption_text'],$_POST['cat_id'],$post_date));
          $success_message = "Photo Added Successfully";
          
      }
      else{
        throw new Exception("File cannot be moved");
      }

 ?>
/*======================Upload Image/File>3MB Ends==============================*/




/*======================Stick a div Starts========================*/

first call this js file...

       <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
then....

 <script type="text/javascript">
	$(document).ready(function() {
     	var s = $("#sticker");
     	var pos = s.position();                         
     	$(window).scroll(function() {
          var windowpos = $(window).scrollTop();
          if (windowpos >= pos.top) {
               s.addClass("stick");
          } else {
               s.removeClass("stick");  
          }
     	});
      });

</script>




.stick{
	position: fixed;
	z-index: 99999999;
	top: 0px;
	width: 100%;
} 
/*======================Stick a div Ends========================*/


/* ======================= config.php ==========================*/

<?php 
$dbhost = 'localhost';
$dbname = 'worddb';
$dbuser = 'root';
$dbpass = '';

try {
	$db = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
	echo "Connection error: ".$e->getMessage();
}
?>

/* ==================== config file end ====================*/ 


/* ===================== Delete one ========================*/

<?php 
require_once 'connection.php';
$id = $_REQUEST['id'];
$statement = $db->prepare("DELETE FROM wordtable where id=?");
$statement->execute(array($id));
if($statement)
	echo "<script>window.open('list.php','_self')</script>";

?>
/* ===================== Delete end fiel ======================*/



/* =================== Check input data ======================= */
<?php 

$word = test_input($_POST['word']);
$synonyms = test_input($_POST['synonyms']);
$sentence = test_input($_POST['sentence']);


function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>

/* ================ End check input data =====================*/ 


/* =================== Check request id ===================== */

<?php

if(!isset($_REQUEST['id'])) {
	header("location: index.php");
}
else {
	$id = $_REQUEST['id'];
}

?>

/* ================== End check request id =================== */ 

/* ================== include =================== */ 

<?php include("header.php"); ?>

/* ================== End include=================== */ 

/*================== fetching single row ==========*/
<?php
$statement3 = $db->prepare("SELECT * FROM table_categories WHERE cat_id = ?");
$statement3->execute(array($category_id));

$category_name = $statement3->fetch()["cat_name"];
?>

/*================ fetch single row ============== */

/*=============== find total ===================== */
<?php 				 
require_once('config.php');
$statement = $db->prepare("SELECT sum(amount) FROM `order`");
$statement->execute();

echo $result;
?>

/* =============== sum / aggregate function ====== */