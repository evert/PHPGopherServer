#!/usr/bin/php
<?php

    require_once 'Gopher/Server.php';

    $server = new Gopher_Server();

    $server->setHostname('gopher.rooftopsolutions.nl');

    $server->exec();

?>
