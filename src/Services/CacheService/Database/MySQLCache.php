<?php

declare(strict_types=1);

namespace Up\Services\CacheService\Database;

use Up\Repository\CacheRepository;

class MySQLCache extends DatabaseCache
{
	private CacheRepository $cacheRepository;

	public function __construct(CacheRepository $cacheRepository)
	{
		$this->cacheRepository = $cacheRepository;
	}

	public function set(string $key, mixed $value, int $ttl): void
	{
		$this->cacheRepository->replaceIntoCache($key, $value, $ttl);
	}

	public function get(string $key): mixed
	{
		$row = $this->cacheRepository->selectCacheByKey($key);

		if ($row && time() <= (int)$row['ttl'])
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