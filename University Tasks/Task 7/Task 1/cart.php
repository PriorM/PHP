<?php
    session_start();

    require 'products.php';

    if (isset($_POST['clear']) == 'Clear Cart')
    {
        unset($_SESSION['cart']);
    }

    /*elseif (isset($_POST['update']))
    {
        foreach ($_POST['update'] as $id => $val)
        {
            $val = trim($val);
            if (preg_match('/^[0-9]*$/', $val))
            {
                if ($val == 0)
                {
                    unset($_SESSION['cart'][$id]);
                }
                else
                {
                    $_SESSION['cart'][$id] = $val;
                }
            }
        }
    }*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><title>Shopping Cart</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style>
        table { border-collapse: collapse; }
        .num { text-align: right; }
        td, th, div { border: 2px solid black; padding: 4px; }
    </style>
    </head>
    <body>
        <p>The following is in your cart:</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <table>
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                </tr>
                <?php
                    //Loop through current cart
                    $counter = 0;
                    $total = 0;
                    if (@is_array($_SESSION['cart']))
                    {
                        foreach ($_SESSION['cart'] as $id => $c)
                        {
                            $counter++;
                            echo "<tr><td>{$counter}</td><td>{$products[$id]['description']}</td>",
                            "<td class=\"num\">", number_format($products[$id]['price'], 2),
                            "</td><td>{$c}</td></tr>\n";

                            //Update our total
                            $total += $products[$id]['price'] * $c;
                        }
                    }
                ?>
                <tr class="num">
                    <td colspan="3">Total: </td>
                    <td><?= number_format($total, 2) ?></td>
                </tr>
                <tr class="num">
                    <td colspan="4">
                        <input type="button" value="Keep Shopping" onclick="javascript:window.location.href='Main.php'" />
                        <!--<input type="submit" name="update" value="Update Quantities" />-->
                        <input type="submit" name="clear" value="Clear Cart"  onclick="return confirm('Are you sure you wish to empty your cart?')" />
                        <input type="button" value="Buy" onclick="javascript:window.location.href='credit.php'" />
                    </td>
                </tr>
    </body>
</html>