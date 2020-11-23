<?php
session_start();
    
    include_once("Database.php");
    $con=new Database();
    $con->getpdo();
    $fetch=$con->plateOfTheDay();
    $idP= $_SESSION["idP"];
    $plate= $_SESSION["plate"];
    $sql= $con->getpdo()->query("select * from menu where menuId <>'$idP'");
    $fetchAll=$sql->fetchAll();


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';



// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);




if(isset($_POST['submit'])){
        $nom=$_POST["nom"];
        $prenom=$_POST["prenom"];
        $tel=$_POST["tel"];
        $zone=$_POST["zone"];

    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'madimed802@gmail.com';                     // SMTP username
    $mail->Password   = '';                               // SMTP password
    $mail->SMTPSecure = 'ssl'; //PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom("madimed802@gmail.com", $nom);
    $mail->addAddress('madimed802@gmail.com');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Demande du déjeuner';
    $mail->Body    = "Nom : " . $nom . "<br>Prénom : " . $prenom . "<br>Telefone : " . $tel . "<br>Plat : " . $plate . "<br>Zone de livraison : " . $zone;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="mainn.css">
    <title>Home</title>
</head>
<body>

    <div class="container" >
        <h2>PLAT DU JOUR</h2>
        <div class="row">
            <?php
                foreach($fetch as $elem){
                    $_SESSION["idP"]=$elem["menuId"];
                    $_SESSION["plate"]=$elem["plat"];
            ?>
            <div class="col mb-4 plate">
                <div class="card">
                    <img class="card-img-top" src="uploads/<?= $elem["photo"] ?>" alt="Card image cap">
                    <div class="card-body">
                        <h3><?= $elem["plat"] ?></h3>
                        <h5>Prix : <?= $elem["prix"] ?> DH</h5>
                      <p class="card-text"><?= $elem["description"] ?></p>
                      <input type="submit" name="demande" class="btn btn-info" value="Demander" onclick="display()">
                    </div>
                  </div>
            </div>
            <?php } ?>
        </div>
        <div class="demande" id="demande">
        <form method="POST">
            <div class="row">
                <div class="col mb-4 info">
                    <h4>Nom</h4>
                        <input type="text" class="form-control" name="nom" required>
                    <h4>Prénom</h4>
                        <input type="text" class="form-control" name="prenom" required>
                    <h4>Télephone</h4>
                    
                        <input type="tel" class="form-control" name="tel" required>
                    
                    <h4>Zone de livraison</h4>
                    
                        <input type="text" class="form-control" name="zone" required>

                        <input type="submit" name="submit" class="btn btn-info" value="Submit">
                    <!-- <a href="#" class="btn btn-primary" name="submit">Demander</a> -->
                </div>
            </div>
        </form>
        </div>
        <h2>MENU DES JOURS SUIVANTS</h2>
        
        <div class="row" style="display:flrex !important; width:100%; justify-content:space-around;">
            
           <?php
            foreach($fetchAll as $element){
            ?>
            <div class="" style="width: 30%;  margin-bottom: 2%">
                <div class="card">
                    <img class="card-img-top" src="uploads/<?= $element["photo"] ?>" alt="Card image cap">
                    <div class="card-body" >
                      <p class="card-text"><?= $element["description"] ?></p>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        
    </div>
    
</body>
<script>
    function display(){
        document.getElementById('demande').style.display="block";
    }
    function success(){
        document.getElementById('success').style.dysplay="block";
        }

    // function hidePopup(){
    //     document.getElementById('demande').style.display="none";
        
    // }

    
</script>
</html>


