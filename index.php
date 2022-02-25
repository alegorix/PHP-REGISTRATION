<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['password']) && !empty($_POST['password'])
    && isset($_POST['re_password']) && !empty($_POST['re_password'])
    ){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $prenom = strip_tags($_POST['prenom']);
        $nom = strip_tags($_POST['nom']);
        $email = strip_tags($_POST['email']);

        // On crypte les MDP
        $password = md5($_POST['password']);
        $re_password = md5($_POST['re_password']);

        // On teste les MDP
        if ($password != $re_password) {
    
            $_SESSION['erreur'] = "Les passwords ne correspondent pas";
            require_once('close.php');
        }	else
        
        {



        $sql = 'INSERT INTO `users` (`prenom`, `nom`, `email`, `password`, `re_password` ) VALUES (:prenom, :nom, :email, :password, :re_password);';

        $query = $db->prepare($sql);

        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->bindValue(':re_password', $re_password, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "User ajouté";
        require_once('close.php');

        }

    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
?>





<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Inscription</title>
  </head>
  <body>
    <main class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>Inscription</h1>
                <form method="POST">
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Votre prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Entrez votre prénom…" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Votre nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez votre nom…" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Votre email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre adresse email…" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Votre mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Entrez votre mot de passe…" required>
                    </div>
                    <div class="mb-3">
                        <label for="re_password" class="form-label">Retapez votre mot de passe</label>
                        <input type="password" id="re_password" name="re_password" class="form-control" placeholder="Retapez votre mot de passe…" required>
                    </div>
                    <button type="submit" name="btn_submit" class="btn btn-primary">Inscription</button>
                </form>
            </div>
        </div>
    </main>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>