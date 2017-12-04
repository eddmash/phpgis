<?php

/**
 * This file is part of the pgdal package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Gdal;


use Eddmash\PhpGis\Gdal\Exceptions\GdalException;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

class Layer implements \Iterator
{
    private $_currFeature = 0;

    private $canRandomAccess;
    private $_ptr;
    private $datasourcePtr;

    /**
     * @internal
     * @param $layerPtr
     * @param $datasourcePtr
     * @return static
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public static function getInstance($layerPtr, $datasourcePtr)
    {
        return new static($layerPtr, $datasourcePtr);
    }

    /**
     * Layer constructor.
     * @param $layerPtr
     * @param $datasourcePtr
     * @throws GdalException
     */
    protected function __construct($layerPtr, $datasourcePtr)
    {
        if (!$layerPtr):
            throw new GdalException("Cannot create layer, invalid pointer provided");
        endif;
        $this->_ptr = $layerPtr;
        $this->datasourcePtr = $datasourcePtr;
        $this->canRandomAccess = $this->testCapability(Gdal::OLCRandomRead);
    }

    public function getFeatureCount()
    {
        return Gdal::getLayerFeatureCount($this->_ptr);
    }

    /**
     * @param $fid
     * @return Feature|static
     * @throws GdalException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getFeatureById($fid)
    {
        return $this->makeFeature($fid);
    }

    public function __toString()
    {
        return Gdal::getLayerName($this->_ptr);
    }

    public function testCapability($capability)
    {
        return Gdal::layerTestCapability($this->_ptr, $capability);
    }


    /**
     * @param $index
     * @return Feature|static
     * @throws GdalException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function makeFeature($index)
    {
        if ($this->canRandomAccess):
            return Feature::getInstance(Gdal::getLayerFeature($this->_ptr, $index), $this->_ptr);
        else:
            foreach ($this as $feature) :
                if ($feature->getFeatureID() == $index):
                    return $feature;
                endif;
            endforeach;
        endif;
        throw new GdalException(sprintf("Invalid feature id %s ", $index));
    }


    // ======================= ITERATE ================

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Feature.
     * @since 5.0.0
     */
    public function current()
    {
        return Feature::getInstance(Gdal::getLayerNextFeature($this->_ptr), $this->_ptr);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->_currFeature++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return true;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->_currFeature < $this->getFeatureCount();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->_currFeature = 0;
        Gdal::layerResetReading($this->_ptr);
    }



}