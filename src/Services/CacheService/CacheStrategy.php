<?php

declare(strict_types=1);

namespace Up\Services\CacheService;

interface CacheStrategy
{
	public function get(string $key); // получение

	public function set(string $key, mixed $value, int $ttl); // запись

	public function removeAll(); // отчистка всего кэша

	public function removeByKey(string $key); // удаление по ключу элемента кэша
}