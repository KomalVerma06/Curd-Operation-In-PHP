<?php
class connection{
 public function connect(){
   $conn = new mysqli("localhost","root","","form-task1");
   if($conn->connect_error){
     die("connection failed". $conn->connect_error);
  }
  return $conn;
}
}
?>



