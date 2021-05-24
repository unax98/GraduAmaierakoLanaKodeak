<?php
class korridorea{
 public $link='';
 function __construct($ldrBalioa, $tentsioa){
  $this->connect();
  $this->storeInDB($ldrBalioa, $tentsioa);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'esp32') or die('Cannot select the DB');
 }
 
 function storeInDB($ldrBalioa, $tentsioa){
  $query = "insert into korridorea set tentsioa='".$tentsioa."', ldrBalioa='".$ldrBalioa."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['ldrBalioa'] != '' and  $_GET['tentsioa'] != ''){
 $korridorea=new korridorea($_GET['ldrBalioa'],$_GET['tentsioa']);
}


?>