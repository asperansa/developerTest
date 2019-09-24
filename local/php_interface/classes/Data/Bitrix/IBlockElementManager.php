<?php

namespace Asperansa\Data\Bitrix;

use Asperansa\Data\Common\ObjectManagerInterface;

/**
 * Менеджер элементов инфоблоков
 *
 * Class IBlockElementManager
 *
 * @package Asperansa\Data\Bitrix
 */
final class IBlockElementManager implements ObjectManagerInterface
{
    /**
     * @var self
     */
    protected static $instance = null;

    /**
     * @var \CIBlockElement
     */
    protected $iBEGateway;

    /**
     * @var IBlockElementRepository
     */
    protected $repository;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $this->injectDependencies();

        $this->iBEGateway = new \CIBlockElement();
        $this->repository = new IBlockElementRepository($this->iBEGateway);
    }

    private function __clone()
    {}

    /**
     * Подключает необходимые зависимости
     */
    private function injectDependencies()
    {
        \Bitrix\Main\Loader::includeModule('iblock');
    }

    /**
     * Получает репозиторий менеджера
     *
     * @return IBlockElementRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Выбирает элементы по фильтру
     *
     * @param array $filter
     * @param array $orderBy
     * @param array $selectedFields Список выбираемых полей (в формате BX)
     * @param bool $selectProperties Нужно ли выбирать свойсвта
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

        return $this->repository->findBy(
            $filter,
            $orderBy,
            $selectedFields,
            $selectProperties,
            $navStartParams
        );
    }
}