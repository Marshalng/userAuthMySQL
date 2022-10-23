<?php
session_start();
//var_dump($_SESSION);

echo $_SESSION['username'];
logout();


function logout(){
  if ( isset($_SESSION['username'])) {
    session_destroy();

    header('Location: /userAuthMySql/forms/login.html');

  }


 
}

 
