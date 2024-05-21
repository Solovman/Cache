<?php

declare(strict_types=1);

namespace Up\Cache\Database;

use Core\Database\MySQLConnection;
use Exception;
use mysqli;
use Up\Cache\Traits\Cacheable;

class MySQLCache extends DatabaseCache
{
	use Cacheable;

	private mysqli $connection;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->connection = MySQLConnection::get();
		if ($this->connection->connect_error)
		{
			die("Connection error: " . $this->connection->connect_error);
		}

	}

	public function set(string $key, mixed $value, int $ttl): void
	{
		$ttl = (time() + $ttl);
		$stmt = $this->connection->prepare("REPLACE INTO up_cache (cache_key, cache_value, ttl) VALUES (?, ?, ?)");
		$serialize = serialize($value);
		$stmt->bind_param("ssi", $key, $serialize, $ttl);
		$stmt->execute();
		$stmt->close();
	}

	public function get(string $key): mixed
	{
		$stmt = $this->connection->prepare("SELECT cache_value, ttl FROM up_cache WHERE cache_key = ?");
		$stmt->bind_param("s", $key);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$stmt->close();

		if ($row && time() <= (int) $row['ttl'])
		{
			return unserialize($row['cache_value'], ['allowed_classes' => false]);
		}

		// Если время жизни кэша истекло или данных кэша нет, возвращаем null
		return null;
	}

	public function removeAll(): void
	{
		$this->connection->query("TRUNCATE TABLE up_cache");
	}

	public function removeByKey(string $key): void
	{
		$stmt = $this->connection->prepare("DELETE FROM up_cache WHERE cache_key = ?");
		$stmt->bind_param("s", $key);
		$stmt->execute();
		$stmt->close();
	}
}