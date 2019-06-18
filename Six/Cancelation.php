<?php

    include('307Ass6.php');

    //Cancel
    if (isset($_POST['cancel']))
    {
        $course = $_POST['courseCancel'];
        $user = $_SESSION['username'];
        
        $query = "DELETE FROM enrolled WHERE Name = '$user' AND Course = '$course'";
        mysqli_query($conn, $query);

        echo "Cancelation successful";
    }
?>