<?php
session_start();
$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
$bdd = new PDO("mysql:host={$local};dbname={$dbn};charset:utf8", $username, $passwd);
if (isset($_GET['id']) && $_GET['id'] > 0) {
  $get_id = intval($_GET['id']);
  $req_user = $bdd->prepare('SELECT * FROM membres WHERE id= ?');
  $req_user->execute(array($get_id));
  $user_info = $req_user->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
</head>

<body style="text-align:center">
  <div style="text-align:center" >
    <h2>Profil de <?php echo $user_info['pseudo']; ?></h2><br><br>
    <?php
    if (!empty($user_info['avatar'])) {
    ?>
      <img src="membres/avatar/<?php echo $user_info['avatar']; ?>" alt="" width="100px" height="100px">
    <?php
    }

    ?>
    <?php if (isset($_SESSION["id"]) && $_SESSION["id"] != $get_id) : $isfollowing = $bdd->prepare("SELECT * FROM follow WHERE  id_follower = ? AND id_following  = ?");
      $isfollowing->execute(array($_SESSION["id"], $get_id));
      $isfollowing = $isfollowing->rowCount();
      if ($isfollowing > 0) {
    ?>
        <a href="follow.php?followed_id=<?= $get_id ?>"> Vous suivez dejà cette personne ...Ne plus Suivre cette personne</a> <br>
        <br>
      <?php } else {
      ?>
        <a href="follow.php?followed_id=<?= $get_id ?>">Suivre cette personne</a> <br>
        <br>
      <?php
      }
      ?>

    <?php
    endif;
    ?>
    Pseudo = .....<?php echo $user_info['pseudo']; ?>
    <br>
    Mail = .......<?php echo $user_info['mail']; ?><br>
    <br>
    Nombre de Parrainage : 
    <?php
    $parrainages = $bdd->prepare("SELECT * FROM  membres WHERE id_parrain = ?");
    $parrainages->execute(array($get_id));
    $parrainages = $parrainages->rowCount();
    echo $parrainages;
    ?>
    <br>
  </div>
  <?php
  if (isset($_SESSION['id']) &&    $user_info['id'] ==  $_SESSION['id']) {
  ?>
    <ul>
      Parrainer un ami: inscription.php?p=<?= $user_info["uniqid"] ?>
    </ul>
    <a href="editionprofil.php">Editer un profil</a>
    <a href="deconnexion.php">Se déconnecter</a>
    <a href="envoie.php">Envoie de Messages privées</a>
  <?php
  }
  ?>
</body>

</html>