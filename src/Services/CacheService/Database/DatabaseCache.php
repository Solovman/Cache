<?php

declare(strict_types=1);

namespace Up\Services\CacheService\Database;

use Up\Repository\CacheRepository;
use Up\Services\CacheService\CacheStrategy;

abstract class DatabaseCache implements CacheStrategy
{
	public CacheRepository $cacheRepository;

	public function __construct(CacheRepository $cacheRepository)
	{
		$this->cacheRepository = $cacheRepository;
	}
}