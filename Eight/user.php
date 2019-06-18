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
            #piece {
                visibility: hidden;
            }
        </style>
        <script>
            var tile1 = "";
            var tile2 = "";
            var tile3 = "";

            function setTIle(element)
            {
                console.log("getting called");

                console.log(element);

                var x = element.getAttribute("data-x");
                var y = element.getAttribute("data-y");

                console.log(x, y);

                if (tile1 === "")
                {
                    tile1 = "set";

                    document.getElementById("x1").value = x;
                    document.getElementById("y1").value = y;

                    element.style.backgroundColor = "red";
                }
                else if (tile2 === "")
                {
                    tile2 = "set";

                    document.getElementById("x2").value = x;
                    document.getElementById("y2").value = y;

                    element.style.backgroundColor = "red";
                }
                else if (tile3 === "")
                {
                    tile3 = "set";

                    document.getElementById("x3").value = x;
                    document.getElementById("y3").value = y;

                    element.style.backgroundColor = "red";

                    document.getElementById("piece").click();
                }
            }
        </script>
    </head>
    <body>
        <h2>A grid will be formed of 2^M x 2^M</h2>
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            Power (M) = <input type="text" name="m" /><br />
            Location P = <input type="text" name="p" /><br />
            Location Q = <input type="text" name="q" /><br />
            <input type="submit" name="inputs" />
        </form>
        <br />
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="x1" /><input type="hidden" name="y1" /><br />
            <input type="hidden" name="x2" /><input type="hidden" name="y2" /><br />
            <input type="hidden" name="x3" /><input type="hidden" name="y3" /><br />
            <input type="submit" name="piece" id="piece" />
        </form>
    </body>
</html>

<?php
    if (isset($_POST["inputs"]))
    {   
        global $Location;
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
            $Location = array();
            $TileNo = 1;
            for ($i = 1; $i < $n; $i++)
            {
                $Location[$i] = array();
                for ($j = 1; $j < $n; $j++)
                {
                    $Location[$i][$j] = 0;
                }
            }
            Arrange(1, $n, 1, $n, $p, $q);
            //Printer();
            colourPrinter();
        }
    }

    if (isset($_POST["piece"]))
    {
        $x1 = $_POST["x1"];
        $y1 = $_POST["y1"];
        $x2 = $_POST["x2"];
        $y2 = $_POST["y2"];
        $x3 = $_POST["x2"];
        $y3 = $_POST["y3"];

        userInput($x1, $y1, $x2, $y2, $x3, $y3);
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

    function userInput($x1, $y1, $x2, $y2, $x3, $y3)
    {
        global $Location;
        $uniqueTiles = true;
        if ($x1 == $x2 && $y1 == $y2)
        {
            echo "First and Second Tiles are not unique <br />";
            $uniqueTiles = false;
        }
        elseif ($x1 == $x3 && $y1 == $y3)
        {
            echo "First and Third Tiles are not unique <br />";
            $uniqueTiles = false;
        }
        elseif ($x2 == $x3 && $y2 == $y3)
        {
            echo "Second and Third Tiles are not unique <br />";
            $uniqueTiles = false;
        }

        $value1 = $Location[$x1][$y1];
        $value2 = $Location[$x2][$y2];
        $value3 = $Location[$x3][$y3];

        if ($value1 == $value2 && $value2 == $value3 && $uniqueTiles)
        {
            echo "Tiles are valid";
        }
        else
        {
            if (!$uniqueTiles)
            {
                echo "Not unique tiles";
            }
            else
            {
                echo "Incorrect Location";
            }
        }  
    } 
?>