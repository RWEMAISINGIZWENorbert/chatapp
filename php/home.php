<?php 
    session_start();
    include 'config.php';
    $outgoing_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user_form WHERE NOT user_id = {$outgoing_id} ORDER BY user_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
       include 'user_data.php';
    }
    echo $output;

?>