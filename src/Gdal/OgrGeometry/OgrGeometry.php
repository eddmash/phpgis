<?php
/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Gdal\OgrGeometry;


use Eddmash\PhpGis\Gdal\Exceptions\GdalException;
use Eddmash\PhpGis\Gdal\OgrGeometryType;
use Eddmash\PhpGis\Gdal\SpatialReference;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

/**
 * Class OgrGeometry
 *
 * The geometry describes the physical shape or location of the feature.
 *
 * Geometries are recursive data structures that can themselves contain sub-geometries—for example,
 * a "country" feature might consist of a geometry that encompasses several islands, each represented by a
 * subgeometry within the main "country" geometry.
 *
 * @package Eddmash\PhpGis\Gdal
 * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 */
class OgrGeometry
{
    public $featurePtr;
    protected $_ptr;

    /**
     * OgrGeometry constructor.
     * @param $geometryPtr
     * @param $featurePtr
     * @throws GdalException
     */
    private function __construct($geometryPtr, $featurePtr)
    {
        if (!$geometryPtr):
            throw new GdalException("Cannot create layer, invalid pointer provided");
        endif;
        $this->_ptr = $geometryPtr;
        $this->featurePtr = $featurePtr;
    }

    public static function getInstance($geometryPtr, $featurePtr)
    {
        $geom = Gdal::getGeometryType($geometryPtr);
        $class = self::getClassName($geom);
        return new $class($geometryPtr, $featurePtr);
    }

    private static function getClassName($typeID)
    {
        switch ($typeID) {
            case wkbPoint:
            case wkbPoint25D:
                $type = Point::class;
                break;
            case wkbLineString:
            case wkbLineString25D:
                $type = LineString::class;
                break;
            case wkbPolygon:
            case wkbPolygon25D:
                $type = Polygon::class;
                break;
            case wkbMultiPoint:
            case wkbMultiPoint25D:
                $type = MultiPoint::class;
                break;
            case wkbMultiLineString:
            case wkbMultiLineString25D:
                $type = MultiLineString::class;
                break;
            case wkbMultiPolygon:
            case wkbMultiPolygon25D:
                $type = MultiPolygon::class;
                break;
            case wkbGeometryCollection:
            case wkbGeometryCollection25D:
                $type = GeometryCollection::class;
                break;
            case wkbLinearRing:
                $type = LinearRing::class;
                break;
            default:
                $type = self::class;
                break;
        }
        return $type;
    }

    /**
     * @return string
     * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
     */
    public function getName()
    {
        return Gdal::getGeometryName($this->_ptr);
    }

    /**
     * @return OgrGeometryType
     * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
     */
    public function getType()
    {
        return new OgrGeometryType(Gdal::getGeometryType($this->_ptr));
    }

    public function getDimension()
    {
        return Gdal::getGeometryDimension($this->_ptr);
    }

    public function toWkt()
    {
        return Gdal::exportToWkt($this->_ptr);
    }

    public function toJson()
    {
        return Gdal::exportToJson($this->_ptr);
    }

    public function getSrs()
    {
        return new SpatialReference(Gdal::OSRClone(Gdal::getGeometrySrs($this->_ptr)));
    }

    public function __toString()
    {
        return $this->getName();
    }
}