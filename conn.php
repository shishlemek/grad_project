<?php
$servername='localhost';
$username='root';
$password='';
$dbname='dmsocial';
$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
    die("ERROR: Could not connect".mysql_error());
}
if(isset($_POST['submit'])){
    $username = $_POST['name'];
    $password = $_POST['pswd'];
    $sql = "INSERT INTO user VALUES ('$username','$password')";
    if(mysqli_query($conn, $sql)){
        echo "Inserted record successfully";
    }
    else{
        echo "ERROR: Sorry :".$sql."".mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>