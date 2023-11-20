<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_borrow.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>borrowed books</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> borrowed books </h1>

   <div class="box-container">
      <?php
          $select_book_name = mysqli_query($conn, "SELECT * FROM `borrowing_data`") or die('query failed');
           while($fetch_book_name = mysqli_fetch_assoc($select_book_name)){
      ?>
      <div class="box">
         <p> user_name : <span><?php echo $fetch_book_name['id']; ?></span> </p>
         <p> email : <span><?php echo $fetch_book_name['email']; ?></span> </p>
         <p> book_name : <span><?php echo $fetch_book_name['book_name']; ?></span> </p>
         <p> borrow_date : <span><?php echo $fetch_book_name['borrow_date']; ?></span> </p>
         <p> return_date : <span><?php echo $fetch_book_name['return_date']; ?></span> </p>
         
         <!-- <a href="admin_borrow.php?delete=<?php echo $fetch_book_name['book_name']; ?>" onclick="return confirm('delete this ?');" class="delete-btn">delete </a> -->
      </div>
      <?php
         };
      ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>