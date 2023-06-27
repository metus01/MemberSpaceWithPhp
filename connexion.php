<?php
session_start();
include_once('config.php');
$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
    $bdd = new PDO("mysql:host={$local};
dbname={$dbn};charset:utf8", 
$username ,$passwd);
if(isset($_POST['connexion']))
{
  $mail_connect = htmlspecialchars($_POST['mail']);
  $pass_connect =sha1( htmlspecialchars($_POST['password']));
  if(!empty($mail_connect) &&   !empty($pass_connect))
  {
       $req_user = $bdd->prepare('SELECT * FROM membres WHERE mail  = ? AND password  = ?');
       $req_user->execute(array($mail_connect , $pass_connect));
       $user_exist = $req_user->rowCount();
       if($user_exist ==1)
       {         if($_POST['rappel']){
        setcookie('email' , $mail_connect , time()+365*24*3600 , null , null , false , true);
        setcookie('password' , $pass_connect , time()+365*24*3600 , 
null , null , false , true);
       }
                 $user_info = $req_user->fetch();
                 $_SESSION['id'] = $user_info['id'];
                 $_SESSION['pseudo'] = $user_info['pseudo'];
                 $_SESSION['mail'] = $user_info['mail'];
                 header('Location:users.php ?id='.$_SESSION['id']);
                 //transition vers le profil de la personne

       }
       else
       {
        $erreur = "Identifiant ou mot de passe incorrect";
       }
  }
  else
  {
    $erreur = "Tous les champs doivent être remplis";

  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
</head>
<body>
  <form action="" method="post">
    <label for="mail">Email</label><br>
    <input type="email" name="mail" id="" placeholder="mail"><br>
    <label for="password">Mot de Passe</label><br>
    <input type="password" name="password" id="" placeholder="mot de passe"><br>
    <input type="checkbox" name="rappel" id="rappel" ><label for="rappel">Se souvenir de Moi</label><br>
    <input type="submit" value="Connexion" name="connexion"><br>
  </form>
  <?php
  if(isset($erreur))
  {
    echo '<font color="red">' .$erreur .'</font>';
  }
  ?>
</body>
</html>