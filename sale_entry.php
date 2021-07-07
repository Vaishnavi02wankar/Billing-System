<?php 
session_start();
include_once "conn.php";
date_default_timezone_set("Asia/kolkata");

if(isset($_POST['submit']))
{
	extract($_POST);
	//print_r($_POST);exit;	
try{
        $stmt = $conn->prepare("INSERT INTO `sale`(`date`,`invoice`,`customer_id`,`product_id`,`quantity`,`rate`,`amount`) VALUES(:date,:invoice,:customer_id,:product_id,:quantity,:rate,:amount)");

		$executed=$stmt->execute(array(':date' => $date,':invoice' => $invoice,':customer_id' => $customer_id,':product_id' => $product_id,':quantity'=> $quantity,':rate'=> $rate,':amount'=> $amount));
			   if($executed)
			   {
                  echo "<script>alert('Added Successfully!!!')</script>" ;
				  echo "<script>window.location.href='sale_entry_list';</script>" ;
			   }
			   
	}catch(Exception $e) {
	  echo 'Message: ' .$e->getMessage();
	}
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Billing System</title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

		<!-- /top navigation -->
			<?php require "header.php"?>
		  <!-- /top navigation -->
		
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Sale Entry</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="" enctype="multipart/form-data">
				     <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Date<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="birthday1" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" name="date">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Invoice:<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" name="invoice" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
					<?php
					  $stmt_customer=$conn->prepare("SELECT * FROM customers");
					  $stmt_customer->execute();
					  $row_customer=$stmt_customer->fetchAll(PDO::FETCH_ASSOC);
					?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Name:<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                       <!-- <input type="text" id="first-name" name="vendor_name" required="required" class="form-control col-md-7 col-xs-12">-->
						 <select class="form-control" id="subject" name="customer_id" onchange="get_test_list(this)">
							<option>--Select Customer Name--</option>
							<?php
							for($i1=0;$i1<count($row_customer);$i1++)
						    {
							  $oid1=$row_customer[$i1]['customer_id'];						
							?>
							<option value="<?php echo $row_customer[$i1]['customer_id'];?>"><?php echo $row_customer[$i1]['customer_name'];?></option>
						    <?php
						    }
						   ?>
						</select>
                      </div>
                    </div>
					<?php
					  $stmt_product=$conn->prepare("SELECT * FROM products");
					  $stmt_product->execute();
					  $row_product=$stmt_product->fetchAll(PDO::FETCH_ASSOC);
					?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product:<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
						 <select class="form-control" id="subject" name="product_id" onchange="get_product_rate(this.value)">
							<option>--Select Product--</option>
							<?php
							for($i=0;$i<count($row_product);$i++)
						    {
							  $oid=$row_product[$i]['product_id'];						
							?>
							<option value="<?php echo $row_product[$i]['product_id'];?>"><?php echo $row_product[$i]['product_name'];?></option>
						    <?php
						    }
						   ?>
						</select>
							<script type="text/javascript">
        function get_product_rate(pid) 
        {
			//alert(pid);
            $.ajax({
                type: "POST",
                url: "ajax_get_sale_rate.php",
                data: {pid:pid},
                cache: false,
                //dataType: 'json',
                success: function(html){
                //alert(html);
                if(html=='0')
                {
                    alert("There is some error.");
                }
                else
                {
                    $("#rate_div").html(html);
                }
                                        
            }

           });
        }
        </script>
                      </div>
                    </div>
					 <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quantity:<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                         <input  type="number" min="0" id="quantity" name="quantity" required="required" class="form-control col-md-7 col-xs-12" onblur="func_get_total_amount(this.value)">
                      </div>
                    </div>
					<script>
					function func_get_total_amount(quantity)
					{
						//alert(quantity);
						var rate=document.getElementById('rate').value;
						var total_amount=quantity*rate;
						document.getElementById('amount').value=total_amount;
					}
					</script>
					 <div class="form-group" id="rate_div">
                      
                    </div>
					 <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Amount:<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="text"  id="amount" name="amount" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                       <a href="javascript:history.back()" class="btn btn-primary">Cancel</a>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <script type="text/javascript">
            $(document).ready(function() {
              $('#birthday1').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
            });
          </script>
		  <script type="text/javascript">
            $(document).ready(function() {
              $('#birthday').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
            });
          </script>
		  

        </div>

		<!-- footer content -->
          <?php require "footer.php"?>
        <!-- /footer content -->
        
      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>

</body>

</html>






