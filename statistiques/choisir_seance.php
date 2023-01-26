<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>

  <br><br><br><br><br><br>

  <div class='contenant'>
    <center>
    CHOISIR UNE SEANCE
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <form action='stats_seance.php' method='post'>
      <?php
        date_default_timezone_set('Europe/Paris');
        $date=date("Y\-m\-d");
        include ("../connexion.php");
        $query="SELECT * from themes INNER JOIN seances ON themes.idtheme=seances.idtheme WHERE DateSeance<\"$date\" ORDER BY DateSeance DESC"; //on récupère toutes les séances et leur thème tq la séance est passée
        $liste_seances=mysqli_query($connect,$query);
        if (!$liste_seances)
          {
            echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
            echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=statistiques.php">';
            exit;
          }

        //début de l'affichage des input
        echo "Veuillez sélectionner la séance que vous souhaitez observer :"."<br><br>"; //on choisi une séance
        echo "<select class='' name='seancechoisie'>";
        while ($row=mysqli_fetch_row($liste_seances))
          {
            echo "<option value=\"$row[4]\" > Séance du \"$row[5]\" sur le thème suivant : \"$row[1]\"</option>";
          }
        echo "</select>";
        //fin de l'affichage des input
        mysqli_close($connect);
      ?>
      <br><br>
      <input type="submit" value="Observer les statistiques">
    </form>
  </div>
</body>

</html>
