<?php
  require_once "../../controller/operator.php";
  if(isset($_POST["login"])){
   	login($_POST);
   	if (session_status() == 2){
   		header("Location:../lead/list.php");
   	}
    else header("Location:../../index.php");
    die();
  }
  logout();
  header("Location:../../index.php");
  die();
?>