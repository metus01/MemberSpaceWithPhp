<?php
session_start();
$username = 'root';
$passwd = "";
$dbn = "m_space";
$local = "localhost";
error_reporting(E_ALL);
    $bdd = new PDO("mysql:host={$local};
dbname={$dbn};charset:utf8", 
$username ,$passwd);
if(isset($_GET["followed_id"]) && !empty($_GET["followed_id"]))
{ 
$get_followed_id = intval($_GET["followed_id"]);

if($get_followed_id != $_SESSION["id"])
{
  $dejafollowed = $bdd->prepare("SELECT *FROM follow WHERE id_follower  = ?  AND id_following  = ?");
  $dejafollowed->execute(array($_SESSION["id"] , $get_followed_id));
  $dejafollowed = $dejafollowed->rowCount();
  if($dejafollowed == 0)
  {
 $follow = $bdd->prepare("INSERT INTO follow(id_follower , id_following)VALUES ( :id_follower , :id_following)");
 $follow->bindValue(":id_follower" , $_SESSION["id"]);
 $follow->bindValue(":id_following" , $get_followed_id);
 $follow->execute();


  }elseif($dejafollowed == 1)
  {
      $deletefollow = $bdd->prepare("DELETE FROM follow WHERE id_follower = ? AND id_following = ?");
      $deletefollow->execute(array($_SESSION["id"] , $get_followed_id));
  }
}
header("Location:".$_SERVER['HTTP_REFERER']);
}
else
{
  header("Location:".$_SERVER['HTTP_REFERER']);

}
?>
