<?php

    if (isset($_POST['search']))
    {
        $lowprice = $_POST['low'];
        $highprice = $_POST['high'];

        $xml = simplexml_load_file('books.xml');

        foreach($xml as $book)
        {
            if($book->price >= $lowprice && $book->price <= $highprice)
            {
                $bookname = $book->title;
                $bookprice = $book->price;

                echo "Book Title: ".$bookname.", Book Price: $".$bookprice."<br />";
            }
        }
    }
?>
<html>
    <body>
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            Low Price: <input type="text" name="low" /> <br />
            High Price: <input type="text" name="high" /> <br />
            <input type="submit" name="search" value="Search" />
        </form> 
    </body>
</html>