<?php

/**
 * Получает последние 5 новостей из RSS Lenta.ru
 *
 * Запуск скрипта: php C:\OSP\OSPanel\domains\developerTest\cron\rss\getLastNews.php
 */

ignore_user_abort(true);
set_time_limit(0);

while (ob_get_level()) {
    ob_end_flush();
}

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

$url = 'https://lenta.ru/rss';
$rss = simplexml_load_file($url);
$newsCount = 0;
foreach ($rss->channel->item as $items) {
    $newsCount++;
    echo sprintf('Название: %s' . PHP_EOL, $items->title);
    echo sprintf('Ссылка на новость: %s' . PHP_EOL, $items->link);
    echo sprintf('Анонс: %s' . PHP_EOL, $items->description);
    if ($newsCount > 4) {
        break;
    }
}