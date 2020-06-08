<?php
  $insert = false;
  $update = false;
  $delete = false;

//Using database to connect php scripts.
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "enote";

  //Create connection
  $con = mysqli_connect($servername, $username, $password, $dbname);

  //Check connection
  if (!$con) {
    die("Failed to connect.".mysqli_connect_error());
  }

  if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;

    $sql = "DELETE FROM `notes` WHERE `SN` = $sno";
    $result = mysqli_query($con, $sql);

    if ($delete) {
      $delete = true;
    }else{
      echo "Error";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["snEdit"])) {
      //Update the data
      $sn = $_POST["snEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];

      $sql = "UPDATE `notes` SET `Title` = '$title', `Description` = '$description' WHERE `notes`.`SN` = $sn";

       $result = mysqli_query($con, $sql);       
    
    if ($result) {
      $update = true;
    }
    else {
      echo "<br>Error";
    }
    }
    else{
      //Insert data into the table
      $title = $_POST["title"];
      $description = $_POST["description"];

      $sql = "INSERT INTO `notes` (`Title`, `Description`, `Tstamp`)
              VALUES ('$title', '$description', current_timestamp())";
      $result = mysqli_query($con, $sql);

  //Checking data insertion into database table
    if ($result){
      $insert = true;
    }else {
        echo "<br>Error inserting data into database table due to the error:<br>".mysqli_error($con);
    }
  }
  }
 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <title>eNote</title>
  </head>
  <body>
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
Edit Modal</button> -->
<div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="/enote/index.php" method="post">
          <input type="hidden" name="snEdit" id="snEdit">
        <div class="form-group">
          <label for="title"><strong>Title</strong></label>
          <input type="titleEdit" class="form-control" id="titleEdit" name="titleEdit">
        </div>
        <div class="form-group">
          <label for="description"><strong>Description</strong></label>
          <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
        </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
          </form>
      </div>
  </div>
</div>

  <div class="container bg-info text-white text-center py-2 border border-success rounded">
    <h1 class="display-1 "><kbd class="border border-warning">eNote</kbd></h1>
  </div>
<!-- 
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">eNote</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse"
              data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Contacts
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav> -->
    <div class="container my-4">
    <?php

    if ($insert) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has successfully been recorded.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    if ($update) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has successfully been updated.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    if ($delete) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has successfully been deleted.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
     ?>
     </div>
    <div class="container my-4">
      <h3>Add a note</h3><hr>
      <form action="/enote/index.php" method="post">
        <div class="form-group">
          <label for="title"><strong>Title</strong></label>
          <input type="title" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
          <label for="description"><strong>Description</strong></label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>
    <div class="container">
<hr>
  <table class="table-responsive-lg table-striped table-bordered" id="myTable">
    <thead>
      <tr>
        <th scope="col">S.No.</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>

  <tbody>
    <?php
    $sql = "SELECT * FROM `notes`";
    $result = mysqli_query($con, $sql);
    $sno=0;
    while ($row = mysqli_fetch_assoc($result)) {
      //echo $row['SN']. ". Title: " .$row['Title']. ". Desc is: " .$row['Description'];
      $sno+=1;
      echo "<tr>
      <th scope='row'>". $sno ."</th>
      <td>". $row['Title'] ."</td>
      <td>". $row['Description'] ."</td>
      <td><button class='edit btn btn-sm btn-primary' id=". $row['SN'] .">Edit</button>
          <button class='delete btn btn-sm btn-danger' id=d". $row['SN'] .">Delete</button>    </tr>";
  }
    ?>
  </tbody>
  

</table>
<br>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) =>{
          console.log("edit", );
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          descriptionEdit.value = description;
          titleEdit.value = title;
          snEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
          })
      })
      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) =>{
          console.log("delete ", );
          sno = e.target.id.substr(1, );
          if (confirm("Are you sure you want to delete?")) {
            console.log("Yes");
            window.location = `/enote/index.php?delete=${sno}`;
          }else{
            console.log("No");
          }
          })
      })
    </script>
  </body>
</html>
