<?php

    include_once(__DIR__ . "/classes/User.class.php");

	if (!empty($_POST)) {
        $email = $_POST['email'];
        $password = $_POST['wachtwoord'];
    
        $login = new User();
        $login->setEmail($email);
        $salt = "qsdfg23fnjfhuu!";
        $login->setPassword($password.$salt);
        $login->canLogin();

        if (!$login->canLogin()) {
            $error = "Er liep iets fout.";
        }

        if($login->canLogin()){
            $conn = Db::getConnection();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindParam(":email", $_SESSION['email']);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if( !empty($result['buddy']) || !empty($result['kenmerk1']) || !empty($result['kenmerk2']) || !empty($result['kenmerk3']) || !empty($result['kenmerk4']) || !empty($result['kenmerk5']) ){
                echo "<script>location='index.php'</script>";
            } else {
                echo "<script>location='updateUser.php'</script>";
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<title>Meld je aan bij Companion</title>
<link rel = "stylesheet" type = "text/css" href = "css/style.css"/>
</head>

<body>

    <div id="banner"></div>

    <div id="geen_lid">
        <p>Nog geen Companion? <a href="register.php">Registreer hier.</a></p>
    </div>

    <div class="aanmeldenField">

        <form action="" method="post">

            <h2>Meld je aan bij Companion!</h2>

            <?php if(isset($error)): ?>
    		<div class="error"><?php echo $error; ?></div>
    		<?php endif; ?>

            <div>
                <label for="email" required>Studenten Email</label>
                <input class="input" type="text" name="email" required>
            </div>
            
            <div>
                <label for="wachtwoord">Wachtwoord</label>
                <input class="input" type="password" name="wachtwoord">
            </div>
            
            <div>
                <input type="submit" class="btn-aanmelden" value="Aanmelden">
            </div>
        
        </form>

    </div>
</body>
</html>