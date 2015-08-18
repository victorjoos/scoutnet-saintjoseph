<?php
include 'Parsedown.php';
/*
 * Exists : this function 
 */
function exists($file)
{
    $dir = 'news';
    $files = scandir($dir);
    return in_array($file, $files);
}

function transform($text)
{
    $Parsedown = new Parsedown();
    return $Parsedown->text($text);
}

?>