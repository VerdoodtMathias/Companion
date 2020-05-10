<?php

    session_start();

    include_once(__DIR__ . "/classes/Db.class.php");
    include_once(__DIR__ . "/classes/User.class.php");
    include_once(__DIR__ . "/classes/Friends.class.php");

    if(empty($_SESSION['email'])){
        header("Location:login.php");
    }

    $u = new User;
    $u = $u->countUsers();
    if (!$u) {
        $error = "Er liep iets fout.";
    }

    $friends = new Friends;
    $friends = $friends->countFriends();
    if (!$friends) {
        $error = "Er liep iets fout.";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Het IMD Buddy netwerk waar (nieuwe) vriendschappen ontstaan.">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Companion</title>
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

    <div id="resultaten">
        Totaal aantal geregistreerd: <?php echo $u; ?><br />
        Totaal aantal vriendschappen: <?php echo $friends; ?><br />
    </div>
    

</body>

</html>