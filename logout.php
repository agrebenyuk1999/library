<?php
require 'Session.php';
$session = new Session;
$session->destroy();
header('Location: /');
