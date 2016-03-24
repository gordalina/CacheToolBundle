<?php

/**
 * Created by PhpStorm.
 * User: Yuriy Maksimenko <yuriy.maksimenko@tonicforhealth.com>
 * Date: 3/21/16
 * Time: 2:17 PM
 */
namespace CacheTool\Bundle\CacheClearer\Clearer;

use CacheTool\CacheTool;

/**
 * Class Opcache
 */
class Opcache implements ClearerInterface
{
    /**
     * @var CacheTool
     */
    protected $cacheTool;

    /**
     * Opcache constructor.
     *
     * @param CacheTool $cacheTool
     * @param bool      $opcacheEnabled
     */
    public function __construct(CacheTool $cacheTool, $opcacheEnabled)
    {
        $this->cacheTool = $cacheTool;
        $this->opcacheEnabled = $opcacheEnabled;
    }

    /**
     * Check if cache enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return ($this->opcacheEnabled && extension_loaded('Zend OPcache') && ini_get('opcache.enable') === '1') ? true : false;
    }

    /**
     * Clears the cache
     *
     * @return bool or \RuntimeException
     */
    public function clear()
    {
        $status = $this->cacheTool->opcache_reset();

        if (!$status) {
            throw new \RuntimeException('opcache_reset(): No Opcache status info available.');
        }

        return $status;
    }

    /**
     * Get name of the cache
     * @return string
     */
    public function getName()
    {
        return 'Opcache';
    }
}
