<?php

declare(strict_types=1);

namespace Up\Repository;

interface CacheRepository
{
	public function replaceIntoCache(string $key, mixed $value, int $ttl): void;

	public function selectCacheByKey(string $key): ?array;

	public function removeCacheByKey(string $key): void;

	public function removeAllCache(): void;
}