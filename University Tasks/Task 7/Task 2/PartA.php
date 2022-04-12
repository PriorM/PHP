<?php

    if (isset($_POST['convert_btn']))
    {
        $convert = $_POST['toConvert'];

        echo '<pre>';
        echo $convert . " becomes ", romanize($convert);
        echo '</pre>';
    }
    function romanize($num)
    {
        $onlynum = preg_replace('/\D/', '', $num);
        $n = intval($onlynum);
        $result = '';

        $lookup =  array('M' => 1000,
                         'CM' => 900,
                         'D' => 500,
                         'CD' => 400,
                         'C' => 100,
                         'XC' => 90,
                         'L' => 50,
                         'XL' => 40,
                         'X' => 10,
                         'IX' => 9,
                         'V' => 5,
                         'IV' => 4,
                         'I' => 1);
        
        foreach ($lookup as $roman => $value)
        {
            $matches = intval($n / $value);

            $result .= str_repeat($roman, $matches);

            $n = $n % $value;
        }

        return $result;
    }
?>
<html>
    <head>
        <title>Roman conversion</title>
    </head>
    <body>
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            Input: <input type="text" name="toConvert" />
            <input type="submit" name="convert_btn" />
        </form>
    </body>
</html>