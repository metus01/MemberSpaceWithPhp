<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id']))
{
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
  if(isset($_POST["envoi_message"]))
  {
    if(isset($_POST["destinataire"]) && isset($_POST['message']) && !empty($_POST["destinataire"]) && !empty($_POST["message"]))
    {
      $destinataire_id = htmlspecialchars($_POST['destinataire']);
      $message = htmlspecialchars($_POST["message"]);
      $req = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
      $req->execute(array($destinataire_id));
      $exist_dest = $req->rowCount();
      if($exist_dest == 1)
      {
        $ins = $bdd->prepare("INSERT INTO messages(id_sender , id_receveur , message) VALUES (:id_sender , :id_recever , :message)");
        $ins->bindValue(":id_sender" , $_SESSION["id"]);
        $ins->bindValue(":id_recever"  , $destinataire_id);
        $ins->bindValue(":message" , $message);
        $ins->execute();
        if($ins->execute() == true)
        {
          $error_message = " Votre message a bien été envoyé";
          header("Location:".$_SERVER['HTTP_REFERER']);
        }else
        {
          $error_message = " Erreur d'envoie du message";
          
        }
      }else
      {
        $error_message = " Cet User n'existe pas !!!!";
      }
     
    }else
    {
      $error_message = " Veuillez remplir tous les champs du formualaire";
    }
  }
  
    $destinataires = $bdd->query("SELECT *  FROM membres WHERE id != {$_SESSION["id"]} ORDER BY pseudo ");
   
  
  
  
  ?>
  
  <!DOCTYPE html>
  <html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MESSAGE - PRIVEE</title>
  </head>
  
  <body>
    
    <form action="" method="post">
      <label for="destinaitaire">Destinataire</label><br>
      <select name="destinataire" id="">
        <?php
        while($d = $destinataires->fetch())
        {
          ?>
          <option value="<?=$d['id']?>"><?=$d['pseudo']?></option>
          <?php
        }
        ?>
        
      </select>
      <br>
      <textarea name="message" id="" cols="30" rows="10" placeholder="Votre message..."></textarea>
      <input type="submit" value="Envoyer" name="envoi_message">
      <?php if(isset($error_message)) echo$error_message ; ?>
      <br>
      <br><b><a href="reception.php">Boîte de reception</a></b>
    </form>
  </body>
  
  </html>
  <?php
}
else
{
  header("Location" . $_SERVER["HTTP_REFERER"]);
}
?>