<?php

$container->setParameter(
    'downloadElementTorrentUrl',
    '/uploads/torrents/peliculas/'
);

$container->setParameter(
    'homeUrl',
    'http://www.mejortorrentt.org'
);

$container->setParameter(
    'filmUrl',
    '/secciones.php?sec=descargas&ap=peliculas&p=%s'
);

$container->setParameter(
    'seriesUrl',
    '/secciones.php?sec=descargas&ap=series&p=%s'
);

$container->setParameter(
    'seriesDownloadUrl',
    '/secciones.php?sec=descargas&ap=contar&tabla=series&id=%s'
);

$container->setParameter(
    'seriesDownloadTorrentUrl',
    '/uploads/torrents/series/'
);

$container->setParameter(
    'downloadElementUrl',
    '/secciones.php?sec=descargas&ap=contar&tabla=peliculas&id=%s&link_bajar=1'
);

$container->setParameter(
    'TemplateDir',
    __DIR__ . '/../../views'
);

$container->setParameter(
    'TemplateOptions',
    [
        'cache' => false
    ]
);
