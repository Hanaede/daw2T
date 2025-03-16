<?php
require "../vendor/autoload.php";
use  App\Controllers\AnimalesController;
require_once "../boostrap.php";


$q = isset($_GET['q']) ? $_GET['q'] : '';

$animales = new AnimalesController();
$animales->getAnimalesAction($q, '../public/list_view.php');