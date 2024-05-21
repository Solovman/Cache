<?php

declare(strict_types=1);

namespace Up\Cache\Database;

use Up\Cache\CacheStrategy;

abstract class DatabaseCache implements CacheStrategy
{
	abstract public function get(string $key);

	abstract public function set(string $key, mixed $value, int $ttl);

	abstract public function removeAll();

	abstract public function removeByKey(string $key);
}