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
use Eddmash\PhpGis\Gdal\OgrFields\Field;
use Eddmash\PhpGis\Gdal\OgrGeometry\OgrGeometry;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

/**
 * Class Feature
 *
 * A feature corresponds to some significant element within the layer.
 *
 * For example, a feature might represent a state, a city, a road, an island,
 * and so on. Each feature has a list of attributes(Eddmash\PhpGis\Gdal\OgrFields\Fields) and a
 * geometry(Eddmash\PhpGis\Gdal\OgrGeometry).
 *
 * @package Eddmash\PhpGis\Gdal
 * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 */
class Feature implements \Iterator
{
    public $_dfnPtr;
    private $iteratorPos =0;
    private $_ptr;
    private $layerPtr;

    /**
     * Feature constructor.
     * @param $featurePtr
     * @param $layerPtr
     * @throws GdalException
     */
    public function __construct($featurePtr, $layerPtr)
    {
        if (!$featurePtr):
            throw new GdalException('Cannot create OGR Feature, invalid pointer given.');
        endif;
        $this->_ptr = $featurePtr;
        $this->_dfnPtr = Gdal::getFeatureDefn($this->_ptr);
        $this->layerPtr = $layerPtr;
    }

    public static function getInstance($fidPtr, $layerPtr)
    {
        return new static($fidPtr, $layerPtr);
    }

    public function getFieldCount()
    {
        return Gdal::getFeatureFieldCount($this->_ptr);
    }

    public function getFeatureID()
    {
        return Gdal::getFeatureID($this->_ptr);
    }

    public function getFieldNames()
    {
        $fieldCount = $this->getFieldCount();
        $fields = [];
        for ($fli = 0; $fli < $fieldCount; $fli++) {
            $fields[] = Gdal::getFieldName(Gdal::getFeatureFieldDefn($this->_ptr, $fli));
        }
        return implode(", ", $fields);
    }

    public function getGeomType()
    {
        return new OgrGeometryType(Gdal::getGeomTypeFromFeatureDefn($this->_dfnPtr));
    }

    public function getGeometry()
    {
        return OgrGeometry::getInstance(Gdal::getFeatureGeometry($this->_ptr), $this->_ptr);
    }

    /**
     * @param $fieldId
     * @return Field
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getField($fieldId)
    {
        return Field::getInstance(Gdal::getFeatureFieldDefn($this->_ptr, $fieldId), $this->_ptr);
    }

    // ======================= ITERATE ================

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Field.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->getField($this->iteratorPos);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->iteratorPos++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->iteratorPos;
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
        return $this->iteratorPos < $this->getFieldCount();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->iteratorPos = 0;
    }
}