<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bird_park";

$conn = mysqli_connect($servername,$username,$password,"$dbname");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

  if(isset($_POST["save_contact"])){
    $name=$_POST["name"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $msg=$_POST["message"];
    
    $insert="INSERT INTO `tbl_contact`(`name`, `email`, `phone`, `msg`) VALUES 
    ('$name','$email','$phone','$msg')";
              // echo $insert;
    $result=mysqli_query($conn,$insert); 
    if($result){
        echo "<script> location.href='index.html'; alert('Thank You, Our team will get back to you soon..');</script>"; 
    }else{
        echo "<script> location.href='index.html';  alert('Something went wrong !! Please try again..');</script>";
    } 
  }

?>