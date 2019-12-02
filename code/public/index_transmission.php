<?php

use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;

require_once __DIR__ . '/../vendor/autoload.php';

$file = '/scrap/torrent/film/10028.torrent';

$transmissionClient = new TransmissionClient(
    '192.168.1.134',
    '9091',
    'ismael',
    'm27trhhzIMC'
);

$added = $transmissionClient->add($file);

print_r($added);