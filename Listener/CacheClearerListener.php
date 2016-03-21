<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Maksimenko <yuriy.maksimenko@tonicforhealth.com>
 * Date: 3/21/16
 * Time: 9:35 AM
 */
namespace CacheTool\Bundle\Listener;

use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;
use CacheTool\Bundle\CacheClearer\Collection as CacheClearerCollection;

class CacheClearerListener implements CacheClearerInterface
{
    /**
     * @var CacheTool
     */
    protected $cacheClearerCollection;

    /**
     * CacheClearerListener constructor.
     *
     * @param CacheClearerCollection $cacheClearerCollection
     */
    public function __construct(CacheClearerCollection $cacheClearerCollection)
    {
        $this->cacheClearerCollection = $cacheClearerCollection;
    }

    /**
     * Clear activated byte code caches
     *
     * @param string $cacheDir
     */
    public function clear($cacheDir)
    {
        foreach ($this->cacheClearerCollection->toArray() as $clearer) {
            if ($clearer->isEnabled()) {
                echo " \n" . "Clearing " . $clearer->getName();
                $clearer->clear();
            }
        }
    }
}
