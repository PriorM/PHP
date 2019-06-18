<?php
    //Pagination
    $page = (isset($_GET['page']) && ($_GET['page'] > 0)) ? intval ($_GET['page']) : 1;
    $view = (isset($_GET['view']) && ($_GET['view'] > 0)) ? intval ($_GET['view']) : 10;

    $data = range('a', 'z');

    $pages = array_chunk($data, $view, true);

    echo "<p>The results are:</p><p>";
    foreach($pages[$page - 1] as $num => $datum)
    {
        echo $num + 1, ". {$datum}<br />";
    }
    echo "</p>";

    echo '<p>Switch to page: |';
    $get = $_GET;
    foreach(range(1, count($pages)) as $p)
    {
        if ($page == $p)
        {
            echo " {$p} |";
        }
        else
        {
            $get['page'] = $p;
            $query = http_build_query($get);
            echo " <a href=\"{$_SERVER['PHP_SELF']}?{$query}\">{$p}</a> |";
        }
    }

    echo "</p>";

    $options = array(3, 5, 10, 50);
    $get = $_GET;
    unset($get['page']);

    echo '<p>Results per page: |';
    foreach($options as $o)
    {
        if ($o == $view)
        {
            echo " {$o} |";
        }
        else
        {
            $get['view'] = $o;
            $query = http_build_query($get);
            echo " <a href=\"{$_SERVER['PHP_SELF']}?{$query}\">{$o}</a> |";
        }
    }

    echo "</p>";

    //Graphical Chart
    function create_chart($data, $height, $bars = 'red', $bg = 'white', $border = 'black', $grid = '#DDD')
    {
        static $idx = 0;
        $idx++;

        $height -= 2;

        $scale = $height / (max($data) * 1.05);

        $width = count($data);

        echo "
        <style>
        #chartout{$idx} {
            position: relative;
            height: ", $height + 2, "px;
            width: ", $width + 2, "px;
            background-color: {$border};
        }
        #chartin{$idx} {
            position: absolute;
            top: 1px;
            left: 1px;
            height: {$height}px;
            width: {$width}px;
            background-color: {$bg};
        }
        .bar{$idx} {
            position: aboslute;
            bottom: 0px;
            background-color: {$bars};
            width: 1px;
            overflow: hidden;
        }
        .grid{$idx} {
            position: absolute;
            left: 0px;
            height: 1px;
            widthL {$width}px;
            background-color: {$grid};
            overflow: hidden;
        }
        </style>";

        echo "
            <div id='chartout{$idx}'><div id='chartin{$idx}'>";

        foreach (range(1,3) as $line)
        {
            $lh = round($line * ($height / 5));
            echo "<div class='grid{$idx}' style='top: {$lh}px'></div>";
        }

        foreach ($data as $pos => $val)
        {
            $barheight = round($val * $scale);
            echo "<div class='bar{$idx}' style='left: {$pos}px; height: {$barheight}px'></div>";
        }

        echo "</div></div>";
    }

    $chartdata = array();
    $chartdata2 = array();
    for ($i = 0; $i < 200; $i++)
    {
        $chartdata[$i] = rand(1,1000);
        $chartdata2[$i] = rand(1,1000);
    }

    create_chart($chartdata, 100);
    create_chart($chartdata2, 50, '#0C0', 'black', 'black', '#666');


    //Progress Bar
    function create_progress() 
    {
        echo "
        <style>
        #text {
        position: absolute;
        top: 100px;
        left: 50%;
        margin: 0px 0px 0px -150px;
        font-size: 18px;
        text-align: center;
        width: 300px;
        }
        #barbox_a {
        position: absolute;
        top: 130px;
        left: 50%;
        margin: 0px 0px 0px -160px;
        width: 304px;
        height: 24px;
        background-color: black;
        }
        .per {
        position: absolute;
        top: 130px;
        font-size: 18px;
        left: 50%;
        margin: 1px 0px 0px 150px;
        background-color: #FFFFFF;
        }

        .bar {
        position: absolute;
        top: 132px;
        left: 50%;
        margin: 0px 0px 0px -158px;
        width: 0px;
        height: 20px;
        background-color: #0099FF;
        }

        .blank {
        background-color: white;
        width: 300px;
        }
        </style>
        ";

        echo "
        <div id='text'>Script Progress</div>
        <div id='barbox_a'></div>
        <div class='bar blank'></div>
        <div class='per'>0%</div>
        ";
        ob_flush();
        flush();
    }


    function update_progress($percent) {
        echo "<div class='per'>{$percent}
            %</div>";

        echo "<div class='bar' style='width: ",
            $percent * 3, "px'></div>";

        ob_flush();
        flush();
    }

    create_progress();
    $count = 0;
    while ($count <= 100)
    {
        usleep(100000);
        update_progress($count);
        $count++;
    }
?>