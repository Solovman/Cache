<?php

declare(strict_types=1);

namespace Up\Cache;

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

	public function getCacheStrategy(): CacheStrategy
	{
		return $this->cacheStrategy;
	}

	public function removeAllCache(CacheStrategy $cacheStrategy): void
	{
		$cacheStrategy->removeAll();
	}
	public function removeCacheByKey(CacheStrategy $cacheStrategy, string $key): void
	{
		$cacheStrategy->removeByKey($key);
	}

}