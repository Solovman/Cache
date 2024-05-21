<?php

declare(strict_types=1);

namespace Up\Cache\File;

use Closure;
use Up\Cache\CacheStrategy;
use Up\Cache\Traits\Cacheable;

class FileCache implements CacheStrategy
{
	use Cacheable;

	public function set(string $key, mixed $value, int $ttl): void
	{
		$hash = sha1($key);
		$path = ROOT . '/var/cache/' . $key . $hash . '.php';

		$data = [
			'data' => $value,
			'ttl' => time() + $ttl,
		];

		file_put_contents($path, serialize($data));

	}
	public function get(string $key): mixed
	{
		$hash = sha1($key);
		$path = ROOT . '/var/cache/' . $key . $hash . '.php';

		if (!file_exists($path))
		{
			return null;
		}

		$data = unserialize(file_get_contents($path), ['allowed_classes' => false]);
		$ttl = $data['ttl'];

		if (time() > $ttl)
		{
			return null;
		}

		return $data;
	}

	public function removeAll(): void
	{
		if (file_exists(ROOT . '/var/cache/'))
		{
			foreach (glob(ROOT . '/var/cache/*') as $file)
			{
				unlink($file);
			}
		}
	}

	public function removeByKey(string $key): void
	{
		if (file_exists(ROOT . '/var/cache/'))
		{
			foreach (glob(ROOT . "/var/cache/$key*") as $file)
			{
				unlink($file);
			}
		}
	}
}