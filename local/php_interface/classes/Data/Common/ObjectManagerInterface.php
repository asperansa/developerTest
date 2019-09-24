<?php

namespace Asperansa\Data\Common;

/**
 * Интерфейс менеджера объектов хранилища
 *
 * Interface ObjectManagerInterface
 *
 * @package Asperansa\Data\Common
 */
interface ObjectManagerInterface
{
    /**
     * Выбирает элементы по фильтру
     *
     * @param array $filter
     * @param array $orderBy
     *
     * @return array
     */
    public function findBy(array $filter = array(), array $orderBy = array());
}