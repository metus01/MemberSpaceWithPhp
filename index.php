<?php
$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
    $bdd = new PDO("mysql:host={$local};
dbname={$dbn};charset:utf8", 
$username ,$passwd);

if(isset($_POST['valider'] ))
{
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $mail = htmlspecialchars($_POST['mail']);
  $mail2 = htmlspecialchars($_POST['mail2']);
  $password = sha1( htmlspecialchars($_POST['password']));
  $password2 =sha1( htmlspecialchars($_POST['password2']));
  $pseudolength = strlen($pseudo);
    if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['password']) && !empty($_POST['password2']))
    {
      if(strlen($pseudolength <=255))
      {

            if($mail == $mail2)
            {
              if(filter_var($mail  ,  FILTER_VALIDATE_EMAIL))
              {           
                  if($password == $password2)
                  {
                          
                  }    
                  else
                  {
                    $erreur = "Vos mos de passes ne correspondent pas";
                  }
                }
                else
                        {
                             $erreur = "Votre mail n'est pas valide";  
                       }
            }  
            else
            {
              $erreur = "Vos adresses mails ne correspondent pas";
            }
      }
      else{

        $erreur = "Votre pseudo ne doit pas dépassé 255 caractères";
      }
    }
    else{
      $erreur = "Tous les champs doient etre entrées";
    }
}
else
{
     
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espace Membres Création</title>
</head>
<body>
  <div align="center">
<h2>Inscription</h2><br>
<form action="" method="post">
  <table>
    <tr>
  <td><label for="pseudo">Votre Pseudo</label><br></td>
  <td><input type="text" name="pseudo" id="" placeholder="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"><br></td>
    </tr>
    <tr>
      <td><label for="mail">Votre Email</label></td>
      <td><input type="email" name="mail" id=""></td>
    </tr>
    <tr>
      <td><label for="confirm_mail">Confirmer le mail</label></td>
      <td><input type="email" name="mail2" id=""></td>
    </tr>
    <tr>
      <td><label for="password">Votre mot de passe</label></td>
      <td><input type="password" name="password" id=""></td>
    </tr>
    <tr>
      <td><label for="password2">Confirmer le mot de Passe</label></td>
      <td><input type="password" name="password2" id=""></td>
    </tr>
    <tr>
      <td align="center"><input type="submit" value="Valider" name="valider"></td>
      <td align="center"><a href="connexion.php">Vous avez dejà un compte ? connexion !</a></td>
    </tr>
  </table>
</form>
  </div>
</body>
</html>
    