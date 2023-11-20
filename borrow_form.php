<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'shop_db');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = '';

if (isset($_POST['add_to_borrowed'])) {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $book_name = $_POST['book_name'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    $borrowing_query = "SELECT * FROM `borrowing_data` WHERE email='$email' AND book_name='$book_name'";
    $result = mysqli_query($conn, $borrowing_query);
   
$result = mysqli_query($conn, $borrowing_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $message = 'Book already borrowed!';
    } else {
        $insert_query = "INSERT INTO `borrowing_data` (user_name, email, book_name, borrow_date, return_date) VALUES ('$user_name', '$email', '$book_name', '$borrow_date', '$return_date')";
        if (mysqli_query($conn, $insert_query)) {
            $message = 'Book borrowed successfully!';
           
            header('location:borrow.php');
        } else {
            $message = 'Failed to borrow. Please try again later.';
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Borrowing Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
 
<body>
   
    <?php
    if ($message !== '') {
        echo '<p>' . $message . '</p>';
    }
    ?>

     <div class="form-container">

     <form method="post" style="background-image: ../home-bg.jpg;">
        <h3>Borrowing Form</h3>
        <label for="user_name" style="font-size: 20px;">User Name:</label>
        <input type="text" name="user_name" required  class="box">

        <label for="email" style="font-size: 20px;">Email:</label>
        <input type="email" name="email" required  class="box">

        <label for="book_name" style="font-size: 20px;">Book Name:</label>
        <input type="text" name="book_name" required  class="box">

        <label for="borrow_date"style="font-size: 20px;">Borrowing Date:</label>
        <input type="date" name="borrow_date" required  class="box">

        <label for="return_date" style="font-size: 20px;">Return Date:</label>
        <input type="date" name="return_date" required  class="box">

        <a href="borrow.php"><input type="submit" name="add_to_borrowed" value="Borrow" class="btn"></a>
    </form>
     </div>
    
</body>

</html>
