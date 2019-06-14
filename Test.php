<?php
include_once("PhpEvents.php");

$events = PhpEvents::getInstance();
$events->register("evento_de_prueba", ["id" => "999"], "Evento disparado al probar");


print "hola mundo<br/>";


$events->listen("evento_de_prueba", function($args) {
    print "Listen 1<br/>";
    print_r($args);
});

$events->listen("evento_de_prueba", function($args) {
    print "Listen 2<br/>";
    print_r($args);
    return false;
});

$events->listen("evento_de_prueba", function($args) {
    print "Listen 3<br/>";
    print_r($args);
});

print "Hola mundo 2<br/>";

$eventsExec = $events->do_event("evento_de_prueba");

print_r("<pre>");
var_dump($eventsExec);
print_r("</pre>");