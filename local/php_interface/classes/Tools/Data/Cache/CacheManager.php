<?php

namespace Asperansa\Tools\Data\Cache;

use CPHPCache;

/**
 * Менеджер кеша
 *
 * Class CacheManager
 *
 * @package Asperansa\Tools\Data\Cache
 */
class CacheManager
{
    /**
     * Корневая папка кеша
     */
    const STORE_DIR = 'asperansa';

    /**
     * Формирует путь сохранения кеша
     *
     * @param string $key
     *
     * @return string
     */
    protected function getCachePath($key)
    {
        return sprintf('/%s/%s', self::STORE_DIR, $key);
    }

    /**
     * Получает данные из кеша
     *
     * @param string $key
     * @param int $ttl
     *
     * @return mixed
     */
    public function get($key, $ttl = 86400)
    {
        $cache = new CPHPCache;

        if ($cache->InitCache($ttl, $key, $this->getCachePath($key))) {
            $data = $cache->GetVars();

            return isset($data[$key]) ? $data[$key] : null;
        }

        return null;
    }

    /**
     * Сохраняет данные в кеш
     *
     * @param string $key
     * @param mixed $value
     * @param array $tags
     * @param int $ttl
     */
    public function set($key, $value, array $tags = array(), $ttl = 86400)
    {
        $cache = new CPHPCache;

        $path = $this->getCachePath($key);

        $cache->StartDataCache($ttl, $key, $path);

        if (!empty($tags)) {
            global $CACHE_MANAGER;

            $CACHE_MANAGER->StartTagCache($path);

            foreach ($tags as $tag) {
                $CACHE_MANAGER->RegisterTag($tag);
            }

            $CACHE_MANAGER->EndTagCache();
        }

        $cache->EndDataCache(array($key => $value));
    }
}