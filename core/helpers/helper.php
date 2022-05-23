<?php

function dd($data)
{
    echo '<pre style="background-color: black; color: lightgreen">';
    var_dump($data);
    echo "</pre>";
    exit;
}

function vd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
