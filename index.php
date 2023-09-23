<!DOCTYPE html>
<html>
	<head>
		<title>Accueil</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="./assets/css/connect.css">
		<link rel="stylesheet" href="./assets/css/bootstrap.min.css" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="./assets/css/main.css">
	</head>
	<body>
		<!--<div class="loader">
			<img src="./assets/images/ok.jpg" />
			<div class="spinner-grow" role="status">
  				<span class="sr-only">Chargement en cours..</span>
			</div>
		</div>-->
		
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Mini-Blog</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">Test</span>
            </button> 

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Tableau de bord <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Article</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="article/">Liste des articles</a>
                            <a class="dropdown-item" href="article/ajout.php">Ajouter</a>
                        </div>
                    </li>
                </ul>
                <div class="my-10 my-lg-0">
                    <a class="btn btn-primary" href="auth/connexion.php" role="button">Connexion</a>
                    <a class="btn btn-primary" href="auth/inscription.php" role="button">Inscription</a>
                    <a class="btn btn-danger" class="nav-link" style="color: white;" href="/auth/deconnexion.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </div>
            </div>
        </nav>
		
		<div class="jumbotron jumbotron-fluid">
			<div class="container">
			    <h1 class="display-4">Articles</h1>
			</div>
		</div>

        <div class="container">
            <div>
                <ul class="list-unstyled">
                    <?php
                        require 'database/db.php';
                        $req = $db->prepare('SELECT articles.titre, articles.description, articles.image,users.nom, users.prenom FROM articles, users WHERE articles.user_id=users.id ORDER BY articles.id DESC');
                        $req->execute();

                        while($res=$req->fetch()){
                    ?>
                    <li class="media">
                        <img src="<?=$res['image']?> " class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1"><?=$res['titre']?></h5>
                            <?=substr($res['description'],0,300).'...'?> <br>
                            <i class="fa fa-comment"></i>0 <br>
                            Par <?=$res['nom']?><?=$res['prenom']?><br>
                            <a href="auth/connexion.php">Lire la suite</a>
                        </div>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
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
	</body>
</html>