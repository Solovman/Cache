<?php

declare(strict_types=1);

namespace Up\Services\CacheService\Database;

class MySQLCache extends DatabaseCache
{
	public function set(string $key, mixed $value, int $ttl): void
	{
		$this->cacheRepository->replaceIntoCache($key, $value, $ttl);
	}

	public function get(string $key): mixed
	{
		$row = $this->cacheRepository->selectCacheByKey($key);

		$cacheIsValid = $row && time() <= (int)$row['ttl'];

		if ($cacheIsValid)
		{
			return unserialize($row['cache_value'], ['allowed_classes' => false]);
		}

		// Если время жизни кэша истекло или данных кэша нет, возвращаем null
		return null;
	}

	public function removeAll(): void
	{
		$this->cacheRepository->removeAllCache();
	}

	public function removeByKey(string $key): void
	{
		$this->cacheRepository->removeCacheByKey($key);
	}
}