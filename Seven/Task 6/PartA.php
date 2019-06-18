<?php
    function recursive_array_min($a)
    {
        foreach($a as $value)
        {
            if (is_array($value))
            {
                $value = recursive_array_min($value);
            }

            if (!(isset($min)))
            {
                $min = $value;
            }
            else
            {
                $min = $value < $min ? $value : $min;
            }
        }

        return $min;
    }

    $dimensional1 = array(57, array(3, 35), array(235, 534, 73, array(3, 4, 956), 6), 14, 2, array(5, 74, 73));
    $dimensional2 = array(56, array(12, 123), array(142, 8, 412, array(1, 57, 1254), 5, 34, array(4567, 734, 12)));
    $dimensional3 = array(65, array(9, 10), array(0, 123, 1, array(123, 567, 13), 5), 123, 15, array(125, 9845, 142));

    $min1 = recursive_array_min($dimensional1);
    $min2 = recursive_array_min($dimensional2);
    $min3 = recursive_array_min($dimensional3);

    echo "<p>The minimum value for Array 1 was: {$min1}</p>";
    echo "<p>The minimum value for Array 2 was: {$min2}</p>";
    echo "<p>The minimum value for Array 3 was: {$min3}</p>";
?>