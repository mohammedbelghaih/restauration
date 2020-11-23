<?php
require_once("Database.php");
$con=new Database();
$con->getpdo();

    if(isset($_POST["submit"])){
        
        $date=date("y-m-d h:i:s");

        $image=$_FILES['photo']['name'];
        $tmp_dir=$_FILES['photo']['tmp_name'];
        $imgsize=$_FILES['photo']['size'];
        $uploads="uploads/";
        $imgExt=strtolower(pathinfo($image,PATHINFO_EXTENSION));
        $extension=["jpeg","jpg","png","gif","pdf"];
        $pic=rand(1000,10000).".".$imgExt;
        move_uploaded_file($tmp_dir,$uploads.$pic);
        $stm=$con->getpdo()->prepare("insert into menu (plat, prix, description, photo, updatedAt) values (:plat, :prix,:description, :photo, :updatedAt)");
        $stm->bindParam("photo",$pic);
        $stm->bindParam("plat",$_POST["plat"]);
        $stm->bindParam("prix",$_POST["prix"]);
        $stm->bindParam("description",$_POST["desc"]);
        $stm->bindParam("updatedAt",$date);

        
        if($stm->execute()){
           
        }else{
         echo 'error';
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <div class="container">
            <h4>plat</h4>
            <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" name="plat">
            </div>
            <h4>prix</h4>
            <div class="input-group input-group-sm mb-3">
                
                <input type="text" class="form-control" name="prix">
            </div>
            <h4>description</h4>
            <div class="input-group input-group-sm mb-3">
                
                <textarea name="desc"></textarea>
            </div>
            <h4>photo</h4>
            <div class="input-group input-group-sm mb-3">
                <input type="file" name="photo">
            </div>
            <div>
                <input type="submit" name="submit" value="Post" class="btn btn-lg" style="color: white; background-color: #FE6825;">    
            </div>

        </div>
    </form>
</body>
</html>