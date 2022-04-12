<?php

    include('307Ass6.php');

    //Enrollment
    if (isset($_POST['enroll']))
    {
        $course = $_POST['course'];
        $user = $_SESSION['username'];
        
        $query = "INSERT INTO enrolled (Name, Course) VALUES ('$user', '$course')";
        mysqli_query($conn, $query);

        echo "Enrolment successful";
    }
?>