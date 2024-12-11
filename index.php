<?php
    session_start();
    include 'session.php';
    include 'connection.php';
    include  'login.php';
    $connection = new connection();
    $conn = $connection->connect();

    $crud = new crud($conn);

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <!-- Modal edit-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <div class="mb-3">

              <input type="hidden" class="form-control" name="edit-sno" id="edit-sno" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">User Name</label>
              <input type="text" class="form-control" name="edit-username" id="edit-username"
                aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="edit-email" id="edit-email">
            </div>
            <div class="mb-3">
              <label for="dob" class="form-label">DOB</label>
              <input type="date" class="form-control" name="edit-dob" id="edit-dob">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal delete-->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <div class="mb-3">

              <input type="hidden" class="form-control" name="delete-sno" id="delete-sno" aria-describedby="emailHelp">
            </div>
            <p>Are you sure you want to delete this user?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!--login form-->
  <div class="container my-3">
    <?php 
        if($crud->alert == 'true' ){//&& $alerttype == 'success'){
       echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
       <strong>Success! </strong>'. $message .'
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>';
    }elseif($crud->alert == 'false'){ //&& $alerttype == 'danger'){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       <strong>Unsuccessful! </strong>'. $message .'
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>';
    }
  
    ?>
    <h1>Login form</h1>
    <form action="index.php" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">User Name</label>
        <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email">
      </div>
      <div class="mb-3">
        <label for="dob" class="form-label">DOB</label>
        <input type="date" class="form-control" name="dob" id="dob">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <?php
      
      if (isset($_GET['name'])) {
         $order = $_GET['name'];
       } elseif (isset($_GET['email'])) {
         $order = $_GET['email'];
       } elseif (isset($_GET['dob'])) {
         $order = $_GET['dob'];
       } else{
         $order = 'DESC';
       }
        
       //insertion deletion updation
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_POST['edit-sno'])){
    //echo $_POST['edit-sno'];
    $sno = $_POST['edit-sno'];
    $name = $_POST['edit-username'];
    $email = $_POST['edit-email'];
    $dob = $_POST['edit-dob'];
    $crud->update($sno,$name,$email,$dob);
  }
  elseif(isset($_POST['delete-sno'])){
    $sno = $_POST['delete-sno'];
    $crud->delete($sno);
  }
  else{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $crud->insert($username,$email,$dob);

  }
}

     //pagination
    echo'<form method="GET" action="index.php">
         <select name="record_per_page" id="record_per_page" class="dropdown col-md-4 offset-md-4">
         <option value="5">5</option>
         <option value="10">10</option>
         <option value="15">15</option>
         <option value="20">20</option>
         </select>
         <input type="submit" value="No. of rows" class="btn btn-primary">
       </form>';
      $record_per_page = $_SESSION['records'] ?? 5;
     if(isset($_GET['page']) && is_numeric($_GET['page'])){
       $current_page = $_GET['page'];
     }
     else{
       $current_page = 1;
     }
     $offset = ($current_page -1) * $record_per_page;
     $query = "SELECT COUNT(*) FROM user_info";
     $result = $conn->query($query);
     $row = $result->fetch_array();
     $total_records = $row[0];
     $total_pages = ceil($total_records/$record_per_page);
   
     $sql = "SELECT * FROM user_info ORDER BY `S.no` $order LIMIT $offset , $record_per_page;";
     $result = $conn->query($sql);
     if (!$result) {
         die("Query failed: " . $conn->connect_error()); 
     }
     $sno = 0;
     
     if ($result->num_rows > 0) {
         echo"<div class='container'><table class='table'>
         <thead>
           <tr>
             <th scope='col'>S.no</th>
             <th scope='col'>Name <a href='?name=asc'>ASC</a> <a href='?name=desc'>DESC</a></th>
             <th scope='col'>Email <a href='?email=asc'>ASC</a> <a href='?email=desc'>DESC</a></th>
             <th scope='col'>DOB <a href='?dob=asc'>ASC</a> <a href='?dob=desc'>DESC</a></th>
             <th scope='col'>Actions</th>
           </tr>
         </thead>";
         while($row = $result->fetch_assoc()) {
                     $sno++;
                   echo "<tbody class='table-group-divider'>
                   <tr>
                           <td>" . $sno . "</td>
                           <td>" . $row["Name"] . "</td>
                           <td>" . $row["Email"] . "</td>
                           <td>" . $row["DOB"] . "</td> 
                           <td><button type='button' class='btn btn-primary edit' id='" .$row['S.no']. "'data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button> 
                               <button type='button' class='btn btn-primary delete' id='" .$row['S.no']. "'data-bs-toggle='modal' data-bs-target='#exampleModal1'>Delete</button>
                           </td>
                   </tr>
                   </tbody>";
   
           
         }
         echo "</table></div>";
         
     } 
     else {
         echo "0 results";
     }
   
     $page_limit = isset($_GET['record_per_page']) ? '&record_per_page='.$_GET['record_per_page'] : '';  
     echo '<nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
          <li class="page-item">';
        if($current_page > 1){
          echo '<a class="page-link" href="?page='.($current_page-1).$page_limit.'">Previous</a>';
        }
        echo '</li>';
    
      for($page = 1; $page <= $total_pages; $page++){
        if ($page == $current_page) {
          echo "<li class='page-item active'><span class='page-link'>$page</span></li>";
        } 
        else {
          echo '<li class="page-item"><a class="page-link" href="?page='.$page.$page_limit.'">'.$page.'</a></li>';
        }
      }
  
      if ($current_page < $total_pages) {
        echo'<li class="page-item">
              <a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a>
            </li>';
      }
      echo '</ul>
            </nav>';

   //echo $record_per_page;
   //echo $alert;
?>

<script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {

        row = e.target.parentNode.parentNode;
        username = row.getElementsByTagName("td")[1].innerHTML;
        email = row.getElementsByTagName("td")[2].innerHTML;
        dob = row.getElementsByTagName("td")[3].innerHTML;

        document.getElementById("edit-username").value = username;
        document.getElementById("edit-email").value = email;
        document.getElementById("edit-dob").value = dob;
        document.getElementById("edit-sno").value = e.target.id;

        console.log("edit", e.target.id);
      })
    });

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit", e.target.id);
        document.getElementById("delete-sno").value = e.target.id;
      })
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous">
</script>
</body>
</html>