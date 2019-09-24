<?php

namespace Asperansa\Data\Common;

/**
 * Интерфейс репозитория объектов
 *
 * Interface ObjectRepositoryInterface
 *
 * @package Asperansa\Data\Common
 */
interface ObjectRepositoryInterface
{
	/**
	 * Ищет элементы, удовлетворяющие фильтру поиска
	 *
	 * @param array $filter
	 * @param array $orderBy
	 *
	 * @return mixed
	 */
	public function findBy(array $filter, array $orderBy = array());
}
