<?php 
  session_start();
  $mysqli = require_once("databaseConnect.php");
  include 'databaseUtils.php';
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PWND</title>

        <!-- Bootstrap CSS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>       
    
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="./style.css">
        <script defer src="https://friconix.com/cdn/friconix.js"> </script>

    </head>
	<body>

		<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #615dfa;">
            <div class="container-fluid">
                <a class="navbar-brand mt-2 mt-lg-0" href="#" style="margin-right: 40px;">
                    <img src="logo_eseo.png" height="50" alt="" class="d-inline-block align-middle">
                </a>
         
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item yes mr-5">
                            <a class="nav-link text-white" href="index.php">Accueil</a>
                        </li>
                    </ul>

                    <form>
                        <div class="input-group pt-3">
                            <input type="text" class="form-control" placeholder="Rechercher un étudiant">
                               <div class="input-group-append">
                                    <button type="submit" class="btn input-group-text">
                                        <i class="fi-xnsuhl-search"></i>
                                    </button>
                                </div>
                        </div>
                    </form>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ml-auto">
                       <a class="navbar-brand mt-2 mt-lg-0" href="#">
                       </a>
                       <li class="nav-item dropdown yes">
                           <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mon profil
                           </a>
                           <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                             <li><a class="dropdown-item" href="#">Voir mon profil</a></li>
                             <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modifierProfilModal">Modifier mon profil</a></li>
                             <li>
                              <form action="core.php" method="post">
                                <input type="hidden" name="type_ci" value="deconnexion">   
                                <button class="btn dropdown-item" type="submit">Se déconnecter</button>
                              </form>
                            </li>
                           </ul>
                         </li>
                        <li class="nav-item yes">
                            <a class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#notificationModal">Notification</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- demande ami -->
                <!-- TODO -->
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modifier mon profil</h5>
                  <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fi-cnsuxl-times-solid"></i>
                  </button>
                </div>
                <form action="edit.php" method="post">
                    <div class="modal-body">
                      <div class="container">
                        <?php 
                          $primaire = $_SESSION['primaire'];
                          $sql = "SELECT * FROM demande_ami WHERE destinaire = '$primaire'";
                          $result = sendQuery($sql, $mysqli);
                          if ($result->num_rows > 0) { // si on trouve un ami ou plus
                            $row = $result->fetch_assoc();
                            $demandeur = $row['demandeur'];
                            foreach($result as $row) {
                              $sql = "SELECT * FROM account_data WHERE primaire = '$demandeur'";
                              $result2 = sendQuery($sql, $mysqli);
                              if ($result2->num_rows > 0) { // si on trouve un ami ou plus
                                $row = $result2->fetch_assoc();
                                $name=$row['name'];
                                $first_name=$row['first_name'];
                                $year=$row['year'];
                                ?>
                                  <div class="row mb-3">
                                    <div class="col-8">
                                      <div class="media">
                                        <img src="photos_profiles/default.png" width="50" height="50" alt="" class="align-self-start mr-3 rounded-circle">
                                        <div class="media-body">
                                          <h5 class="mt-0"><?php echo $first_name ." ". $name;?> - <?php echo $year ?></h5> 
                                          <p>Souhaites-vous ajouter en ami</p>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-4 mt-2">
                                      <div class="btn-group" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-success"><i class="fi-cwsuxl-check"></i></button>
                                        <button type="button" class="btn btn-danger"><i class="fi-cnsuxl-times-solid"></i></button>
                                      </div>
                                    </div>
                                  </div>
                                  <hr>
                                
                                <?php
                              }
                            }
                          }
                        ?>
                        <!-- FIN CONTAINER -->
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>

        <div class="modal fade" id="modifierProfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modifier mon profil</h5>
                </div>
                <form action="./lib/modificationProfil.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Nom</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Prénom</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Photo</div>
                              </div>
                              <input class="form-control" type="file" name="photoProfil">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Année Scolaire</div>
                              </div>
                              <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                <option>E1</option>
                                <option>E2</option>
                                <option>E3</option>
                                <option>E4</option>
                                <option>E5</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Email</div>
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Description</div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                  <button type="submit" class="btn btn-success">Sauvegarder les changements</button>
                </div> 
              </div>
            </div>
          </div>

          <div class="modal fade" id="posterArticleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Poster un article</h5>
                </div>
                <form action="edit.php" method="post">
                    <div class="modal-body">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Description</div>
                        </div>
                        <textarea class="form-control" id="productQuantity"></textarea>
                      </div>

                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Photo</div>
                        </div>
                        <input class="form-control" type="file" id="formFile">
                      </div>
                    </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                  <button type="submit" class="btn btn-success">Poster l'article</button>
                </div> 
                </form>
              </div>
            </div>
          </div>


          <div class="container-fluid">
            <div class="row h-100">
              <div class="col col-lg-2" style="background-color: lightgrey;">
                <div class="text-center m-2">
                  Amis
                </div>
                <div class="list-friend-content border border-dark rounded mt-1 p-1">
                  <!-- TODO -->
                  <?php
                    $primaire = $_SESSION['primaire'];
                    $sql = "SELECT * FROM ami WHERE ami1 = '$primaire'";
                    $result = sendQuery($sql, $mysqli);
                    if ($result->num_rows > 0) { // si on trouve un ami ou plus
                      $row = $result->fetch_assoc();
                      $ami2 = $row['ami2'];
                      foreach($result as $row) {
                        $sql = "SELECT * FROM account_data WHERE primaire = '$ami2'";
                        $result2 = sendQuery($sql, $mysqli);
                        if ($result2->num_rows > 0) { // si on trouve un ami ou plus
                          $row = $result2->fetch_assoc();
                          $name=$row['name'];
                          $first_name=$row['first_name'];
                          $year=$row['year'];
                          ?>
                          <div>
                            <h5>
                              <?php
                                echo $first_name ." ". $name;
                              ?>
                            </h5>
                            <p>
                              <?php
                                echo $year;
                              ?>
                            </p>
                          </div>
                          <?php
                        }
                      }
                    }
                    $sql = "SELECT * FROM ami WHERE ami2 = '$primaire'";
                    $result = sendQuery($sql, $mysqli);
                    if ($result->num_rows > 0) { // si on trouve un ami ou plus
                      $row = $result->fetch_assoc();
                      $ami2 = $row['ami1'];
                      foreach($result as $row) {
                        $sql = "SELECT * FROM account_data WHERE primaire = '$ami2'";
                        $result2 = sendQuery($sql, $mysqli);
                        if ($result2->num_rows > 0) { // si on trouve un ami ou plus
                          $row = $result2->fetch_assoc();
                          $name=$row['name'];
                          $first_name=$row['first_name'];
                          $year=$row['year'];
                          ?>
                          <div>
                            <h5>
                              <?php
                                echo $first_name ." ". $name;
                              ?>
                            </h5>
                            <p>
                              <?php
                                echo $year;
                              ?>
                            </p>
                          </div>
                          <?php
                        }
                      }
                    }
                  ?>
                </div>
              </div>
              <div class="col">

                <div class="card border-0 bg-light mt-3">
                  <div class="card-body">
                    <div class="media mb-3">
                      <div class="media-body">
                        <div class="row mb-3">
                          <div class="col-8">
                          </div>
                          <div class="col-3">
                            <div class="btn-group" role="group" aria-label="First group">
                              <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#posterArticleModal">Poster un article</button>
                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifierProfilModal">Modifier mon profil</i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="container pt-5">

                  <div class="row" style="padding-left: 7em; padding-right: 7em;">

                  </div>
                </div>
              </div>
              <div class="col col-lg-3" style="background-color: lightgrey;">
                Conversation
              </div>
            </div>
          </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>	
    
    </body>
</html>