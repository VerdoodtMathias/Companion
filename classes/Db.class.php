
<?php 

    class Db{
        
        private static $conn; // 1 uitwerking van je DB klasse -> je kan geen meerdere instatnties zoals bv meerdere users aanmaken

        public static function getConnection(){

            include_once(__DIR__ . "/../settings/settings.php");

            if(self::$conn === null){
                self::$conn = new PDO('mysql:host='. SETTINGS['db']['host'] .';dbname='. SETTINGS['db']['db'] .'', SETTINGS['db']['user'] , SETTINGS['db']['password'] );
                return self::$conn;
            } else {
                return self::$conn;
            }
            
        }

    }

?>
