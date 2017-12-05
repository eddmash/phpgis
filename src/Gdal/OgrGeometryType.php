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


class OgrGeometryType
{
    private $num;

    public function __construct($typeID)
    {
        if (is_numeric($typeID)) :
            $this->num = (integer)$typeID;
        endif;
    }

    /**
     * @return string
     * @author: Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
     */
    public function getName()
    {
        return $this->getType($this->num);
    }

    protected function getType($typeID)
    {
        $type = "Unknown";

        switch ($typeID) {
            case wkbUnknown:
                $type = "Unknown";
                break;
            case wkbPoint:
                $type = "Point";
                break;
            case wkbLineString:
                $type = "LineString";
                break;
            case wkbPolygon:
                $type = "Polygon";
                break;
            case wkbMultiPoint:
                $type = "MultiPoint";
                break;
            case wkbMultiLineString:
                $type = "MultiLineString";
                break;
            case wkbMultiPolygon:
                $type = "MultiPolygon";
                break;
            case wkbGeometryCollection:
                $type = "GeometryCollection";
                break;
            case wkbNone:
                $type = "None";
                break;
            case wkbLinearRing:
                $type = "LinearRing";
                break;
            case wkbPoint25D:
                $type = "Point25D";
                break;
            case wkbLineString25D:
                $type = "LineString25D";
                break;
            case wkbPolygon25D:
                $type = "Polygon25D";
                break;
            case wkbMultiPoint25D:
                $type = "MultiPoint25D";
                break;
            case wkbMultiLineString25D:
                $type = "MultiLineString25D";
                break;
            case wkbMultiPolygon25D:
                $type = "MultiPolygon25D";
                break;
            case wkbGeometryCollection25D:
                $type = "GeometryCollection25D";
                break;
        }

        return $type;
    }

    public function __toString()
    {
        return $this->getName();
    }
}