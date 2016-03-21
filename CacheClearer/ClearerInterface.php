<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Maksimenko <yuriy.maksimenko@tonicforhealth.com>
 * Date: 3/21/16
 * Time: 2:38 PM
 */
namespace CacheTool\Bundle\CacheClearer;

/**
 * Interface ClearerInterface
 */
interface ClearerInterface
{
    /**
     * Check if cache enabled
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Clears the cache
     */
    public function clear();
}
