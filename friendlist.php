<?php 

    session_start();
    include_once(__DIR__ . "/classes/Db.class.php");
    include_once(__DIR__ . "/classes/User.class.php");
    include_once(__DIR__ . "/classes/Friends.class.php");

    if(empty($_SESSION['email'])){
        header("Location:login.php");
    }

    $u = new User;
    $u_id = $u->getUserID();
    $_SESSION['id'] = $u_id;

    $friends = new Friends;
    $friends = $friends->showFriends($_SESSION['id']);
    
    if (!$friends) {
        $error = "Er liep iets fout.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companion - Vriendenlijst</title>
    <link rel = "stylesheet" type = "text/css" href = "css/style.css"/>

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

<div id="geen_lid">Ga terug naar <a href="index.php">de index.</a> </div>

    <div class="friends">
                <div id="form_title">
                    <h2>Mijn Vriendenlijst</h2>
                </div>

                <div id="vriendenlijst">
                    <?php foreach($friends as $friend): ?>
                    <p> <?php echo htmlspecialchars($friend['voornaam']) . " " . htmlspecialchars($friend['achternaam']) ?> </p>
                    <?php endforeach; ?>
                </div>
    </div>

</body>
</html>