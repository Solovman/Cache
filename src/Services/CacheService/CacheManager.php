<?php

declare(strict_types=1);

namespace Up\Services\CacheService;

use Closure;

class CacheManager
{
	public CacheStrategy $cacheStrategy;

	/**
	 * @param CacheStrategy $cacheStrategy
	 */
	public function __construct(CacheStrategy $cacheStrategy)
	{
		$this->cacheStrategy = $cacheStrategy;
	}

	public function removeAllCache(CacheStrategy $cacheStrategy): void
	{
		$cacheStrategy->removeAll();
	}

	public function removeCacheByKey(CacheStrategy $cacheStrategy, string $key): void
	{
		$cacheStrategy->removeByKey($key);
	}

	public function remember(CacheStrategy $cacheStrategy, string $key, int $ttl, Closure $fetcher)
	{
		$data = $cacheStrategy->get($key);

		if ($data === null)
		{
			// Удаляем элемент кэша в том случае, когда он устарел
			$this->removeCacheByKey($cacheStrategy, $key);

			var_dump(static::class . ': Slow data');
			$value = $fetcher();

			// Кладем данные в файловый кэш
			$cacheStrategy->set($key, $value, $ttl);

			return $value;
		}

		var_dump(static::class . ': Fast data from cache');

		return $data;
	}

}