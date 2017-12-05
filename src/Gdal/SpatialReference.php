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

    public function getAuthorityName($key=null)
    {
        return Gdal::getAuthorityName($this->_ptr, $key);
    }

    public function getAttralue($attr, $child = 0)
    {
        return Gdal::getAttrValue($this->_ptr, $attr, $child);
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
}