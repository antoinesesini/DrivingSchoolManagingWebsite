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
    SUPPRESSION D'UN THEME
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <form action="supprimer_theme.php" method="POST">
      <?php
        include("../connexion.php");
        $result=mysqli_query($connect, "SELECT * FROM themes WHERE supprime=0"); //on récupère tous les thèmes actifs
        if (!$result)
          {
            echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
            echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=suppression_theme.php">';
            exit;
          }
        echo "Quel thème souhaitez-vous supprimer ?"."<br><br>";
        echo "<select name='themechoisi' required>"; //on en choisit un en select
        while ($row=mysqli_fetch_row($result))
          {
            echo "<option value=\"$row[0]\">$row[1] : $row[3]</option>";
          }
        echo "</select>";
        mysqli_close($connect);
      ?>
      <br><br>
      <input type="submit" value="Supprimer ce thème"><br>
    </form>
  </div>
  </center>

</body>


</html>
