<?php

declare(strict_types=1);

namespace Up\Catalog;

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