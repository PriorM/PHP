<?php
        //Starts session
        session_start();

        require 'products.php';

        if (isset($_GET['add']))
        {
            @$_SESSION['cart'][$_GET['add']]++;
        }

        $total_num = 0;
        $total_value = 0;
        foreach (@$_SESSION['cart'] as $id => $count)
        {
            $total_value += $products[$id]['price'] * $count;
            $total_num += $count;
        }
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>View Products</title>
    </head>
    <meta http-equiv="Content-Type" content="text/html charset=iso-8859-1" />
    <style>
        table { border-collapse: collapse; }
        .num { text-align: right }
        #cart { float: right; text-align: center; }
        td, th, div { border: 2px solid black; padding: 5px }
        .button {
            display: block; padding: 2px 5px; background-color: #0000FF;
            color: white; text-decoration: none;
            border-style: solid; border-width: 4px;
            border-bottom-color: #000099; border-right-color: #000099;
            border-top-color: #0066FF; border-left_color: #0066FF;
        }
    </style>
    <body>
        <div id="cart">Items in your cart :<?= $total_num ?>
        <br />Total value of cart: <?= $total_value ?>
        <br /><a href="cart.php">View your cart</a>
        </div>
        <p>Please choose what products you want below:</p>
        <table>
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Buy It!</th>
            </tr>
            <?php
                //Loop through all products and list
                $counter = 0;
                foreach ($products as $id => $p)
                {
                    //Echos out all the products and give options
                    $counter++;
                    echo "<tr><td>{$counter}</td><td>{$p['description']}</td><td class=\"num\">", number_format($p['price'], 2), "</td>";

                    echo "<td><a class=\"button\" href=\"{$_SERVER['PHP_SELF']}?add={$id}\"> Add to Cart</a></td></tr>\n";
                }
            ?>
        </table>
    </body>
</html>