<?php

declare(strict_types=1);

use Up\Cache\CacheManager;
use Up\Cache\File\FileCache;
use Up\Cache\Database\MySQLCache;
use Up\Catalog\CategoryProvider;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../boot.php';

//Выбираем нужный тип кэширования (Файл/БД)
// $fileCache = new FileCache();
$mySqlCache = new MySQLCache();

$cacheManager = new CacheManager($mySqlCache);
$cacheKey = 'CategoryName';
$ttl = 10;

// Получаем данные из кэша
$categories = $cacheManager->getCacheStrategy()->remember($cacheKey, $ttl, function(){

	// Прямой запрос к провайдеру
	return (new CategoryProvider())->getCategories();
});

var_dump($categories);

// Удаление всего кэша
// $cacheManager->removeAllCache($mySqlCache);

// Удаление конкретного кэша
// $cacheManager->removeCacheByKey($mySqlCache, $cacheKey);