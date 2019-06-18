<?php
    function find($regex, $dir)
    {
        $matches = array();
        $d = dir($dir);

        while (false !== ($file = $d->read()))
        {
            if (($file == '.') || ($file == '..'))
            {
                continue;
            }
            if (is_dir("{$dir}/{$file}"))
            {
                $submatches = find($regex, "{$dir}/{$file}");
                $matches = array_merge($matches, $submatches);
            }
            else
            {
                if (preg_match($regex, $file))
                {
                    $matches[] = "{$dir}/{$file}";
                }
            }
        }

        return $matches;
    }

    $found = find('/\.php$/',"{$_SERVER['DOCUMENT_ROOT']}/assessments");

    sort($found);
    echo "<pre>", print_r($found, true), "</pre>";
?>