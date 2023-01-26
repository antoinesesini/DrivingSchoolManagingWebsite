<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>
  <?php


  //On change les noms en format MMMMMMM
  $nom=$_POST['nom'];
  $nom=strtoupper($nom);

  //On change les prénoms en format Mmmmmm
  $prenom=$_POST['prenom'];
  @$datachange="";
  for ($i=1; $i<strlen($prenom)+1; $i++)
    {
      @$newchar=strtolower($prenom[$i]);
      $datachange=$datachange.$newchar;
    }
  @$prenom=strtoupper($prenom[0]).$datachange;


  @$dateNaiss=$_POST['datedenaissance'];

  date_default_timezone_set('Europe/Paris');
  @$date=date("Y\-m\-d");
  @$datetab=explode("-",$date);
  @$dateY=$datetab[0];
  @$datem=$datetab[1];
  @$dated=$datetab[2];



  @$datenaisstab=explode("-",$dateNaiss);
  @$datenaissY=$datenaisstab[0];
  @$datenaissm=$datenaisstab[1];
  @$datenaissd=$datenaisstab[2];

  if ($datenaissY<=($dateY-15))
    {
      if ($datenaissY==($dateY-15))
        {
          if ($datenaissm<=($datem))
            {
              if ($datenaissm==($datem))
                {
                  if ($datenaissd>$dated)
                    {

                      echo "<br><br><br><br><div class='contenant'> L'élève est trop jeune ! </div>";
                      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
                      exit;
                    }
                }
            }
    else
            {
              echo "<br><br><br><br><div class='contenant'> L'élève est trop jeune ! </div>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
              exit;

            }
        }
    }
  else
    {
      echo "<br><br><br><br><div class='contenant'> L'élève est trop jeune ! </div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
      exit;

    }


  if (empty($nom) || empty($prenom) || empty($dateNaiss)) //si les champs sont vides
      {
        echo "<br><br><br><br><div class='contenant'> Il faut saisir les données </div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
        exit;
      }
  else //si les champs sont bien remplis on cherche
      {
        include("../connexion.php");
        $query="SELECT ideleve from eleves WHERE nom=\"$nom\" AND prenom=\"$prenom\"";
        // echo "br".$query."br";
        $result=mysqli_query($connect,$query);
        if (!$result)
          {
            echo "<br><br><br><br><div class='contenant'> La requête a échoué : ".mysqli_error($connect)."</div>";
            echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
            exit;
          }

        if (mysqli_num_rows($result)>=1) //si on a trouvé, on demande confirmation et la confirmation fait appel au fichier de validation
            {
              echo "<br><br><br><br><div class='contenant'> Un(e) élève ayant le même nom et le même prénom est déjà inscrit(e) dans l'autoécole..."."<br>";
              echo "Souhaitez vous vraiment ajouter cet(te) éléve dans la BDD ?"."<br><br>";
              echo "<a href='ajout_eleve.html' target='page de droite'><button>Annuler</button></a><br>";

              echo "<form action='valider_eleve.php' method='post'>";
              echo "<input type='hidden' name='nom' value=$nom >";
              echo "<input type='hidden' name='prenom' value=$prenom >";
              echo "<input type='hidden' name='datedenaissance' value=$dateNaiss >";
              echo "<input value='Valider mon choix' name='val' type='submit'>";
              echo "</form></div>";
            }
        else //si on a pas trouvé, on ajoute
            {
              $query="insert into eleves values (NULL, \"$nom\", \"$prenom\", \"$dateNaiss\", \"$date\")"; //creation du paramètre requete
              // echo "br".$query."br";
              $result= mysqli_query($connect, $query); //envoi par la connexion du parametre requete
              if (!$result)
                {
                  echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
                  echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
                  exit;
                }
              else
                {
                  echo "<br><br><br><br><div class='contenant'> Eleve ajouté(e) avec succés </div><br>";
                  echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
                }
            }
        mysqli_close($connect);
      }


?>
</center>
</body>


</html>
