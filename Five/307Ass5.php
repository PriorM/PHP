<!DOCTYPE html>
<html>
<body>
<center>
<form action="307Ass5.php" method="post">
	Student Number: <input type="text" name="id"/><br/>
	Password: <input type="password" name="pass"/><br/>
	<input type="hidden" name="studID" value="<?php echo $_POST['id']?>">
	<input type="submit" value="Login" name="login"/>
</form>
<br/>
<br/>
<br/>
<form action="307Ass5.php" method="post">
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
<form action="307Ass5.php" method="post">
	Course: <input type="text" name="course"/><br/>
	<input type="submit" value="Enroll" name="enroll"/>
</form>
<br/>
<br/>
<br/>
<form action="307Ass5.php" method="post">
	Course: <input type="text" name="courseCancel"/><br/>
	<input type="submit" value="Cancel Class" name="cancel"/>
</center>
<br/>
<?php
$servername = "localhost";
$username = "root";
$password = "fairypanel";
$db = "assessment";


// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

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
		echo "logged in";
	}
}

//Enrollment
if (isset($_POST['enroll']))
{
	$course = $_POST['course'];
	
	$query = "INSERT INTO enrolled (Name, Course) VALUES ('Angelica Ansari', '$course')";
	mysqli_query($conn, $query);
}

//Cancel
if (isset($_POST['cancel']))
{
	$course = $_POST['courseCancel'];
	
	$query = "DELETE FROM enrolled WHERE Name = 'Angelica Ansari' AND Course = '$course'";
	mysqli_query($conn, $query);
}

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

</body>
</html>