<?php

declare(strict_types=1);

namespace Up\Providers;

class CategoryProvider
{
	// Эмуляция получения данных из БД
	public function getCategories(): array
	{
		sleep(5);

		return [
			'Phones',
			'TV',
			'Consoles'
		];
	}
}