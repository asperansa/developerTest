<?php

namespace Asperansa\Data\Bitrix;

use Asperansa\Data\Common\ObjectRepositoryInterface;

/**
 * Репозиторий, работающий с элементами инфоблоков
 *
 * Class IBlockElementRepository
 *
 * @package Asperansa\Data\Bitrix
 */
class IBlockElementRepository implements ObjectRepositoryInterface
{
	/**
	 * @var \CIBlockElement
	 */
	protected $iBEGateway;

	/**
	 * @var int
	 */
	protected $iBlockId;

	/**
	 * @param \CIBlockElement $iBEGateway
	 * @param int $iBlockId
	 */
	public function __construct(\CIBlockElement $iBEGateway, $iBlockId = null)
	{
		$this->iBEGateway = $iBEGateway;
		$this->iBlockId = $iBlockId;
	}

	/**
	 * Получает результат запроса для поиска списка элементов
	 *
	 * @param array $filter
	 * @param array $orderBy
	 * @param array $selectedFields
	 * @param mixed $navStartParams
	 *
	 * @return \CIBlockResult
	 */
	public function rawFindBy(
		array $filter = array(),
		array $orderBy = array('sort' => 'asc'),
		array $selectedFields = array('*', 'PROPERTY_*'),
		$navStartParams = null
	) {
		if (!isset($filter['IBLOCK_ID']) && $this->iBlockId) {
			$filter['IBLOCK_ID'] = $this->iBlockId;
		}

		return $this->iBEGateway->GetList(
			$orderBy,
			$filter,
			false,
			is_null($navStartParams) ? false : $navStartParams,
			$selectedFields
		);
	}

	/**
	 * Выбирает элементы по фильтру
	 *
	 * @param array $filter
	 * @param array $orderBy
	 * @param array $selectedFields Список выбираемых полей (в формате BX)
	 * @param bool $selectProperties Нужно ли выбирать свойства
	 * @param mixed $navStartParams Ограничения выборки
	 *
	 * @return array
	 */
	public function findBy(
		array $filter = array(),
		array $orderBy = array('sort' => 'asc'),
		array $selectedFields = array('*', 'PROPERTY_*'),
		$selectProperties = true,
		$navStartParams = null
	) {
		$items = array();

		$dbItems = $this->rawFindBy($filter, $orderBy, $selectedFields, $navStartParams);

		while ($item = $dbItems->GetNextElement()) {
			$arItem = $item->GetFields();

			if ($selectProperties) {
				$arItem['PROPERTIES'] = $item->GetProperties();
			}

			$items[] = $arItem;
		}

		return $items;
	}
}
