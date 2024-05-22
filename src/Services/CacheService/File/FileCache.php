<?php

declare(strict_types=1);

namespace Up\Services\CacheService\File;

use Up\Services\CacheService\CacheStrategy;

class FileCache implements CacheStrategy
{
	private const CACHE_PATH = ROOT . '/var/cache/';

	public function set(string $key, mixed $value, int $ttl): void
	{
		$path = $this->getFilePath($key);

		$data = [
			'data' => $value,
			'ttl' => time() + $ttl,
		];

		file_put_contents($path, serialize($data));

	}
	public function get(string $key): mixed
	{
		$path = $this->getFilePath($key);

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
		if (file_exists(self::CACHE_PATH))
		{
			foreach (glob(self::CACHE_PATH . '*') as $file)
			{
				unlink($file);
			}
		}
	}

	public function removeByKey(string $key): void
	{
		if (file_exists(self::CACHE_PATH))
		{
			foreach (glob(self::CACHE_PATH . "$key*") as $file)
			{
				unlink($file);
			}
		}
	}

	private function getFilePath(string $key): string
	{
		$hash = sha1($key);
		return self::CACHE_PATH . $key . $hash . '.php';
	}
}