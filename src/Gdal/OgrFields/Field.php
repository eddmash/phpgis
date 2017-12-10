<?php

/**
 * This file is part of the pgdal package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Gdal\OgrFields;


use Eddmash\PhpGis\Gdal\Exceptions\GdalException;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

/**
 * Class Field
 *
 * The attributes provide additional meta-information about the feature.
 *
 * For example, an attribute might provide the name for a city's feature, its population, or the feature's unique ID
 * used to retrieve additional information about the feature from an external database
 *
 * @package Eddmash\PhpGis\Gdal\OgrFields
 * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 */
class Field
{
    public $_ptr;
    private $index;
    private $featurePtr;

    /**
     * Field constructor.
     * @param $fieldDefnPtr
     * @param $featurePtr
     * @throws GdalException
     */
    public function __construct($index, $fieldDefnPtr, $featurePtr)
    {
        if (!$fieldDefnPtr):
            throw new GdalException('Cannot create OGR Field, invalid pointer given.');
        endif;

        $this->index = $index;
        $this->_ptr = $fieldDefnPtr;
        $this->featurePtr = $featurePtr;
    }

    public static function getInstance($index, $fieldDefnPtr, $featurePtr)
    {
        $type = Gdal::getFieldType($fieldDefnPtr);

        return self::getTypeFieldClass($index, $type, $fieldDefnPtr, $featurePtr);
    }

    private static function getTypeFieldClass($index, $type, $fieldDefnPtr, $featurePtr)
    {

        switch ($type) {
            case OFTInteger:
                $instance = new OFTInteger($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTIntegerList:
                $instance = new OFTIntegerList($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTReal:
                $instance = new OFTReal($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTRealList:
                $instance = new OFTRealList($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTString:
                $instance = new OFTString($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTStringList:
                $instance = new OFTStringList($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTWideString:
                $instance = new OFTWideString($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTWideStringList:
                $instance = new OFTWideStringList($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTBinary:
                $instance = new OFTBinary($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTDate:
                $instance = new OFTDate($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTTime:
                $instance = new OFTTime($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTDateTime:
                $instance = new OFTDateTime($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTInteger64:
                $instance = new OFTInteger64($index, $fieldDefnPtr, $featurePtr);
                break;
            case OFTInteger64List:
                $instance = new OFTInteger64List($index, $fieldDefnPtr, $featurePtr);
                break;
            default:
                $instance = new Field($index, $fieldDefnPtr, $featurePtr);
        }

        return $instance;
    }

    public function getType()
    {
        return Gdal::getFieldType($this->_ptr);
    }

    /**
     * @return string
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getName()
    {
        return Gdal::getFieldName($this->_ptr);
    }

    public function getWidth()
    {
        return Gdal::getFieldWidth($this->_ptr);
    }

    public function getPrecision()
    {
        return Gdal::getFieldPrecision($this->_ptr);
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    public function asString()
    {
        return Gdal::getFieldAsString($this->featurePtr, $this->index);
    }

    public function asInt()
    {
        return Gdal::getFieldAsInteger($this->featurePtr, $this->index);
    }

    public function asDouble()
    {
        return Gdal::getFieldAsDouble($this->featurePtr, $this->index);
    }

    /**
     * @return array
     * @throws GdalException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function asDatetime()
    {
        $status = Gdal::getFieldAsDateTime(
            $this->featurePtr,
            $this->index,
            $year,
            $month,
            $day,
            $hour,
            $minute,
            $second,
            $timezone
        );

        if ($status):
            return [$year, $month, $day, $hour, $minute, $second, $timezone];
        endif;

        throw new GDALException('Unable to retrieve date & time information from the field.');
    }

    public function getValue()
    {
        return $this->asString();
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }
}