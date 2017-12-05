<?php

/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Gdal;


use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

class SpatialReference
{
    private $_ptr;

    /**
     * SpatialReference constructor.
     * @param void $getSrs
     */
    public function __construct($inputType)
    {
        $this->_ptr = $inputType;
    }

    public function getAuthorityCode($key)
    {
        return Gdal::getAuthorityCode($this->_ptr, $key);
    }

    public function getAuthorityName($key)
    {
        return Gdal::getAuthorityName($this->_ptr, $key);
    }

    public function getAttralue($attr, $child = 0)
    {
        return Gdal::getAttrValue($this->_ptr, $attr, $child);
    }

    public function isProjected()
    {
        return OSRIsProjected($this->_ptr);
    }

    public function isGeographic()
    {
        return OSRIsGeographic($this->_ptr);
    }

    public function isLocal()
    {
        return OSRIsLocal($this->_ptr);
    }

    public function isSame(SpatialReference $spatialReference)
    {
        return OSRIsSame($this->_ptr, $spatialReference->getPointer());
    }

    public function isGeocentric()
    {
        return OSRIsGeocentric($this->_ptr);
    }

    /**
     * @since 1.1.0
     * @return string
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function exportToWkt()
    {
        return Gdal::OSRExportToWkt($this->_ptr);
    }


    public function exportToPrettyWkt()
    {
        return Gdal::OSRExportToPrettyWkt($this->_ptr);
    }

    public function __toString()
    {
        return $this->exportToWkt();
    }



    protected function getPointer()
    {
        return $this->_ptr;
    }
}