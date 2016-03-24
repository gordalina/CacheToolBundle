<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Maksimenko <yuriy.maksimenko@tonicforhealth.com>
 * Date: 3/21/16
 * Time: 9:35 AM
 */
namespace CacheTool\Bundle\Listener;

use Symfony\Component\HttpKernel\CacheClearer\Clearer\CacheClearerInterface;
use CacheTool\Bundle\CacheClearer\CacheClearer;

class CacheClearerListener implements CacheClearerInterface
{
    /**
     * @var CacheTool
     */
    protected $cacheClearer;

    /**
     * CacheClearerListener constructor.
     *
     * @param CacheClearer $cacheClearer
     */
    public function __construct(CacheClearer $cacheClearer)
    {
        $this->cacheClearer = $cacheClearer;
    }

    /**
     * Clear activated byte code caches
     *
     * @param string $cacheDir
     */
    public function clear($cacheDir)
    {
        $this->cacheClearer->clear();
    }
}
