<?php
    session_start();
    $db = mysqli_connect('localhost', 'root', '', 'task4');

    if (isset($_POST['login']))
    {
        $errors = array();
        $email = $_POST['email'];
        $password = $_POST['pword'];
        $id = '';

        if (empty($email))
        {
            array_push($errors, "email is required");
        }
        if (empty($password))
        {
            array_push($errors, "password is required");
        }

        if (count($errors) == 0)
        {
            $password = $password;

            $query = "SELECT * FROM members WHERE email='$email' AND password='$password' LIMIT 1";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1)
            {
                echo "Welcome";
                $row = mysqli_fetch_assoc($results);
                $id = $row['id'];
                $_SESSION['ID'] = $id;
            }
            else
            {
                echo "User doesn't exist";
            }
        }
    }

    if (isset($_POST['search']))
    {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $foundItems = array();

        $query = "SELECT * FROM items WHERE book_title LIKE'%$title%' OR book_author LIKE '%$author%'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 0)
        {
            echo "No books found";
        }
        else
        {
            while($row = mysqli_fetch_assoc($results))
            {
                $foundItems[] = $row;
            }
        }

        if (isset($_POST['hold']))
        {
            $chosen = $_POST['book_hold'];

            $query = "SELECT * FROM items WHERE book_title LIKE '%$chosen%'";
            $results = mysqli_query($db, $query);

            $row = mysqli_fetch_assoc($results);
            $title = $row['book_title'];
            $author = $row['book_author'];
            $id = $_SESSION['ID'];

            $query = "INSERT INTO held_items (id, book_title, book_author) VALUES ('$id', '$title', '$author')";
            mysqli_query($db, $query);

            $query = "UPDATE items SET held=1 WHERE book_title='$title' AND book_author='$author'";
            mysqli_query($db, $query);
        }

        function create_option_list($id, $data)
        {
            $options = "<option value=\"\">Select one...</option>\n";

            foreach ($data as $x)
            {
                $selected = ($id == $x['book_title']) ? ' selected' : '';

                $options .= "<option value=\"{$x['book_title']}\"{$sel} > {$x['book_title']}</option>\n";
            }

            return $options;
        }
    }

?>
<html>
    <head>
        <title>Library Site</title>
    </head>
    <body>
        <!--login-->
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            Email: <input type="text" name="email" /><br />
            Password: <input type="password" name="pword" /><br />
            <input type="submit" name="login" value="Login" /><br />
        <!--see borrowed items and due dates-->
        <?php
            global $email;
            $query = "SELECT book_title, book_author, due_date FROM borrowed_items LEFT JOIN members ON borrowed_items.id = members.id WHERE members.email = '$email'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) != 0)
            {
                while($row = mysqli_fetch_assoc($results))
                {
                    echo "Book Title: ".$row['book_title']."  Author: ".$row['book_author']."   Due: ".$row['due_date']."<br />";
                }
            }
            else
            {
                echo "No borrowed items for user <br />";
            }
        ?>
        <!--search and hold-->
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            Book Title: <input type="text" name="title"><br />
            Author: <input type="text" name="author"><br />
            <input type="submit" name="search" value="Search" /><br />
        </form>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="form3">
            <p><select name="book_hold"> <?= create_option_list(@$_POST['book_hold'], $foundItems) ?></select></p>
            <p><input type="submit" name="hold" /></p>
        </form>
    </body>
</html>