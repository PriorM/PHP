<?php

    include('307Ass6.php');

    //Query 1
    if (isset($_POST['deptSubmit']))
    {
        $searchTerm = $_POST['deptSearch'];
        
        $query = "SELECT Name FROM department WHERE school LIKE '%$searchTerm%'";
        $result = $conn->query($query);
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "Name: ".$row["Name"]."<br/>";
        }		
    }

    //Query 2
    if (isset($_POST['studSubmit']))
    {
        $searchTerm = $_POST['studSearch'];
        
        $query = "SELECT Name FROM enrolled WHERE Course LIKE '%$searchTerm%'";
        $result = $conn->query($query);
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "Name: ".$row["Name"]."<br/>";
        }
    }

    //Query 3
    if (isset($_POST['profSubmit']))
    {
        $searchTerm = $_POST['profSearch'];
        
        $query = "SELECT Name FROM professors WHERE School LIKE '%$searchTerm%'";
        $result = $conn->query($query);
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "Name: ".$row["Name"]."<br/>";
        }
    }

    //Query 4
    if (isset($_POST['studsSubmit']))
    {
        $query = "SELECT Course, COUNT(Course) FROM enrolled GROUP BY Course";
        $result = $conn->query($query);
        
        while($row = mysqli_fetch_assoc($result))
        {
            echo "Name: ".$row["Course"]." Count: ".$row["COUNT(Course)"]."<br/>";
        }
    }

    //Query 5
    if (isset($_POST['profsSubmit']))
    {
        $query = "SELECT School, COUNT(School) FROM professors GROUP BY School";
        $result = $conn->query($query);
        
        while($row = mysqli_fetch_assoc($result))
        {
            echo "Name: ".$row["School"]." Count: ".$row["COUNT(School)"]."<br/>";
        }
    }

    //Query 6
    if (isset($_POST['studsProf']))
    {
        $searchTerm = $_POST['studProf'];
        
        $query = "SELECT enrolled.Name AS Name FROM enrolled LEFT JOIN course ON enrolled.Course = course.Name WHERE course.Professor LIKE '%$searchTerm%'";
        $result = $conn->query($query);
        
        while($row = mysqli_fetch_assoc($result))
        {
            echo "Name: ".$row["Name"]."<br/>";
        }
    }

    //Query 7
    if (isset($_POST['numStuds']))
    {
        $query = "SELECT school.Name AS School, COUNT(enrolled.Name) FROM course LEFT JOIN enrolled ON enrolled.Course = course.Name LEFT JOIN department ON department.Name = course.Department LEFT JOIN school ON school.Name = department.school GROUP BY school.Name";
        $result = $conn->query($query);
        
        while($row = mysqli_fetch_assoc($result))
        {
            echo "School: ".$row["School"]." Count: ".$row["COUNT(enrolled.Name)"]."<br/>";
        }
    }
?>