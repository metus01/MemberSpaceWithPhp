<?php
$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
$bdd = new PDO( "mysql:host={$local};dbname={$dbn};charset:utf8", $username, $passwd);
if(isset($_GET['id']))
{
  $user_id = $_GET["id"];
  $req = "SELECT * FROM membres";
  $stmt = $bdd->prepare($req);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>USERS</title>
</head>
<body>
  <p style="text-align: center;">
  <table>
    <tr>
      <th>Pseudo</th> <br>
      <th>Mail</th>
    </tr>
  <?php
   foreach($users as $user)
   {
     ?>
     
     <tr>
     <a href="profil.php?id=<?= $user["id"]?>">
      <td>
        <?= $user["pseudo"] ;?> <br>

     </td>
     <td>
      <?= $user["mail"] ?>
     </td>
     </a>
    </tr>
     
     <?php
   }
    ?>
    </table>
 </p>
</body>
</html>
