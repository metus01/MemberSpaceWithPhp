<?php
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
if (isset($_GET["p"]) && !empty($_GET["p"])) {
  $parrain_uniqid = htmlentities(htmlspecialchars($_GET['p']));
  $req_parrain = $bdd->prepare("SELECT id FROM membres WHERE uniqid = ?");
  $req_parrain->execute(array($parrain_uniqid));
  $parrain_exist = $req_parrain->rowCount();
  if ($parrain_exist == 1) {
    $req_parrain = $req_parrain->fetch();
    $id_parrain = $req_parrain["id"];
  }
}
if (isset($_POST['valider'])) {
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $mail = htmlspecialchars($_POST['mail']);
  $mail2 = htmlspecialchars($_POST['mail2']);
  $password = sha1(htmlspecialchars($_POST['password']));
  $password2 = sha1(htmlspecialchars($_POST['password2']));
  $pseudolength = strlen($pseudo);
  if (!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
    if ($pseudolength <= 255) {
      if ($mail == $mail2) {
        if (filter_var(
          $mail,
          FILTER_VALIDATE_EMAIL
        )) {
          $reqmail = $bdd->prepare(' SELECT 
* FROM membres WHERE mail = ?');
          $reqmail->execute(array($mail));
          $exist_mail = $reqmail->rowCount();
          if ($exist_mail == 0) {
            if ($password == $password2) {
              $insert_number =
                $bdd->prepare('INSERT INTO 
membres(pseudo,mail,
password,avatar , uniqid ,id_parrain) VALUES 
(?,?,?,?,?,?)');
              if (isset($id_parrain) && !empty($id_parrain)) {
                $insert_number->execute(array($pseudo, $mail, $password, "default.jpg", uniqid(), $id_parrain));
              } else {
                $insert_number->execute(array($pseudo, $mail, $password, "default.jpg", uniqid(), 0));
              }

              $erreur = "Votre 
compte a bien été créé!!!  <a  href=\"connexion.php\">Me connecter </a>";
            } else {
              $erreur = 'Vos deux mots de 
passent ne correspondent pas ';
            }
          } else {
            $erreur = "Ce mail a déja été 
utilisé pour créer un compte";
          }
        } else {
          $erreur = "Votre adresse mail 
n'est pas valide";
        }
      } else {
        $erreur = "Vos deux adresses mails 
ne correspondent pas";
      }
    } else {
      $erreur = " Votre pseudo ne doit pas 
dépasser 255 caractères";
    }
  } else {
    $erreur = "Tous les champs doivent être 
remplis";
  }
} else {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, 
initial-scale=1.0">
  <title>Espace Membres Création</title>
</head>

<body>
  <div align="center">
    <h2>Inscription</h2><br>
    <form action="" method="post">
      <table>
        <tr>
          <td><label for="pseudo">Votre Pseudo</ label><br></td>
          <td><input type="text" name="pseudo" id="" placeholder="pseudo" value="<?php
                                                                                  if (isset($pseudo)) {
                                                                                    echo $pseudo;
                                                                                  } ?>"><br></td>
        </tr>
        <tr>
          <td><label for="mail">Votre Email</ label>
          </td>
          <td><input type="email" name="mail" id=""></td>
        </tr>
        <tr>
          <td><label for="confirm_mail">Confirmer le
              mail</label></td>
          <td><input type="email" name="mail2" id=""></td>
        </tr>
        <tr>
          <td><label for="password">Votre mot
              de passe</label></td>
          <td><input type="password" name="password" id=""></td>
        </tr>
        <tr>
          <td><label for="password2">Confirmer
              le mot de Passe</label></td>
          <td><input type="password" name="password2" id=""></td>
        </tr>
        <tr>
          <td align="center"><input type="submit" value="Valider" name="valider"></td>
          <td><a href="connexion.php">Vous avgez dejà un compte ??? Connectez Vous</a></td>
        </tr>
      </table>
    </form>
    <?php
    if (isset($erreur)) {
      echo '<font color="red">' . $erreur . '</font>';
    }
    ?>
  </div>
</body>

</html>