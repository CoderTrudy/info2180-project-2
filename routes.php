<?php

$base_url = "http://localhost/info2180-project-2/";

$pages = array(
    "/" => "index.php",
    "home" => "index.php",
    'logout' => 'logout.php',
    'users' => 'users.php',
    'new-user' => 'new-user.php',
    'add-contact' => 'add-contact.php',
);



function base_url($path = "/")
{
    global $base_url;
    global $pages;

    if (isset($pages[$path])) {
        return $base_url . $pages[$path];
    }

    return $base_url;
}




