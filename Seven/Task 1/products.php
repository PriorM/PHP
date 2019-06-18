<?php
    $db = mysqli_connect('localhost', 'root', '', 'task1') or die('DB Failure: ' . mysql_error());

    $products = array();

    $query = mysqli_query($db, "SELECT * FROM products");

    while($row = mysqli_fetch_assoc($query))
    {
        $products[] = $row;
    }
?>