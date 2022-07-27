<?php
session_start();
require 'connection.php';
require 'User.php';

$userObj = new \MyChatApp\User;



define('BASE_URL','http://localhost:8081/insa/');
