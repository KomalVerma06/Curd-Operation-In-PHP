<?php
    //session_start();
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      if(isset($_GET['record_per_page'])){ 
        //echo $_GET['record_per_page'];
        $_SESSION['records'] = $_GET['record_per_page'];  
      } 
    }
?>