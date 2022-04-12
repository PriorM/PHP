<?php
    //change doggo.jpg for image wanted distorted
    $gfx = imagecreatefromjpeg("doggo.jpg");

    $width = imagesx($gfx);
    $height = imagesy($gfx);

    $color = imagecolorallocate($gfx, 41, 23, 98);
    imageellipse($gfx, 500, 250, 150, 105, $color);
    imagecopy($gfx, $gfx, 500, 300, 100, 170, 150, 105);
    $color = imagecolorallocate($gfx, 0, 255, 128);
    imagerectangle($gfx, 250, 500, 750, 1000, $color);
    $color = imagecolorallocate($gfx, 69, 69, 69);
    imageline($gfx, 750, 100, 250, 600, $color);

    header('Content-type: image/png');
    imagepng($gfx);
?>