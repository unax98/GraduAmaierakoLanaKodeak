<?php
class ikasgela{
 public $link='';
 function __construct($argia){
  $this->connect();
  $this->storeInDB($argia);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'esp32') or die('Cannot select the DB');
 }
 
 function storeInDB($argia){
  $query = "insert into ikasgela set argia='".$argia."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['argia'] != ''){
 $ikasgela=new ikasgela($_GET['argia']);
}


?>