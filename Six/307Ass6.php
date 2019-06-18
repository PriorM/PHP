<!DOCTYPE html>
<html>
    <body>
    <center>
        <form action="307Ass6.php" method="post">
            Student Number: <input type="text" name="id"/><br/>
            Password: <input type="password" name="pass"/><br/>
            <input type="submit" value="Login" name="login"/>
        </form>
        <br/>
        <br/>
        <br/>
        <form action="Enquiry.php" method="post">
            <!--Query 1-->
            Search for Departments in School: <input type="text" name="deptSearch"> <input type="submit" value="Submit" name="deptSubmit"/> <br/>
            <!--Query 2-->
            Search for Students in Course: <input type="text" name="studSearch"> <input type="submit" value="Submit" name="studSubmit"/> <br/>
            <!--Query 3-->
            Search for Professors in School: <input type="text" name="profSearch"> <input type="submit" value="Submit" name="profSubmit"/> <br/>
            <!--Query 4-->
            Search for Students in each Course: <input type="submit" value="Submit" name="studsSubmit"/> <br/>
            <!--Query 5-->
            Search for Professors in each School: <input type="submit" value="Submit" name="profsSubmit"/> <br/>
            <!--Query 6-->
            Search for Students with Professor: <input type="text" name="studProf"> <input type="submit" value="Submit" name="studsProf"/> <br/>
            <!--Query 7-->
            Search for Number of Students enrolled in classes: <input type="submit" value="Submit" name="numStuds"/> <br/>
        </form>
        <br/>
        <br/>
        <br/>
        <form action="Enrolment.php" method="post">
            Course: <input type="text" name="course"/><br/>
            <input type="submit" value="Enroll" name="enroll"/>
        </form>
        <br/>
        <br/>
        <br/>
        <form action="Cancelation.php" method="post">
            Course: <input type="text" name="courseCancel"/><br/>
            <input type="submit" value="Cancel Class" name="cancel"/>
        </center>
        <br/>           

        <?php

        session_start();

        $servername = "localhost";
        $username = "root";
        $db = "assessment";


        // Create connection
        $conn = mysqli_connect($servername, $username, '',$db);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully<br>";

        //Login
        if (isset($_POST["login"]))
        {
                $user_name = $_POST['id'];
                $user_pass = $_POST['pass'];
                
                if (!$user_name || !$user_pass)
                {
                    echo 'You have not entered all the required details. Try again';
                    exit;
                }


            $query = "SELECT StudentID, Pass FROM students WHERE StudentID = '$user_name'";
            $result = $conn->query($query);

            if (!$result = $conn->query($query))
            {
                die('There was an error running the query [' . $conn->error. ']');
            }
            else
            {
                echo "it's ok<br/>";
            }

            $row = $result->fetch_assoc();

            if ($row['StudentID'] == "$user_name" && $row['Pass'] == $user_pass)
            {
                echo "logged in<br/>";
                $user = "SELECT students.Name FROM students WHERE StudentID = '$user_name'";
                $userResult = mysqli_query($conn, $user);
                $userRow = mysqli_fetch_assoc($userResult);
                $username = $userRow['Name'];
                $_SESSION['username'] = $username;

                $coursesQuery = "SELECT enrolled.Course FROM enrolled LEFT JOIN students ON enrolled.Name = students.Name WHERE students.NAME LIKE '%$username%'";
                $courses = $conn->query($coursesQuery);
                while ($courseRow = mysqli_fetch_assoc($courses))
                {
                    echo "Enrolled in:";
                    echo $courseRow['Course'];
                    echo "<br />";
                }
            }
        }
        ?>
    </body>
</html>