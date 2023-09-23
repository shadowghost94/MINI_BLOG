<?php
//pour vérifier que l'utilisateur est bien connecté
    include '../database/db.php';
    if(!isset($_SESSION['id'])){
        header('location: ../auth/connexion.php');
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Articles publiés</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../assets/css/connect.css">
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/css/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
	</head>
	<body>
		<div class="loader">
			<img src="../assets/images/ok.jpg" />
			<div class="spinner-grow" role="status">
  				<span class="sr-only">Loading...</span>
			</div>
		</div>
		
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="../">Mini-Blog</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Tableau de bord <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Article</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Liste des articles</a>
                            <a class="dropdown-item" href="#">Ajouter</a>
                        </div>
                    </li>
                </ul>
                <div class="my-10 my-lg-0">
                    <?php
                        if(!isset($_SESSION['id'])){

                    ?>
                    <a class="btn btn-primary" href="" role="button">Connexion</a>
                    <a class="btn btn-primary" href="" role="button">Inscription</a>
                    <?php
                        }
                    ?>
                    <a class="btn btn-danger" class="nav-link" style="color: white;" href="../auth/deconnexion.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    
                </div>
            </div>
        </nav>
		
		<div class="jumbotron jumbotron-fluid">
			<div class="container">
			    <h1 class="display-4">Articles publiés</h1>
			</div>
		</div>

        <div class="container">  
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>date de Publication</th>
                    </tr>
                </thead>
                    
                <tbody>
                <?php
                    $req= $db->prepare('SELECT * FROM articles WHERE user_id=? ORDER BY id DESC');
                    $req->execute(array($_SESSION['id']));
                    while($res = $req->fetch()){
                ?>
                    <tr>
                        <td> <?= $res['id'] ?> </td>
                        <td><img src="<?='../'.$res['image']?>" alt="" width="50" height="70"></td>
                        <td><?= $res['titre'] ?></td>
                        <td><?=substr( $res['description'],0,300 ).'...'?></td>
                        <td><?= $res['dateAjout'] ?></td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>

        <script type="text/javascript">
			window.addEventListener("load", function () {
				const loader = document.querySelector(".loader");
				loader.className += " hidden";
			})
		</script>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
        <script>
            new DataTable('#example');
        </script>
	</body>
</html>