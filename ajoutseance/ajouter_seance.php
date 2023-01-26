<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <?php

  date_default_timezone_set('Europe/Paris');
  $datetest=date("Y\-m\-d");

  @$date=$_POST['date'];
  @$effmax=$_POST['effmax'];
  @$theme=$_POST['theme'];

  if (empty($date) || empty($effmax) || empty($theme)) //on test si c'est vide
    {
      echo "<br><br><br><br><div class='contenant'> Il faut saisir les données. </div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
      exit;
    }

  if ($date<$datetest) //on fait en sorte de ne pouvoir créer que des séances dans le futur
    {
      echo "<br><br><br><br><div class='contenant'> La date saisie n'est pas valide.  </div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
      exit;
    }

  include("../connexion.php");
  $query="SELECT idseance  from seances WHERE DateSeance=\"$date\" AND Idtheme=\"$theme\""; //on récupère les séances sur le même thème le même jour
  // echo "br".$query."br";
  $result=mysqli_query($connect,$query);
  if (!$result)
    {
      echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
      exit;
    }
  if (mysqli_num_rows($result)>=1) //si il y en a, on prévient l'utilisateur
    {
      echo "<br><br><br><br><div class='contenant'> Une séance à propos de ce thème est déjà prévue ce jour là !</div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
      exit;
    }
  else //sinon, on créer la séance
    {
      $query=" insert into seances values (NULL, \"$date\",\"$effmax\",\"$theme\")"; //creation du paramètre requete
      // echo "br".$query."br";
      $result= mysqli_query($connect, $query); //envoi par la connexion du parametre requete
      if (!$result)
        {
          echo "<br><br><br><br><div class='contenant'> La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
          exit;
        }
      else
        {
          echo "<br><br><br><br><div class='contenant'> Séance programmée avec succés le ".$date." !</div><br>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
        }
    }
    mysqli_close($connect);
    ?>
</body>


</html>
