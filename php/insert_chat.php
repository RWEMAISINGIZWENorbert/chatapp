<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        include "config.php";
        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        if(!empty($message)){
            $inser_msg = mysqli_query($conn, "INSERT INTO `messages`(`outgoing_msg_id`, `incoming_msg_id`, `msg`) 
                                            VALUES ('{$outgoing_id}','{$incoming_id}','$message')");
        }
        if(isset($_FILES['send_image'])){
            $send_image = $_FILES['send_image']['name'];// user image name
            $send_image_size = $_FILES['send_image']['size'];// user image size
            $send_image_tmp_name = $_FILES['send_image']['tmp_name'];
            $image_rename = time().$send_image;
            $image_folder = '../uploaded_img/'.$image_rename;// image folder

            if(move_uploaded_file($send_image_tmp_name, $image_folder)){//moving image file)
                $inser_msg_img = mysqli_query($conn, "INSERT INTO `messages`(`outgoing_msg_id`, `incoming_msg_id`, `msg_img`) 
                VALUES ('{$outgoing_id}','{$incoming_id}','$image_rename')");
            }

        }

    }else{
        header('location: login.php');
    }
?>