<?php
session_start();
include_once('config.php');
$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
$bdd = new PDO(
  "mysql:host={$local};
dbname={$dbn};charset:utf8",
  $username,
  $passwd
);
if (isset($_SESSION['id'])) {
  $req_user = $bdd->prepare('SELECT * FROM membres WHERE id=?');
  $req_user->execute(array($_SESSION['id']));
  $user = $req_user->fetch();
  if (isset($_POST['newpseudo']) &&  !empty($_POST['newpseudo']) && $_POST['newpseudo']  !=  $user['pseudo']) {
    $newpseudo = htmlspecialchars($_POST['newpseudo']);
    $insert_pseudo = $bdd->prepare('UPDATE membres  SET pseudo=? WHERE id=? ');
    $insert_pseudo->execute(array($newpseudo), $_SESSION['id']);
    header('Location:profil.php?id=' . $_SESSION['id']);
  }
  if (isset($_POST['newpseudo']) &&  !empty($_POST['newpseudo']) && $_POST['newpseudo']  !=  $user['pseudo']) {
    $newpseudo = htmlspecialchars($_POST['newpseudo']);
    $insert_pseudo = $bdd->prepare('UPDATE membres  SET 
pseudo=? WHERE id=? ');
    $insert_pseudo->execute(array($newpseudo), $_SESSION['id']);
    header('Location:profil.php?id=' . $_SESSION['id']);
  }
  if (isset($_POST['newmail']) &&  !empty($_POST['newmail']) && $_POST['newmail']  !=  $user['mail']) {
    $newmail = htmlspecialchars($_POST['newmail']);
    $insert_mail = $bdd->prepare('UPDATE membres  SET 
mail=? WHERE id=? ');
    $insert_mail->execute(array($newpseudo), $_SESSION['id']);
    header('Location:profil.php?id=' . $_SESSION['id']);
  }
  if (isset($_POST['pass1']) && isset($_POST['pass2'])  && !empty($_POST['pass1']) && !empty(['pass2'])) {
    $password1 = sha1($_POST['pass1']);
    $password2 = sha1($_POST['pass2']);
    if ($password1 == $password2) {
      $insert_password = $bdd->prepare('UPDATE membres  SET 
    password=? WHERE id=? ');
      $insert_password->execute(array($password1, $_SESSION['id']));
      header('Location:profil.php?id=' . $_SESSION['id']);
    } else {
      $msg = "Vos deux mots de
     passes ne correspondent pas";
    }
    if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
      $taillemax = 2097152;
      $extensions_valid = array("jpg", "jpeg", "gif", "png");
      if ($_FILES['avatar']['size'] <= $taillemax) {
        $extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
        if (in_array($extension_upload, $extensions_valid)) {
          $chemin =  "membres/avatar/" . $_SESSION['id'] . "." . $extension_upload;
          $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
          if ($resultat) {
            $update_avatar = $bdd->prepare("UPDATE membres SET avatar = :avatar WHERE id = :id");
            $update_avatar->execute(array('avatar' => $_SESSION['id'] . "." . $extension_upload, 'id' => $_SESSION['id']));
            header("Location:profil.php?id=" . $_SESSION['id']);
          } else {
            $msg = " Il y a eu une erreur durant l'importation de votre photo de profil";
          }
        } else {
          $msg = " Votre photo de profil doit etre au format jpg , jpeg , png  ,gif";
        }
      } else {
        $msg = " Votre photo de profil ne doit pas dépassé  2 Mo";
      }
    }
  }
  //strtolower met tout en miniscule;
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
  </head>

  <body>
    <div align="left">
      <h2>Edition du profil de <? echo $_SESSION['pseudo'] ?></h2>
      <form action="" method="post" enctype="multipart/form-data">
        <label for="newpseudo">Pseudo</label><br>
        <input type="text" name="newpseudo" id="" placeholder="pseudo" value="<?php echo  $user['pseudo'] ?>"><br>
        <label for="newmail">Mail</label><br>
        <input type="email" name="newmail" id="" placeholder="email" value=" <?php echo $user['mail'] ?>"><br><br>
        <label for="pass1">Mot de passe</label><br>
        <input type="password" name="pass1" id="" placeholder="mot de passe"><br>
        <label for="pass2">Confirmation de Mot de passe</label><br>
        <input type="password" name="pass2" id="" placeholder="confirmer le mot de passe"><br>
        <label for="avatar">Avatar</label><br>
        <input type="file" name="avatar" id=""><br>
        <input type="submit" value="Mettre à jour le profil " name="valider"><br>
      </form>
      <?php if (isset($msg)) {
        echo $msg;
      }
      ?>
    </div>
  <?php
} else {
  header('Location:connexion.php');
}
  ?>
  </body>

  </html>