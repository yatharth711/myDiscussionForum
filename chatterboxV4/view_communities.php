<?php
    
    include "connectionDB.php";

    if(isset($_SESSION["uid"])){
        $sql= "select u.uid, uc.com_id, u.username, c.name, c.description from users u join user_communites uc on u.uid=uc.uid; join communities c on c.com_id=uc.com_id";
        $result= mysqli_query($conn, $sql);

        
        while($row= mysqli_fetch_assoc($result)){
            $name= $row["name"];
            $desc= $row["description"];

            echo '<h3>'.$name.'</h3>';
            echo '<p>'.$desc.'</p>';
            echo '<a href= "leave">Leave Chatterbox</a>';
        }
    }else{
        header("Location: login.php");
    }

?>