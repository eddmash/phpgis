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

class Field
{
    public $_ptr;
    private $featurePtr;

    /**
     * Field constructor.
     * @param $fieldDefnPtr
     * @param $featurePtr
     * @throws GdalException
     */
    public function __construct($fieldDefnPtr, $featurePtr)
    {
        if (!$fieldDefnPtr):
            throw new GdalException('Cannot create OGR Field, invalid pointer given.');
        endif;

        $this->_ptr = $fieldDefnPtr;
        $this->featurePtr = $featurePtr;
    }

    public static function getInstance($fieldDefnPtr, $featurePtr)
    {
        $type = Gdal::getFieldType($fieldDefnPtr);

        return self::getTypeFieldClass($type, $fieldDefnPtr, $featurePtr);
    }

    private static function getTypeFieldClass($type, $fieldDefnPtr, $featurePtr)
    {

        switch ($type) {
            case OFTInteger:
                $instance = new OFTInteger($fieldDefnPtr, $featurePtr);
                break;
            case OFTIntegerList:
                $instance = new OFTIntegerList($fieldDefnPtr, $featurePtr);
                break;
            case OFTReal:
                $instance = new OFTReal($fieldDefnPtr, $featurePtr);
                break;
            case OFTRealList:
                $instance = new OFTRealList($fieldDefnPtr, $featurePtr);
                break;
            case OFTString:
                $instance = new OFTString($fieldDefnPtr, $featurePtr);
                break;
            case OFTStringList:
                $instance = new OFTStringList($fieldDefnPtr, $featurePtr);
                break;
            case OFTWideString:
                $instance = new OFTWideString($fieldDefnPtr, $featurePtr);
                break;
            case OFTWideStringList:
                $instance = new OFTWideStringList($fieldDefnPtr, $featurePtr);
                break;
            case OFTBinary:
                $instance = new OFTBinary($fieldDefnPtr, $featurePtr);
                break;
            case OFTDate:
                $instance = new OFTDate($fieldDefnPtr, $featurePtr);
                break;
            case OFTTime:
                $instance = new OFTTime($fieldDefnPtr, $featurePtr);
                break;
            case OFTDateTime:
                $instance = new OFTDateTime($fieldDefnPtr, $featurePtr);
                break;
            case OFTInteger64:
                $instance = new OFTInteger64($fieldDefnPtr, $featurePtr);
                break;
            case OFTInteger64List:
                $instance = new OFTInteger64List($fieldDefnPtr, $featurePtr);
                break;
            default:
                $instance = new Field($fieldDefnPtr, $featurePtr);
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

    public function __toString()
    {
        return sprintf(
            "< %s(%s.%s) : %s>",
            get_class($this),
            $this->getWidth(),
            $this->getPrecision(),
            $this->getName()
        );
    }
}