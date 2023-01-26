<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <?php
    @$elevechoisi=$_POST['elevechoisi'];
    @$seancechoisie=$_POST['seancechoisie'];

    include("../connexion.php");

    $query="SELECT idseance, ideleve  FROM inscription WHERE idseance=\"$seancechoisie\" AND ideleve=\"$elevechoisi\"";//on récupère l'inscription en question
    // echo "br".$query."br";
    $result=mysqli_query($connect,$query);
    if (!$result)
      {
        echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=desinscription_seance.php">';
        exit;
      }
    if (mysqli_num_rows($result)>=1) //si l'élève est bien inscrit, on supprime l'inscription
      {
        $query="DELETE FROM inscription WHERE ideleve=\"$elevechoisi\" AND idseance=\"$seancechoisie\"";
        // echo "br".$query."br";
        $result=mysqli_query($connect,$query);
        if (!$result)
          {
            echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
            echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=desinscription_seance.php">';
            exit;
          }
        echo "<br><br><br><br><div class='contenant'>L'élève a été désinscrit sans problème !</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=desinscription_seance.php">';
      }
    else //s'il ne l'est pas, on prévient l'utilisateur
      {
        echo "<br><br><br><br><div class='contenant'>L'élève n'est pas inscrit à cette séance !</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=desinscription_seance.php">';
        exit;
      }
    mysqli_close($connect);
  ?>
</body>

</html>
