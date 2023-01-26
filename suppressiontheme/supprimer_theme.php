<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>
  <?php
    $themechoisi=$_POST['themechoisi'];
    include ("../connexion.php");
    $query="UPDATE themes set supprime=1 WHERE idtheme=\"$themechoisi\""; //on supprime le thème choisi
    // echo "br".$query."br";
    $result=mysqli_query($connect, $query);
    if (!$result)
      {
        echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=suppression_theme.php">';
        exit;
      }
    mysqli_close($connect);
    echo "<br><br><br><br><div class='contenant'>Le thème a bien été supprimé !</div>";
    echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=suppression_theme.php">';
    exit;
  ?>
  </center>
</body>


</html>
