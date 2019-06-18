<!--Obtaining Multidimensional arrays of form data (form1)-->
<?php
    if (isset($_POST['countries']))
    {
        echo "<p>You claim to have visited the following countries: ";

        foreach($_POST['countries'] as $num => $val)
        {
            echo "<br />", ($num + 1), ". {$val}\n";
        }
        echo "</p>\n";
    }
?>
<!--Accepting uploaded files (form2)-->
<?php
    if(count($_FILES))
    {
        if(!($_FILES['attachment']['size']))
        {
            echo "<p>ERROR: No file uploaded<p>\n";
        }
        else
        {
            $newname = dirname(__FILE__) . '/' . basename($_FILES['attachment']['name']);

            if (!(move_uploaded_file($_FILES['attachment']['tmp_name'], $newname)))
            {
                echo "<p>ERROR: A problem occurred during file upload!</p>\n";
            }
            else
            {
                echo "<p>Done! The file has been saved as: {$newname}</p>\n";
            }
        }
    }
?>
<!--Generating select statements (form3)-->
<?php
    if (isset($_POST['future']))
    {
        echo "<p>You submitted the following country ID numbers: <br />
        1st - {$_POST['1st']}, 2nd -  {$_POST['2nd']}, 3rd - {$_POST['3rd']}</p>";
    }

    function create_option_list($id, $data)
    {
        $options = "<option value=\"\">Select one...</option>\n";

        foreach ($data as $x)
        {
            $selected = ($id == $x['id']) ? ' selected' : '';

            $options .= "<option value=\"{$x['id']}\"{$sel} > {$x['desc']}</option>\n";
        }

        return $options;
    }

    $types = array(
        array('id' => 10, 'desc' => 'Japan'),
        array('id' => 11, 'desc' => 'Ireland'),
        array('id' => 12, 'desc' => 'South Korea'),
        array('id' => 20, 'desc' => 'Canada'),
        array('id' => 32, 'desc' => 'China'),
        array('id' => 45, 'desc' => 'Denmark'),
        array('id' => 34, 'desc' => 'Fiji'),
        array('id' => 75, 'desc' => 'Malaysia'),
        array('id' => 87, 'desc' => 'New Zealand'),
    );
?>
<!--Requiring certain fields to be submitted (form4)-->
<?php
    $required = array('name' => 'Name', 'phone' => 'Phone Number', 'country' => 'Country');

    if (count($_POST))
    {
        $errors = '';

        foreach ($required as $field => $desc)
        {
            if (!isset($_POST[$field]) || (trim($_POST[$field]) === ''))
            {
                $errors .= "<br />{$desc} is a required field!\n";
            }
        }
    }

    if ($errors)
    {
        echo "<p style=\"color: red\"> The following errors were found: {$errors}</p>\n";
    }
    else
    {
        echo "Thank you for leaving your details.";
    }
?>
<html>
    <head>
        <title>Countries I've visited</title>
    </head>
    <body>
        <p>Country visitation form</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="form1">
            <ol>
                <?php
                    echo str_repeat('<li><input name="countries[]" type="text" /></li>', 12);
                ?>
            </ol>
            <p><input type="submit" /></p>
        </form>
        <p>Upload pictures from my travels</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="form2">
            <input type="hidden" name="MAX_FILE_SIZE" value="8388608" />
            <p>Upload A File</p>
            <input type="file" name="attachment" /> <br /><br />
            <input type="submit" />
        </form>
        <p>Future Travel Plans</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="form3">
            <p> Please choose your next countries to visit:</p>
            <p>1st: <select name="1st"> <?= create_option_list(@$_POST['1st'], $types) ?></select></p>
            <p>2nd: <select name="2nd"> <?= create_option_list(@$_POST['2nd'], $types) ?></select></p>
            <p>3rd: <select name="3rd"> <?= create_option_list(@$_POST['3rd'], $types) ?></select></p>
            <p><input type="submit" name="future" /></p>
        </form>
        <p>Personal details for travel</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="form4">
            <p>Please enter personal details:</p>
            Name: <input name="name" type="text" value="<?= @$_POST['name'] ?>" /><br />
            Phone: <input name="phone" type="text" value="<?= @$_POST['phone'] ?>" /><br />
            Email: <input name="email" type="text" value="<?= @$_POST['email'] ?>" /><br />
            Address: <input name="address" type="text" value="<?= @$_POST['address'] ?>" /><br />
            City: <input name="city" type="text" value="<?= @$_POST['city'] ?>" /><br />
            State: <input name="state" type="text" value="<?= @$_POST['state'] ?>" /><br />
            Country: <input name="country" type="text" value="<?= @$_POST['country'] ?>" /><br />
            <input type="submit" /><br />            
        </form>
    </body>
</html>