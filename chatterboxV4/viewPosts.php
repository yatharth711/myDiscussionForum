<?php
    session_start();
    include "connectionDB.php";

    if(isset($_SESSION["uid"])){
        $sql= "select u.uid, u.username, p.title, p.text, p.img, p.date, p.likes, p.dislikes, c.name from users u join content p on p.author=u.uid join communities c on c.com_id=p.com_id group by p.com_id order by date desc" ;
        $result= mysqli_query($conn, $sql);
        while($row= mysqli_num_rows($result)){
            echo '<h3>'.$row["title"].'</h3>';
            echo '<p>'.$row["content"].'</p>';
            echo '<p>'.$row["username"].'</p>';
            echo '<p>'.$row["date"].'</p>';
            echo '<p>'.$row["content"].'</p>';
            if($row["img"]!= null){
                echo '<p>'.$row["img"].'</p>';
            }
            echo '<p>'.$row["likes"].'</p>';
            echo '<p>'.$row["dislikes"].'</p>';
        }

    }else{
        header("Location: login.php");
    }

?>