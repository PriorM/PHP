<?php
    session_start();

    if (!isset($_SESSION['validsubmit']))
    {
        $_SESSION['validsubmit'] = true;
    }

    if (isset($_POST['pay']))
    {
        $type = $_POST['type'];
        $num = $_POST['num'];

        $st = standardize_credit($num);
        $valid = validate_credit($num, $type);

        $output = $valid ? 'Valid' : 'Invalid';

        if ($output == "Invalid")
        {
            echo "<p>{$output} card. Try Again";
        }
        else
        {
            header("location: submit.php");
        }
    }
    //Function to accept and clean up cc numbers
    function standardize_credit($num)
    {
        return preg_replace('/[^0-9]/', '', $num);
    }

    //Function to validate cc number
    function validate_credit($num, $type)
    {
        $len = strlen($num);
        $d2 = substr($num,0,2);

        if ( 
            //for Visas
            (($type == 'v') && (($num{0} != 4) || !(($len == 13) || ($len == 16)))) ||
            //for Mastercards
            (($type == 'm') && (($d2 < 51) || ($d2 > 56) || ($len != 16)))
            )
            {
                return false;
            }

            $digits = str_split($num);
            $digits = array_reverse($digits);

            foreach(range(1, count($digits) - 1, 2) as $x)
            {
                $digits[$x] *= 2;

                if ($digits[$x] > 9)
                {
                    $digits[$x] = ($digits[$x] - 10) + 1;
                }
            }
            $checksum = array_sum($digits);
            
            return (($checksum % 10) == 0) ? true : false;
    }
?>
<html>
    <head>
        <title>Payment</title>
    </head>
    <body>
        <center>
            <form action="credit.php" method="post">
                Card Type: <select name="type">
                    <option value=""></option>
                    <option value="v">Visa</option>
                    <option value="m">Mastercard</option>
                </select>
                <br />
                Name on card: <input type="text" name="cardname" /><br />
                Card Number: <input type="text" name="num" /><br />
                CCV: <input type="text" name="ccv" /><br />
                Month: <input type="text" name="month" /> Year: <input type="text" name="year" /><br />
                <input type="submit" value="Pay" name="pay" />
            </form>
        </center>
    </body>
</html>