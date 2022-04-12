<html>
    <head>
        <style>
            table {
                border: 1px solid black;
                table-layout: fixed ;
                border-collapse: collapse;
                width: 100%;
                height: 100%;
                }
            tr, td {
                width: 25%;
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <h2>A grid will be formed of 2^M x 2^M</h2>
        <form method='post' action="<?= $_SERVER['PHP_SELF'] ?>">
            Power (M) = <input type="text" name="m" /><br />
            Location P = <input type="text" name="p" /><br />
            Location Q = <input type="text" name="q" /><br />
            <input type="submit" name="inputs" />
        </form>
    </body>
</html>

<?php
    if (isset($_POST["inputs"]))
    {   
        $m = $_POST["m"];
        if ($m > 6)
        {
            echo "Power must be less than or equal to 6";
        }
        else
        {
            $p = $_POST["p"];
            $q = $_POST["q"];
            $n = pow(2, $m);
            $TileNo = 1;
            $Location = array();
            for ($i = 1; $i < $n; $i++)
            {
                $Location[$i] = array();
                for ($j = 1; $j < $n; $j++)
                {
                    $Location[$i][$j] = 0;
                }
            }
            Arrange(1, $n, 1, $n, $p, $q);
            Printer();
            colourPrinter();
        }
    }

    function Arrange($r1, $r2, $col1, $col2, $rfilled, $cfilled)
    {
        global $Location, $TileNo;
        if ($r2 - $r1 == 1)
        {
            for ($r = $r1; $r <= $r2; $r++)
            {
                for ($col = $col1; $col <= $col2; $col++)
                {
                    if ($r != $rfilled || $col != $cfilled)
                    {
                        $Location[$r][$col] = $TileNo;
                    }
                }
            }
            $TileNo = $TileNo + 1;
        }
        else
        {
            $middle_Row = ($r1 + $r2 - 1)/2;
            $middle_Col = ($col1 + $col2 - 1)/2;
            if ($rfilled <= $middle_Row && $cfilled <= $middle_Col)
            {
                $situation = "upper_left";
            }
            elseif ($rfilled <= $middle_Row && $cfilled > $middle_Col)
            {
                $situation = "upper_right";
            }
            elseif ($rfilled > $middle_Row && $cfilled <= $middle_Col)
            {
                $situation = "lower_left";
            }
            elseif ($rfilled > $middle_Row && $cfilled > $middle_Col)
            {
                $situation = "lower_right";
            }

            switch ($situation)
            {
                case "upper_left":
                    Arrange($r1, $middle_Row, $col1, $middle_Col, $rfilled, $cfilled);
                    Arrange($r1, $middle_Row, $middle_Col + 1, $col2, $middle_Row, $middle_Row + 1);
                    Arrange($middle_Row + 1, $r2, $col1, $middle_Col, $middle_Row + 1, $middle_Col);
                    Arrange($middle_Row + 1, $r2, $middle_Col + 1, $col2, $middle_Row + 1, $middle_Col + 1);
                    $Location[$middle_Row][$middle_Col + 1] = $TileNo;
                    $Location[$middle_Row + 1][$middle_Col] = $TileNo;
                    $Location[$middle_Row + 1][$middle_Col + 1] = $TileNo;
                    break;
                case "upper_right":
                    Arrange($r1, $middle_Row, $col1, $middle_Col, $middle_Row, $middle_Col);
                    Arrange($r1, $middle_Row, $middle_Col + 1, $col2, $rfilled, $cfilled);
                    Arrange($middle_Row + 1, $r2, $col1, $middle_Col, $middle_Row + 1, $middle_Col);
                    Arrange($middle_Row + 1, $r2, $middle_Col + 1, $col2, $middle_Row + 1, $middle_Col + 1);
                    $Location[$middle_Row][$middle_Col] = $TileNo;
                    $Location[$middle_Row + 1][$middle_Col] = $TileNo;
                    $Location[$middle_Row + 1][$middle_Col + 1] = $TileNo;
                    break;
                case "lower_left":
                    Arrange($r1, $middle_Row, $col1, $middle_Col, $middle_Row, $middle_Col);
                    Arrange($r1, $middle_Row, $middle_Col + 1, $col2, $middle_Row, $middle_Col + 1);
                    Arrange($middle_Row + 1, $r2, $col1, $middle_Col, $rfilled, $cfilled);
                    Arrange($middle_Row + 1, $r2, $middle_Col + 1, $col2, $middle_Row + 1, $middle_Col + 1);
                    $Location[$middle_Row][$middle_Col] = $TileNo;
                    $Location[$middle_Row][$middle_Col + 1] = $TileNo;
                    $Location[$middle_Row + 1][$middle_Col + 1] = $TileNo;
                    break;
                case "lower_right":
                    Arrange($r1, $middle_Row, $col1, $middle_Col, $middle_Row, $middle_Col);
                    Arrange($r1, $middle_Row, $middle_Col + 1, $col2, $middle_Row, $middle_Col + 1);
                    Arrange($middle_Row + 1, $r2, $col1, $middle_Col, $middle_Row + 1, $middle_Col);
                    Arrange($middle_Row + 1, $r2, $middle_Col + 1, $col2, $rfilled, $cfilled);
                    $Location[$middle_Row][$middle_Col] = $TileNo;
                    $Location[$middle_Row][$middle_Col + 1] = $TileNo;
                    $Location[$middle_Row + 1][$middle_Col] = $TileNo;
                    break;
            }
            $TileNo = $TileNo + 1;
        }
    }

    function Printer()
    {
        global $Location;
        echo "<table>";
        foreach ($Location as $row)
        {
            echo "<tr>";
            foreach ($row as $cell)
            {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    }

    function colourPrinter()
    {
        global $Location;
        echo "<table>";
        foreach ($Location as $row) 
        { 
            echo "<tr>";
            foreach ($row as $cell) 
            { 
                $red=$cell*7%255;
                $green=$cell*11%255;
                $blue=$cell*17%255;
                echo "<td style='background-color:rgb($red,$green,$blue)'>" . $cell . "</td>" ; 
            }
            echo "</tr>";	 
        }
        echo "</table>";
    
    }
?>