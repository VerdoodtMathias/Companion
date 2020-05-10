<?php
    
    session_start();

    include_once(__DIR__ . "/classes/Db.class.php");
    include_once(__DIR__ . "/classes/User.class.php");

    if(empty($_SESSION['email'])){
        header("Location:login.php");
    }

    if(!empty($_POST)){

        $u = new User();
        $email = $_SESSION['email'];
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $buddy = $_POST['buddy'];

        $woonplaats = $_POST['woonplaats'];
        $keuze = $_POST['keuze'];
        $jaar = $_POST['jaar'];
        $hobby = $_POST['hobby'];
        $muziekstijl = $_POST['muziekstijl'];

        $profielfoto = "";
        $destFile = "";

        $fotonaam = $_FILES['profielfoto']['tmp_name'];
        if (!empty($fotonaam)) {$foto = file_get_contents($fotonaam);}

        $temp = explode(".", $_FILES['profielfoto']['name']);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $foto = $newfilename;

        $profielfoto = $foto;

        $newpassword = "";
        if(!empty($_POST['newPassword'])) {
            $salt = "qsdfg23fnjfhuu!";
            $newpassword = $_POST['newPassword'].$salt;
        } 

        define ('SITE_ROOT', realpath(dirname(__FILE__)));

        $result = $u->changeSettings($email, $voornaam, $achternaam, $profielfoto, $buddy, $newpassword, $woonplaats, $keuze, $jaar, $hobby, $muziekstijl);

        if($result === true){

            if ($fotonaam != NULL){
                $destFile = __DIR__ . '/images/uploads/avatar/' . $profielfoto;
                move_uploaded_file($_FILES['profielfoto']['tmp_name'], $destFile);
                chmod($destFile, 0666);
            }
            echo "<script>location='index.php'</script>";
        }else{
            echo $result;
        }
    }

    $conn =  Db::getConnection();
    $statement = $conn->prepare("SELECT * FROM users WHERE email = '" . $_SESSION['email'] . "'");
    $statement->execute();
    if( $statement->rowCount() > 0){
        $user = $statement->fetch(); // array van resultaten opvragen
    };

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

    <header class="header">
    <div class="container">
        <div class="wrapper">
        <h1 class="logo"><a href="index.php">Companion</a></h1>
        <a class="nav-toggle">
            <span class="toggle"></span>
            <span class="toggle"></span>
            <span class="toggle"></span>
        </a>
        </div>
        <nav class="navbar">
        <ul class="nav-menu">
            <li class="nav-item"><a href="index.php">Home</a></li>
            <li class="nav-item"><a href="updateUser.php">Update Profile</a></i>
            <li class="nav-item"><a href="friendlist.php">Friendlist</a></li>
        <li class="nav-item"><a href="logout.php">Logout</a></li>
        </nav>
    </div>
    </header>

    <div id="banner"></div>

    <div class="editField">
        <form class="password-form" method="POST" action="" enctype="multipart/form-data" id="upload-form">

                <div id="form_title">
                <h2>Profiel Editeren</h2>
                </div>

                <div class="registrerenBuddy">

                <div> 
                <label>Voornaam : </label>
                <input class="input" type="text" name="voornaam" value=<?php echo $user['voornaam'] ?> >
                </div> 

                <div> 
                <label>Achternaam : </label>
                <input class="input" type="text" name="achternaam" value=<?php echo $user['achternaam'] ?> >
                </div> 

                <div> 
                <label for="profielfoto">Profielfoto</label>
                <br>
                <div id="prev-div">
                        <img id="img-prev" style="width:200px; height:200px;" src="images/uploads/avatar/<?php echo $user['profielfoto'] ?>" alt="uploaded image" />
                </div>
                <input type="file" name="profielfoto" id="profielfoto" accept="image/gif, image/jpeg, image/png, image/jpg" onchange="readURL(this);"><br />
                <img id="imgPreview" src="images/uploads/avatar/<?php echo $user['profielfoto'] ?>" alt="" style="height: 200px;" />
                </div> 

                <div> 
                <label>Buddy of begeleider</label>
                <select id="buddy" class="input" name="buddy">
                    <option value="<?php echo $user['buddy'] ?>">
                        <?php 
                            $status = $user['buddy'];
                            if($status == 1){
                            echo "Buddy"; 
                            } else {
                                echo "Begeleider";
                            } ?> 
                    </option>
                    <option value="1">Buddy</option>
                    <option value="0">Begeleider</option>
                </select>
                </div> 

                <div> 
                <label>Woonplaats : </label>
                <input class="input" type="text" name="woonplaats" value=<?php echo $user['kenmerk1'] ?> >
                </div> 

                <div> 
                <label>Richting</label>
                <select id="buddy" class="input" name="keuze">
                    <option value="<?php echo $user['kenmerk2'] ?>"> <?php echo $user['kenmerk2'] ?> </option>
                    <option value="Design">Design</option>
                    <option value="Development">Development</option>
                </select>
                </div> 

                <div> 
                <label>Jaar</label>
                <select id="buddy" class="input" name="jaar">
                    <option value="<?php echo $user['kenmerk3'] ?>"> <?php echo $user['kenmerk3'] ?> </option>
                    <option value="1">1IMD</option>
                    <option value="2">2IMD</option>
                    <option value="3">3IMD</option>
                </select>
                </div> 

                <div> 
                <label>Hobby : </label>
                <select id="buddy" class="input" name="hobby">
                    <option value="<?php echo $user['kenmerk4'] ?>"> <?php echo $user['kenmerk4'] ?> </option>
                    <option value="sporten">Sporten</option>
                    <option value="Gamen">Gamen</option>
                    <option value="Creatief">Ceatief bezig zijn</option>
                    <option value="Feesten">Feesten</option>
                    <option value="Instrument">Instrument bespelen</option>
                    <option value="Andere">Andere</option>
                </select>
                </div> 

                <div> 
                <label>Favoriete muziekstijl : </label>
                <select id="buddy" class="input" name="muziekstijl">
                    <option value="<?php echo $user['kenmerk5'] ?>"> <?php echo $user['kenmerk5'] ?> </option>
                    <option value="pop">Pop</option>
                    <option value="jazz">Jazz</option>
                    <option value="hiphop">Hiphop/rap</option>
                    <option value="Techno">Techno</option>
                    <option value="Drumandbass">Drum and Bass</option>
                    <option value="Andere">Andere</option>
                </select>
                </div> 

                <div> 
                <label>Jouw wachtwoord:</label> 
                <input class="input" type="password" name="newPassword" placeholder="">
                </div> 

                <input class="btn-aanmelden" type="submit" value="Submit">
        </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    
    function readURL(input) {
        $("#prev-div").hide();
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#prev-div').show();
                $('#img-prev').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>


</body>

</html>