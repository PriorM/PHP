<html>
    <body>
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            Input: <input type="text" name="disks" />
            <input type="submit" name="submit" />
        </form>
    </body>
</html>
<?php
    $n = 0;
    if (isset($_POST['submit']))
    {
        $n = $_POST['disks'];
        TowerOfHanoi($n, 1, 2, 3);
    }

    function TowerOfHanoi($n, $fromP, $toP, $viaP)
    {
        if ($n === 1)
        {
            echo "Move disk from pole " . $fromP . " to pole " . $toP . "<br />";
        }
        else
        {
            TowerOfHanoi($n - 1, $fromP, $viaP, $toP);
            TowerOfHanoi(1, $fromP, $toP, $viaP);
            TowerOfHanoi($n - 1, $viaP, $toP, $fromP);
        }
    }
?>