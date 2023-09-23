<?php
    include '../database/db.php';
    if(!isset($_SESSION['id'])){
        $url ="http://";
        $url .=$_SERVER['HTTP_POST'];
        $url .=$_SERVER['REQUEST_URL'];

        $_SESSION['url']=$url;
        header('location: ../auth/connexion.php');
    }

    if(isset($_POST['enregistrer'])){
        $titre=$_POST['titre'];
        $contenu=$_POST['container'];
       

        if(isset($titre,$contenu) and !empty($titre) and !empty($contenu) )
        {   
            if(isset($_FILES['image']) AND $_FILES['image']['error']==0){

                $infosfichier= pathinfo($_FILES['image']['name']);
                $extension_upload= $infosfichier['extension'];
                /* in_array: c'est une fonction qui prend en paramètre un tableau et une valeur
                il vérifie si la valeur appartient à notre tableau */
                if(in_array($extension_upload,['jpg','jpeg','png'])){
                    $dossier='uploads/';
                    $nomfichier= uniqid().'.'.$extension_upload;
                    move_uploaded_file($_FILES['image']['tmp_name'],'../'.$dossier.$nomfichier);
                    
                    $req=$db->prepare('INSERT INTO articles(titre,description,image,user_id,dateAjout)
                    VALUES(?,?,?,?,now())');
                    $req->execute(array($titre,$contenu,$dossier.$nomfichier,$_SESSION['id']));

                    $msg="<label style='color:green;'>Publication éffectuée avec succès</label>";
                }else{
                    $msg=$msg="<label style='color:red;'>Type d'image requis !</label>";
                }
            }else{
                $msg="<label style='color:green;'>Veuillez ajouter une image</label>";
            }
                
            
        }else
        {
            $msg="<label style='color: red;'>Veuillez compléter tous les champs</label>";
        }
    }
    
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Ajouter un article</title>
		<meta charset="utf-8"/>
		<link rel="icon" href="" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../assets/css/connect.css">
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/css/main.css">
	</head>
	<body>
        <div class="loader">
			<img src="../assets/images/ok.jpg" />
			<div class="spinner-grow" role="status">
  				<span class="sr-only">Loading...</span>
			</div>
		</div>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Mini-Blog</a>
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
                            <a class="dropdown-item" href="../article/index.php">Liste des articles</a>
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

		<div class="jumbotron text-center" >
			<h1 class="display-4">AJOUTER UN ARTICLE</h1>
			<p class="lead">Ajouter un cours, exercices sous forme de texte ou d'image</p>			
			
			<form method="POST" enctype="multipart/form-data">
                <?php
                    if(isset($msg)){
                        echo $msg;
                    }
                ?>
                <div class="col-md-8 mx-auto">
                    <div class="form-row">
                        <div class="col-6">
                            <label>Titre</label>
                            <input type="text" value="" class="form-control" name="titre" required>
                        </div>
                        <div class="col-6">
                            <label>Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="image">
                                <label class="custom-file-label" for="inputGroupFile01">Choisir une image</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label>Contenu</label>
                            
                            <textarea name="container" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <input type="submit" class="btn btn-primary mt-4" name="enregistrer" value="Ajouter">
                    
                </div>
			</form>
			
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