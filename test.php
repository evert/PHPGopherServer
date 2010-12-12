#!/usr/bin/php
<?php

    require_once 'Sabre/Gopher/Server.php';

    $server = new Sabre_Gopher_Server();

    $server->setHostname('gopher.rooftopsolutions.nl');

    $server->exec();

?>
