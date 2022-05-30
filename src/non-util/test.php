<?php

include_once('Database.php');

$db = new Database();

$data = $db->verify_login('admin', 'admin@123');

#$data = $db->get_user_profile('admin');

var_dump($data);

$a = 1;
