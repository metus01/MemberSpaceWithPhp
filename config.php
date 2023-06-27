<?php
/*$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
    $bdd = new PDO("mysql:host={$local};
dbname={$dbn};charset:utf8", 
$username ,$passwd);*/
/*/if(!isset($_SESSION['id']) && isset($_COOKIE['mail']) && isset($_COOKIE['password']) && !empty($_COOKIE['mail']) && !empty($_COOKIE['password']))
{
  $req_user = $bdd->prepare('SELECT * FROM membres WHERE mail  = ? AND password  = ?');
  $req_user->execute(array($_COOKIE['email'] , $_COOKIE['password']));
  $user_exist = $req_user->rowCount();
  if($user_exist ==1)
  {            
  $user_info = $req_user->fetch();
  $_SESSION['id'] = $user_info['id'];
  $_SESSION['pseudo'] = $user_info['pseudo'];
  $_SESSION['mail'] = $user_info['mail'];
  }
  
}*/
?>