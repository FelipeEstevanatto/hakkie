<?php

require("connect.php");

$array = array(
    array('name' => 'felipe','email' => 'felipe@gmail.com','pass' => 'felipe'),
    array('name' => 'nicolim','email' => 'nicolim@gmail.com','pass' => 'nicolim'),
    array('name' => 'jorge','email' => 'jorge@gmail.com','pass' => 'jorge')
);

foreach ($array as $i) {
    $i['pass'] = password_hash($i['pass'],PASSWORD_BCRYPT);

    $query = "INSERT INTO users VALUES(DEFAULT, '$i[name]' , '$i[email]' , '$i[pass]' , DEFAULT, 
    DEFAULT, NULL, NULL, DEFAULT, DEFAULT, DEFAULT, DEFAULT)";

    $conn -> query($query);
}
