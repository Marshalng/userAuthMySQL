<?php
session_start();
require_once "../config.php";

     
//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    $query = $conn->query("SELECT * FROM Students WHERE email ='$email'");

    //check if user with this email already exist in the database
    if ($query->num_rows > 0) {
     echo "Email already exist";
        exit();
    }

    $query = $conn->query("INSERT INTO Students (full_names,country,email,gender,password) VALUES ('$fullnames','$country','$email','$gender','$password')");
    if ($query === true){

        echo ('User Successfully registered');
    }else {

        echo $conn->error;
    }
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
  //open connection to the database and check if username exist in the database
    $query = $conn->query("SELECT * FROM Students WHERE email ='$email' AND password='$password'");
    if ($query->num_rows > 0){
        $result = $query->fetch_assoc();
        $_SESSION['username'] = $result['full_names'];
        header('Location: /userAuthMySQL/dashboard.php');
    }else {

        header('Location: /userAuthMySQL/forms/login.html');
    }
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $checkUser = $conn->query("SELECT * FROM Students WHERE email ='$email'");
    if ($checkUser->num_rows > 0){
        $updatePassword = $conn->query("UPDATE Students SET password ='$password' WHERE email='$email'");
        if ($updatePassword == true){
            echo "Password updated";
        }
    } else {
        echo "User does not exist";
        exit();
    }
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
 //   var_dump($id);
     $conn = db();
     //delete user with the given id from the database
     $query = $conn->query("DELETE FROM Students WHERE id ='$id'");
    if ($query == true ){
            echo "User Deleted";
    }
 }
