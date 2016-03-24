<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Maksimenko <yuriy.maksimenko@tonicforhealth.com>
 * Date: 3/21/16
 * Time: 2:31 PM
 */
namespace CacheTool\Bundle\CacheClearer;

class CacheClearer
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    private $elements = array();

    /**
     * Initializes a new ArrayCollection.
     */
    public function __construct()
    {
        foreach (func_get_args() as $clearer) {
            if (!($clearer instanceof ClearerInterface)) {
                throw new \InvalidArgumentException('Clearer class must implement ClearerInterface');
            }

            $this->elements[] = $clearer;
        }
    }

    /**
     * Clears all enabled caches
     */
    public function clear(){
        foreach ($this->elements as $clearer) {
            if ($clearer->isEnabled()) {
                $clearer->clear();
            }
        }
    }
}
