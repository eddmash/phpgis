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

class Field
{
    public $_ptr;
    private $featurePtr;

    /**
     * Field constructor.
     * @param $fieldPtr
     * @param $featurePtr
     * @throws GdalException
     */
    public function __construct($fieldPtr, $featurePtr)
    {
        if (!$fieldPtr):
            throw new GdalException('Cannot create OGR Field, invalid pointer given.');
        endif;

        $this->_ptr = $fieldPtr;
        $this->featurePtr = $featurePtr;
    }

    public static function getInstance($fieldPtr, $featurePtr)
    {
        return new static($fieldPtr, $featurePtr);
    }

    public function getType()
    {
        return OGR_Fld_GetType($this->_ptr);
    }

    /**
     * @return string
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getName()
    {
        return OGR_Fld_GetNameRef($this->_ptr);
    }

    public function __toString()
    {
        return $this->getName();
    }
}