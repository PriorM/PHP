<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    $files = array();

    $d = dir('.');

    while (false !== ($file = $d->read()))
    {
        if ( ($file{0} != '.') && ($file{0} != '~') && (substr($file, -3) != 'LCK') && ($file != basename($_SERVER['PHP_SELF'])))
        {
            $files[$file] = stat($file);
        }
    }

    $d->close();

    echo '<style>td { padding-right: 10px; }</style>';
    echo '<table><caption>The contents of this directory:</caption>';

    function compare_size($a, $b)
    {
        $a_size = filesize_format($a);
        $b_size = filesize_format($b);

        if ($a_size == $b_size)
        {
            return 0;
        }
        else
        {
            return ($a_size > $b_size) ? -1 : 1;
        }
    }

    function filesize_format($size, $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'))
    {
        if (size == 0)
        {
            return 0;
        }
        return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $sizes[i]);
    }

    uasort($files, 'compare_size');

    date_default_timezone_set('Australia/Sydney');

    foreach ($files as $name => $stats)
    {
        echo "<tr><td><a href=\"{$name}\">{$name}</a></td>\n";
        echo "<td align='right'>{$stats['size']}</td>\n";
        echo '<td>', date('m-d-Y h:ia', $stats['mtime']), "</td></tr>\n";
    }

    echo '</table>';
?>