<?php

require './bdd.php';

if(isset($_FILES['file'])){
    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    $tabExtension = explode('.', $name);
    $extension = strtolower(end($tabExtension));

    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $maxSize = 1648488448;
  var_dump($size);
    if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){

        $uniqueName = uniqid('', true);
       
        $file = $uniqueName.".".$extension;
       

        move_uploaded_file($tmpName, './upload/'.$file);

        $req = $db->prepare('INSERT INTO articles (file) VALUES (?)');
        $req->execute([$file]);

        echo "Image enregistrée";
    }
    else{
        echo "Une erreur est survenue";
    }
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">

    </head>
<body>
    <h2>Ajouter une image</h2>
    <form action="index.php" method="POST" enctype="multipart/form-data">
    
        <label for="file">Fichier</label>
        <input type="file" name="file">

        <button type="submit">Enregistrer</button>
    </form>
    <h2>Mes images</h2>
    <?php 
        $req = $db->query('SELECT * FROM articles');
        while($data = $req->fetch()){
            echo "<img src='./upload/".$data['name']."' width='300px' ><br>";
        }
    ?>
</body>
</html>