<?php
require_once("conn.php");
$pid=$_POST['pid'];

    $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_id='$pid'");
	$stmt2->execute();
	$row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    if($row2)
    {
		?>
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Rate:<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input  type="text"  id="rate" name="rate"  value="<?php echo $row2[0]['sale_price'];?>" required="required" class="form-control col-md-7 col-xs-12">
        </div>
		<?php
        
    }     
?>