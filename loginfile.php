<?php
session_start();
include_once "conn.php";
if(isset($_SESSION['admin_username']))
{
  //header("Location:homepage");
}
else
{
  
}
  if(isset($_POST['login']))
  {
		  try {
		    $u=$_POST['username'];
		    $p=$_POST['password'];
            $stmt = $conn->prepare("SELECT * FROM login WHERE username=? and password=?");
            $stmt->bindValue(1,$u , PDO::PARAM_STR);
		    $stmt->bindValue(2,$p, PDO::PARAM_STR);
		    $stmt->execute();
		    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  		    
     if($row)
     {
           $_SESSION["admin_username"]=$_POST['username'];
           header("Location:home");
     }
  }
		catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
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


</head>

<body style="background:url('images/1234.jpg');  background-repeat:no-repeat; background-size:cover;">

  <div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <form method="post" action="">
            <h1 style="color:#fff;">Login Form</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" name="username" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" name="password" />
            </div>
            <div>
              <button class="btn btn-default submit" type="submit" name="login">Log in</button>
              
            </div>
            <div class="clearfix"></div>
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
     
        <!-- content -->
      </div>
    </div>
  </div>

</body>

</html>