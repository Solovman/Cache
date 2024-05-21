<?php

declare(strict_types=1);

namespace Up\Cache\Traits;

use Closure;

trait Cacheable
{
	public function remember(string $key, int $ttl, Closure $fetcher)
	{
		$data = $this->get($key);

		if ($data === null)
		{
			// Удаляем элемент кэша в том случае, когда он устарел
			$this->removeByKey($key);

			var_dump(static::class .': Slow data');
			$value = $fetcher();

			// Кладем данные в файловый кэш
			$this->set($key, $value, $ttl);

			return $value;
		}

		var_dump(static::class . ': Fast data from cache');
		return $data;
	}
}