<?php
   include 'session.php';
   //include_once 'connection.php';
  class crud{
    public $alert = '';
    public $message = "";
    public $conn;
    
    public function __construct($conn) {
      $this->conn = $conn; // Store the connection object
    }

    //insertion deletion updation
    public function insert($username,$email,$dob){
      $sql = "INSERT INTO `user_info`(`Name`,`Email`,`DOB`)VALUES('$username','$email','$dob');";
      $result = $this->conn->query($sql);
      if(!$result){
        $this->alert = 'false';
        $this->message = $this->conn->connect_error;
        //die("insertion failed");
      }else{
        $this->alert = 'true';
        $this->message = "Data Inserted Successfully";

      }
    }

    public function update($sno,$name,$email,$dob){
      $sql = "UPDATE `user_info` SET `Name`='$name',`Email`='$email',`DOB`='$dob' WHERE `S.no`='$sno'";
      $result = $this->conn->query($sql);
      if($result){
          $this->alert = 'true';
          $this->message = "Data Updated Successfully";
      }
      else{
        $this->alert = 'false';
        $this->message = $this->conn->connect_error;
        //echo " Data not updated " . mysqli_error($conn);
      }
    }

    public function delete($sno){
      $sql = "DELETE FROM `user_info` WHERE `S.no`='$sno'";
      $result = $this->conn->query($sql);
      if($result){
          $this->alert = 'true';
          $this->message = "Data Deleted Successfully";

      }else{
        $this->alert = 'false';
        $this->message = $this->conn->connect_error;
        //echo "Data not deleted " . mysqli_error($conn);
      }
    }


  }
?>

