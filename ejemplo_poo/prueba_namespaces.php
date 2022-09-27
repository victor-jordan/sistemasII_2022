<?php
require 'espacios_nombres_html.php';
require 'espacios_nombres_mueble.php';

$htmltable = new Htmltable\Table();
$furnituretable = new Furniture\Table();

$htmltable->title = "Prueba";
$htmltable->numRows = 8;

$furnituretable->color = "Marron";
$furnituretable->material = "Hierro";

$htmltable->construirTabla();
$furnituretable->datosMesa();
?>