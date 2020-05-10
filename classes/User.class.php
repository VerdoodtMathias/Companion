<?php

    include_once ("Db.class.php");

        class User{
            private $voornaam;
            private $achternaam;
            private $email;
            private $password;
            private $profielfoto;
            private $buddy;

            private $kenmerk1; 
            private $kenmerk2; 
            private $kenmerk3;
            private $kenmerk4; 
            private $kenmerk5;

            public function getVoornaam(){
                return $this->voornaam;
            }
    
            public function setVoornaam($voornaam){
    
                if (empty ($voornaam)){
                    throw new Exception ("Gelieve je voornaam in te voeren.");
                }
    
                $this->voornaam = $voornaam;
                return $this;
            }
            
            public function getAchternaam(){
                return $this->achternaam;
            }
    
            public function setAchternaam($achternaam){
    
                if (empty ($achternaam)){
                    throw new Exception ("Gelieve je achternaam in te voeren.");
                }  
                
                $this->achternaam = $achternaam;
                return $this;
            }
    
            public function getEmail(){
                return $this->email;
            }
    
            public function setEmail($email){
                
                $emailCheck = strrpos($email, "@student.thomasmore.be");
    
                if (empty ($email)){
                    throw new Exception ("Gelieve je email in te voeren.");
                }
    
                if ($emailCheck === false) { 
                    throw new Exception ("Vul een geldig email adress in");
                }
        
                $this->email = $email;
                return $this;
            }
    
            public function getPassword(){
                return $this->password;
            }
    
            public function setPassword($password){
    
                if (empty ($password)){
                    throw new Exception ("Gelieve een wachtwoord in te voeren.");
                }
    
                $this->password = $password;
                return $this;
            }

            public function getBuddy(){
                return $this->buddy;
            }
    
            public function setBuddy($buddy){
                $this->buddy = $buddy;
                return $this;
            }
    
            public function getProfielfoto(){
                return $this->profielfoto;
            }
    
            public function setProfielfoto($profielfoto){
                $this->profielfoto = $profielfoto;
                return $this;
            }
    
    
            public function getKenmerk1(){
                return $this->kenmerk1;
            }
    
            public function setKenmerk1($kenmerk1){
                $this->kenmerk1 = $kenmerk1;
                return $this;
            }
    
            public function getKenmerk2(){
                return $this->kenmerk2;
            }
    
            public function setKenmerk2($kenmerk2){
                $this->kenmerk2 = $kenmerk2;
                return $this;
            }
    
            public function getKenmerk3(){
                return $this->kenmerk3;
            }
    
            public function setKenmerk3($kenmerk3){
                $this->kenmerk3 = $kenmerk3;
                return $this;
            }
    
            public function getKenmerk4(){
                return $this->kenmerk4;
            }
    
            public function setKenmerk4($kenmerk4){
                $this->kenmerk4 = $kenmerk4;
                return $this;
            }
    
            public function getKenmerk5(){
                return $this->kenmerk5;
            }
    
            public function setKenmerk5($kenmerk5){
                $this->kenmerk5 = $kenmerk5;
                return $this;
            }

        public static function getAll(){

            $conn = Db::getConnection();
            $statement = $conn->prepare("select * from users");
            $statement->execute();
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        }

        public function save(){

            $conn = Db::getConnection();

            //dubbele emails controleren
            if (isset($_POST['email'])) {

                $email = $this->getEmail();
                $conn = Db::getConnection();
                $sql = "SELECT * FROM users WHERE email='$email'";
                $results = $conn->query($sql);

                if ($results->rowCount() > 0) {
                        throw new Exception("Het ingegeven emailadres is al reeds in gebruik.");
                        echo "taken";
                }

                session_start();
                $_SESSION['email'] = $this->email;
            }

		        $statement = $conn->prepare("insert into users (email, voornaam, achternaam, wachtwoord) values (:email, :voornaam, :achternaam, :wachtwoord)");

            	$email = $this->getEmail();
            	$voornaam = $this->getVoornaam();
            	$achternaam = $this->getAchternaam();
            	$wachtwoord = $this->getPassword();

            	$statement->bindValue(":email", $email);
            	$statement->bindValue(":voornaam", $voornaam);
            	$statement->bindValue(":achternaam", $achternaam);
            	$statement->bindValue(":wachtwoord", $wachtwoord);

            	if( $statement->execute() ){
			        return true;
		        }

        }

        public function canLogin() {

            $conn = Db::getConnection();
            $statement = $conn->prepare("select wachtwoord from users where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->execute();
            $dbPassword = $statement->fetchColumn();

            if (password_verify($this->password, $dbPassword)) {
                session_start();
                $_SESSION['email'] = $this->email;
			    return true;

                // $statement = $conn->prepare("select * from users where email = :email");
                // $statement->bindParam(":email", $_SESSION['email']);
                // $statement->execute();
                // $result = $statement->fetch(PDO::FETCH_ASSOC);

                // if( !empty($result['buddy']) || !empty($result['kenmerk1']) || !empty($result['kenmerk2']) || !empty($result['kenmerk3']) || !empty($result['kenmerk4']) || !empty($result['kenmerk5']) ){
                //     header("Location: index.php");
                // } else {
                //     header("Location: updateUser.php");
                // }
            }
        }

        public function getUserID(){
            $conn = Db::getConnection();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindValue(":email", $_SESSION['email']);
            $statement->execute();
            $result =  $statement->fetch();
            return $result['id'];
        }

        public function changeSettings($email, $voornaam, $achternaam, $profielfoto, $buddy, $newpassword, $woonplaats, $keuze, $jaar, $hobby, $muziekstijl){ 

            // $conn = Db::getConnection();
                
            // if($email != $newEmail){
            //     $statementCheck = $conn->prepare("select * from users where email = :email");
            //     $statementCheck->bindValue(":email", $email);
            //     $statementCheck->execute();
            //     $userExist = $statementCheck->rowCount();
            // }
                
            // else{
            //     $userExist = 0;
            // }
            
            $conn =  Db::getConnection();
            $statement = $conn->prepare("select wachtwoord from users where email = :email");
            $statement->bindParam(":email", $email);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if(password_verify($newpassword, $result['wachtwoord']) ){
                //if ($userExist == 0) {
                    //username bestaat niet of is niet veranderd, gegevens aanpassen
            
                    $conn =  Db::getConnection();
                    $statement = $conn->prepare("UPDATE users SET voornaam=:voornaam, achternaam=:achternaam, profielfoto=:profielfoto, buddy=:buddy, kenmerk1=:woonplaats, kenmerk2=:keuze, kenmerk3=:jaar, kenmerk4=:hobby, kenmerk5=:muziek WHERE email = :email");
                    $statement->bindParam(":voornaam", $voornaam);
                    $statement->bindParam(":achternaam", $achternaam);
                    $statement->bindParam(":profielfoto", $profielfoto);
                    $statement->bindParam(":buddy", $buddy);
                    $statement->bindParam(":email", $email);
                    $statement->bindParam(":woonplaats", $woonplaats);
                    $statement->bindParam(":keuze", $keuze);
                    $statement->bindParam(":jaar", $jaar);
                    $statement->bindParam(":hobby", $hobby);
                    $statement->bindParam(":muziek", $muziekstijl);

            
                    if($statement->execute()){
                        return true;
                    }else{
                        echo "Er is iets foutgelopen bij het updaten.";
                    }
                // }else{
                //     //username bestaat wel, mag niet veranderd worden
                //     return "ERROR: Gelieve een andere username te kiezen";
                // }
            } else {
                echo "Fout wachtwoord.";
                return false;
            }
        }

        public function countUsers(){
            $conn = Db::getConnection();
            $statement=$conn->prepare("select count(*) as totalUsers from users");
            $statement->execute();
            $result =  $statement->fetch();
            return $result['totalUsers'];
        }
    }
?>