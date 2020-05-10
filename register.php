
<?php

	include_once (__DIR__ . "/classes/Db.class.php");
	include_once(__DIR__ . "/classes/User.class.php");

	if (!empty($_POST)){	

		$user = new User();
		$email = $_POST['email'];
		$voornaam = $_POST['voornaam'];
		$achternaam = $_POST['achternaam'];
		$wachtwoord = $_POST['wachtwoord'];
	}

	if(!empty($_POST)){

		try{
			
			$user = new User();
			$salt = "qsdfg23fnjfhuu!";
			$wachtwoord = password_hash($wachtwoord.$salt, PASSWORD_DEFAULT, ['cost' => 12]); //2 tot de zoveelste keer gehasht
				
			$user->setEmail($_POST['email']);
			$user->setVoornaam($_POST['voornaam']);
			$user->setAchternaam($_POST['achternaam']);
			$user->setPassword($wachtwoord);

			if($user->save()){
				echo "<script>location='updateUser.php'</script>";
			}
		}

		catch (\Throwable $th){
			$error = $th->getMessage();
		}

	}

	$users = User::getAll();
	  
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>Aanmelden bij Companion</title>
</head>

<body>

	<div id="banner"></div>

	<div id="geen_lid">
		<p>Ben je al lid van Companion? <a href="login.php">Log hier in.</a></p>
	</div>

	<div class="registreerField">

		<form action="" method="post">

			<h2>Registreren</h2>

			<?php if(isset($error)): ?>
    		<div class="error"><?php echo $error; ?></div>
    		<?php endif; ?>

			<div>
				<label for="Email">Email</label>
				<input type="text" class="input" name="email" required>
			</div>

			<div>
				<label for="Voornaam">Voornaam</label>
				<input type="text" class="input" name="voornaam" required>
			</div>

            <div>
				<label for="Achernaam">Achternaam</label>
				<input type="text" class="input" name="achternaam" required>
			</div>
                
			<div>
				<label for="Wachtwoord">Wachtwoord</label>
				<input type="password" class="input" name="wachtwoord" required>
			</div>

			<div>
				<input type="submit" value="Volgende" class="btn-aanmelden">	
			</div>
	
		</form>

	</div>
</body>
</html>
