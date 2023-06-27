<?php
session_start();
if(isset($_SESSION["id"]))
{
  include_once('config.php');
  $username = 'root';
  $passwd = "";
  $dbn = "m_space";
  $local = "localhost";
  error_reporting(E_ALL);
      $bdd = new PDO("mysql:host={$local};
  dbname={$dbn};charset:utf8", 
  $username ,$passwd);
  $msg = $bdd->prepare("SELECT * FROM messages WHERE id_receveur = :id_recever ");
  $msg->bindValue(":id_recever" , $_SESSION["id"]);
  $msg->execute();
  $msg_nbr = $msg->rowCount();
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MESSAGES</title>
</head>
<body>
  <a href="envoie.php"> Nouveau Message</a> <br>
  <br>
  <h3>Votre Boîte de reception </h3> 
  <?php
  if($msg_nbr  == 0)
  {
    $message = " Aucun message dans la boîte de reception......";
    echo $message;
  }else{
  while($m = $msg->fetch())
  {
    $pseudo_exp = $bdd->prepare("SELECT pseudo FROM membres WHERE id = ?");
    $pseudo_exp->execute(array($m['id_sender']));
    $pseudo_exp = $pseudo_exp->fetch();
    $pseudo_exp = $pseudo_exp['pseudo'];
    ?>
    <b><?= $pseudo_exp ?></b> Vous a envoyé : <br>
    <?= nl2br($m["message"]) ?>
  <?php
  }
}
  ?>
</body>
</html>
<?php
}
else
{
   header("Location:".$_SERVER["HTTP_REFERER"]);
}
  ?>