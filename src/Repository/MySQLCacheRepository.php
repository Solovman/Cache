<?php

declare(strict_types=1);

namespace Up\Repository;

use mysqli;
use Exception;
use Core\Database\MySQLConnection;

class MySQLCacheRepository implements CacheRepository
{
	private mysqli $connection;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->connection = MySQLConnection::get();

	}

	public function replaceIntoCache(string $key, mixed $value, int $ttl): void
	{
		$ttl = (time() + $ttl);
		$stmt = $this->connection->prepare("REPLACE INTO up_cache (cache_key, cache_value, ttl) VALUES (?, ?, ?)");
		$serialize = serialize($value);
		$stmt->bind_param("ssi", $key, $serialize, $ttl);
		$stmt->execute();
		$stmt->close();
	}

	public function selectCacheByKey(string $key): ?array
	{
		$stmt = $this->connection->prepare("SELECT cache_value, ttl FROM up_cache WHERE cache_key = ?");
		$stmt->bind_param("s", $key);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$stmt->close();

		return $row;
	}

	public function removeAllCache(): void
	{
		$this->connection->query("TRUNCATE TABLE up_cache");
	}

	public function removeCacheByKey(string $key): void
	{
		$stmt = $this->connection->prepare("DELETE FROM up_cache WHERE cache_key = ?");
		$stmt->bind_param("s", $key);
		$stmt->execute();
		$stmt->close();
	}
}