<?php 

    include_once ("Db.class.php");

    class Friends{

        public function showFriends($u_id){
            $conn = Db::getConnection();

            $statement = $conn->prepare("select users.id, users.voornaam, users.achternaam from users 
                                        join ( select buddies.user_id1 as user_id from buddies where buddies.user_id2 = :id 
                                        and buddies.status = 1 
                                        union 
                                        select buddies.user_id2 AS user_id from buddies where buddies.user_id1 = :id 
                                        and buddies.status = 1 ) 
                                        friends on friends.user_id = users.id");
                                        // Union word gebruikt om meerdere select statements tegelijk uit te voeren. 
            $statement->bindValue(":id", $u_id);
            $statement->execute();

            if( $statement->rowCount() > 0){
                $result = $statement->fetchAll();
                return $result;
            };
        }


        public function countFriends(){
            $conn = Db::getConnection();
            $statement=$conn->prepare("select count(*) as totalFriends from buddies where status=1");
            $statement->execute();
            $result =  $statement->fetch();
            return $result['totalFriends'];
        }

    }

?>