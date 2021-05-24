<?php
class berogailua{
 public $link='';
 function __construct($tenperatura, $hezetasuna, $balbula){
  $this->connect();
  $this->storeInDB($tenperatura, $hezetasuna, $balbula);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'esp32') or die('Cannot select the DB');
 }
 
 function storeInDB($tenperatura, $hezetasuna, $balbula){
  $query = "insert into berogailua set tenperatura='".$tenperatura."', hezetasuna='".$hezetasuna."', balbula='".$balbula."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['tenperatura'] != '' and  $_GET['hezetasuna'] != '' and  $_GET['balbula'] != ''){
 $berogailua=new berogailua($_GET['tenperatura'],$_GET['hezetasuna'],$_GET['balbula']);
}


?>