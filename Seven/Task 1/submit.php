<?php
    session_start();

    if (!isset($_SESSION['validsubmit']) || !$_SESSION['validsubmit'])
    {
        echo "ERROR: Invalid form submission, or form already submitted!";
    }
    else
    {
        $_SESSION['validsubmit'] = false;

        echo "Thank you for your purchase";
    }
?>
<html>
    <body>
    <br />
        <button value="Home" onclick="javascript:window.location.href='Main.php'">Home</button>
    </body>
</html>