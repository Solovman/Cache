<?php

declare(strict_types=1);

use Up\Providers\CategoryProvider;
use Up\Repository\MySQLCacheRepository;
use Up\Services\CacheService\CacheManager;
use Up\Services\CacheService\Database\MySQLCache;
use Up\Services\CacheService\File\FileCache;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../boot.php';

//Выбираем нужный тип кэширования (Файл/БД)
$fileCache = new FileCache();
// $mySqlCache = new MySQLCache(new MySQLCacheRepository());

$cacheManager = new CacheManager($fileCache);
$cacheKey = 'CategoryName';
$ttl = 10;

// Получаем данные из кэша
$categories = $cacheManager->remember($fileCache, $cacheKey, $ttl, function(){

	// Прямой запрос к провайдеру
	return (new CategoryProvider())->getCategories();
});

var_dump($categories);

// Удаление всего кэша
// $cacheManager->removeAllCache($fileCache);

// Удаление конкретного кэша
// $cacheManager->removeCacheByKey($fileCache, $cacheKey);