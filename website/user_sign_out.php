<?php

session_start();

require_once(__DIR__ . '/back/functions.php');

session_unset();
session_destroy();

redirectToUrl('/');
