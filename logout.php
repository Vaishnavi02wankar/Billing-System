<?php  
session_start(); 
session_unset(); 
session_destroy();  
header("Location:loginfile.php");//use for the redirection to some page  
?>