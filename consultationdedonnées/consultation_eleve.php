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
    CONSULTATION DES DONNEES ELEVE
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <form action="consulter_eleve.php" method="POST">
      <?php
        include("../connexion.php");
        $result=mysqli_query($connect, "SELECT * FROM eleves"); //on récupère tous les élèves de l'auto école
        // echo "br".$query."br";
        if (!$result)
          {
            echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
            echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=consultation_eleve.php">';
            exit;
          }
        echo "De quel élève souhaitez-vous obtenir les informations ?  ";
        echo "<select name='elevechoisi' required>"; //on en choisit un en select
        while ($row=mysqli_fetch_row($result))
          {
            echo "<option value=\"$row[0]\">$row[2] $row[1] né(e) $row[3]</option>";
          }
        echo "</select>";
        mysqli_close($connect);
      ?>
      <br><br>
      <input type="submit" value="Voir les informations"><br>
    </form>
  </div>

</center>
</body>


</html>
