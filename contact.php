<?php 
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "classes/Auth.php";
    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';

    session_start();

    $session = false;

    if (Auth::isLoggedIn()){
        $session = $_SESSION["is_logged_in"];
    }

    $subject = "";
    $email = "";
    $message = "";
    $back_end_message = "";
   
   if($_SERVER["REQUEST_METHOD"] === "POST"){
        $subject = $_POST["subject"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $errors = [];

        if($subject === ""){
            $errors[] = "Prosím vyplňte VĚC ve formuláři!";
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL === false)){
            $errors[] = "Prosím vyplňte Váš e-mail!";
        }

        if($message === ""){
            $errors[] = "Prosím vyplňte zprávu pro příjemce!";
        }

        if(empty($errors)){
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP(); 
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = "kveta.prikryl@gmail.com";                     
                $mail->Password   = "nsumwqlkmininucd";                               
                $mail->SMTPSecure = "TLS";           
                $mail->Port       = 587;

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->CharSet = "UTF-8";
                $mail->Endcoding = "base64";

                $mail->setFrom('kveta.prikryl@gmail.com');
                $mail->addAddress('kveta.prikryl@seznam.cz'); // druhý email kam se zpráva pošle.
                $mail->Subject = $subject;
                $mail->Body    = "Email odesílatele: {$email} \n\nZpráva: \n\n{$message}";

                $mail->send();

                $back_end_message = "E-mail byl úspěšně odeslán. :)";
            } catch( Exception $e){
                $errors[] = "Zpráva nebyla odeslána {$mail->ErrorInfo}";
            }
        }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <script src="js/JQuery.js"></script>
    <script src="js/hamburger.js"></script>
    <script src="js/contact.js"></script>
    <title>Document</title>
</head>
<body>
    <main>
        <?php if($session): ?>
            <?php require "assets/admin-panel.php"; ?>
        <?php endif; ?>
        <div class="page-description">
            <h1>Sweet Caramel Rose</h1>
            <h2>Kontakt</h2>
        </div>
        <?php require "assets/header.php"; ?>
        <section class="messages" >
            <?php if($back_end_message): ?>
                <p class="message"><?= $back_end_message; ?></p>
            <?php endif; ?>
            <article class="errors">
                <?php if(!empty($errors)): ?>
                    <ul>
                        <?php foreach($errors as $one_error): ?>
                            <li class="one-error"><?= $one_error; ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif; ?>
            </article>
        </section>
        <section class="form">
            <form action="" method="POST">
                <input type="text" name="subject" value="<?= htmlspecialchars($subject) ?>" placeholder="Věc">
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="E-mail">
                <textarea name="message" placeholder="Váš text"><?= htmlspecialchars($message) ?></textarea>
                <input type="submit" name="submit" class="button btn">
            </form>
        </section>
    </main>
    <?php require "assets/footer.php"; ?>
</body>
</html>