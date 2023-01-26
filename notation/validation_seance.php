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
    NOTATION D'UNE SEANCE
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <form action='valider_seance.php' method='post'>
      <?php

      date_default_timezone_set('Europe/Paris');
      $date=date("Y\-m\-d");

      include ("../connexion.php");

      $query="SELECT * from themes INNER JOIN seances ON themes.idtheme=seances.idtheme WHERE DateSeance<=\"$date\""; //on récupère toutes les séances et leurs thèmes tq la séance est passée
      // echo "br".$query."br";
      $liste_seances_notables=mysqli_query($connect,$query);

      //début des tests
      if (!$liste_seances_notables)
        {
          echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
          exit;
        }
      if (empty($liste_seances_notables)) //si aucune séance n'est notable, on refresh
        {
          echo "Aucune séance n'est notable... Veuillez réessayer ultérieurement";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
          exit;
        }
      //fin des tests

      //début de l'affichage des input
      echo "Veuillez sélectionner la séance que vous souhaitez noter :"."<br><br>";
      echo "<select class='' name='seancechoisie'>";
      while ($row=mysqli_fetch_row($liste_seances_notables)) //on affiche les séances passées dans le select avec leur date et leur thème
        {
          echo "<option value=\"$row[4]\" > Séance du \"$row[5]\" sur le thème suivant : \"$row[1]\"</option>";
        }
      echo "</select>";
      //fin de l'affichage des input

      mysqli_close($connect);
      ?>
      <br><br>
      <input type="submit" value="Noter les élèves de cette séance">
    </form>
  </div>

</center>
</body>


</html>
