<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>
  <?php

  $seancechoisie=$_POST['seancechoisie'];
  $nbtotal=$_POST['nbtotal'];
  @$eleves=$_POST['eleve'];
  @$notes=$_POST['note'];
  $i=0;


  include ("../connexion.php");
  while ($i!=$nbtotal)
    {
      if (empty($notes[$i]))
        {
          if ($notes[$i]!==0)
           {
             $notes[$i]=-1;
          }
        }
      else
        {
          if ($notes[$i]<0 or $notes[$i]>40)
            {
              echo "<br><br><br><br><div class='contenant'> Impossible d'enregistrer de telles notes, elles doivent être comprises entre 0 et 40 </div>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
              exit;
            }
        }
      $query="UPDATE inscription set note=\"$notes[$i]\" WHERE ideleve=\"$eleves[$i]\" AND idseance=\"$seancechoisie\"";//on met à jour chaque note à l'aide d'un compteur et des varaibles tableau
      $notation=mysqli_query($connect, $query);
      if (!$notation)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
          exit;
        }
      $i=$i+1;
    }
  mysqli_close($connect);

  echo "<br><br><br><br><div class='contenant'>Les notes des élèves ont bien été mises à jour ! </div>";
  echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';

  ?>
  </center>
</body>


</html>
