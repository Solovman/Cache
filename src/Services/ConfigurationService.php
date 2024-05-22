<?php

declare(strict_types=1);

namespace Up\Services;

use RuntimeException;

class ConfigurationService
{
	private const MASTER_CONFIG_PATH = ROOT . '/config/config.php';
	private const LOCAL_CONFIG_PATH = ROOT . '/config/local-config.php';

	private static ?array $config = null;

	public static function option(string $name, mixed $defaultValue = null): mixed
	{
		if (self::$config === null)
		{
			self::$config = self::loadConfig();
		}

		return self::getConfigOption($name, $defaultValue);
	}

	private static function loadConfig(): array
	{
		$masterConfig = require_once self::MASTER_CONFIG_PATH;
		$localConfig = file_exists(self::LOCAL_CONFIG_PATH) ? require_once self::LOCAL_CONFIG_PATH : [];

		return array_merge($masterConfig, $localConfig);
	}

	private static function getConfigOption(string $name, mixed $defaultValue): mixed
	{
		if (array_key_exists($name, self::$config))
		{
			return self::$config[$name];
		}

		if ($defaultValue !== null)
		{
			return $defaultValue;
		}

		throw new RuntimeException("Configuration option $name not found");
	}
}