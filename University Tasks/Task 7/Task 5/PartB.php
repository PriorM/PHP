<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    
    $db = mysqli_connect('localhost', 'root', '', 'task5') or die('DB Failure: ' . mysql_error());

    $debts = array();

    $query = mysqli_query($db, "SELECT * FROM debt");

    while($row = mysqli_fetch_assoc($query))
    {
        $debts[] = $row;
    }

    date_default_timezone_set('Australia/Sydney');

    function count_days($due, $current)
    {
        $secondsDiff = $due - $current;
        $dayDiff = $secondsDiff/86400;
        return $dayDiff;
    }

    function sendMail($email, $debt, $due, $name)
    {
        $subject = "Debt Overdue";
        $message = $name . " your debt of $" . $debt . " was due on " . $due . ". Please payup.";
        $headers = "From: task5B@asssessment.com";

        //mail($email, $subject, $message, $headers);

        echo "Email sent to " . $name . "<br />";
    }

    $current = date('Y/m/d');

    foreach($debts as $person)
    {
        $input = strtotime($person['dueDate']);
        $date = date('Y/m/d', $input);

        $diff = count_days($date, $current);
        if ($diff !== 0)
        {
            continue;
        }
        if ($diff === 0)
        {
            $name = $person['title'] . ". " . $person['firstName'] . " " . $person['lastName'];
            sendMail($person['email'], $person['debtAmount'], $person['dueDate'], $name);
        }
    }
    echo "All emails sent";
?>