<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        include "config.php";
        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
         $sql = "SELECT * FROM messages LEFT JOIN user_form ON user_form.user_id = messages.outgoing_msg_id
                    WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                    OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id ";
        $query = mysqli_query($conn, $sql);
        $sql3 = mysqli_query($conn, "SELECT * FROM user_form WHERE user_id = '$incoming_id' ")
                                    or die('query failed');
        $row2 = mysqli_fetch_assoc($sql3);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    if($row['msg'] == '' && $row['msg_img'] != ''){// if user chat is image
                        $output .= '<div class="chat outgoing">
                        <div class="details">
                            <p><img src="uploaded_img/'.$row['msg_img'].'" alt=""></p>
                        </div>
                    </div>';
                    }else{
                        $output .= '<div class="chat outgoing">
                        <div class="details">
                            <p>'.$row['msg'].'</p>
                        </div>
                    </div>';
                    }
                }else{
                    if($row['msg'] == '' && $row['msg_img'] != ''){// if user chat is image
                        $output .= ' <div class="chat incoming">
                        <img src="uploaded_img/'.$row2['img'].'" alt="">
                        <div class="details">
                            <p><img src="uploaded_img/'.$row['msg_img'].'" alt=""></p>
                        </div>
                    </div>';
                    }else{
                        $output .= ' <div class="chat incoming">
                        <img src="uploaded_img/'.$row2['img'].'" alt="">
                        <div class="details">
                            <p>'.$row['msg'].'</p>
                        </div>
                    </div>';
                    }
                }
            }
            }else{
                $output .= '<div class="text">
                <img src="uploaded_img/'.$row2['img'].'" alt="">
                <span>no message are available. once you send message will appear here.</span>
            </div>';
        }
        echo $output;
    }else{
        header('location: login.php');
    }

?>