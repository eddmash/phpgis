<?php
/**
 * This file is part of the ziamis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Gdal;


use Eddmash\PhpGis\Gdal\Exceptions\GdalException;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

class OgrGeometry
{
    public $featurePtr;
    protected $_ptr;
    
    public function __construct($geometryPtr, $featurePtr)
    {
        if (!$geometryPtr):
            throw new GdalException("Cannot create layer, invalid pointer provided");
        endif;
        $this->_ptr = $geometryPtr;
        $this->featurePtr = $featurePtr;
    }

    /**
     * @return string
     * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
     */
    public function getName()
    {
        return Gdal::getGeometryName($this->_ptr);
    }

    public function getDimension()
    {
        return Gdal::getGeometryDimension($this->_ptr);
    }

    public function exportToWkt()
    {
        return Gdal::exportToWkt($this->_ptr);
    }

    public function getSrs()
    {
        return Gdal::getSrs($this->_ptr);
    }

    public function __toString()
    {
        return $this->getName();
    }
}