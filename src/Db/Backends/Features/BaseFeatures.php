<?php

/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Db\Backends\Features;

use Doctrine\DBAL\Platforms\AbstractPlatform;

class BaseFeatures
{
    protected $gisEnabled = true;

    // Does the database contain a SpatialRefSys model to store SRID information?
    protected $hasSpatialrefsysTable = true;

    // Does the backend support the django.contrib.gis.utils.add_srs_entry() utility?
    protected $supportsAddSrsEntry = true;
    // Does the backend introspect GeometryField to its subtypes?
    protected $supportsGeometryFieldIntrospection = true;

    // Does the backend support storing 3D geometries?
    protected $supports3dStorage = false;
    // Reference implementation of 3D functions is:
    // http://postgis.net/docs/PostGIS_Special_Functions_Index.html#PostGIS_3D_Functions
    protected $supports3dFunctions = false;
    // Does the database support SRID transform operations?
    protected $supportsTransform = true;
    // Do geometric relationship operations operate on real shapes (or only on bounding boxes)?
    protected $supportsRealShapeOperations = true;
    // Can geometry fields be null?
    protected $supportsNullGeometries = true;
    // Can the `distance`/`length` functions be applied on geodetic coordinate systems?
    protected $supportsDistanceGeodetic = true;
    protected $supportsLengthGeodetic = true;
    // Is the database able to count vertices on polygons (with `num_points`)?
    protected $supportsNumPointsPoly = true;

    // The following properties indicate if the database backend support
    // certain lookups (dwithin, left and right, relate, ...)
    protected $supportsDistancesLookups = true;
    protected $supportsLeftRightLookups = false;

    // Does the database have raster support?
    protected $supportsRaster = false;

    // Does the database support a unique index on geometry fields?
    protected $supportsGeometryFieldUniqueIndex = true;


    /**
     * @param AbstractPlatform $platform
     * @return BaseFeatures
     * @since  1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public static function getFeatures(AbstractPlatform $platform)
    {
        $name = sprintf(
            "Eddmash\PhpGis\Db\Backends\Features\%s",
            ucfirst($platform->getName())
        );

        return new $name();
    }

    /**
     * @return bool
     */
    public function isGisEnabled()
    {
        return $this->gisEnabled;
    }

    /**
     * @return bool
     */
    public function isHasSpatialrefsysTable()
    {
        return $this->hasSpatialrefsysTable;
    }

    /**
     * @return bool
     */
    public function isSupportsAddSrsEntry()
    {
        return $this->supportsAddSrsEntry;
    }

    /**
     * @return bool
     */
    public function isSupportsGeometryFieldIntrospection()
    {
        return $this->supportsGeometryFieldIntrospection;
    }

    /**
     * @return bool
     */
    public function isSupports3dStorage()
    {
        return $this->supports3dStorage;
    }

    /**
     * @return bool
     */
    public function isSupports3dFunctions()
    {
        return $this->supports3dFunctions;
    }

    /**
     * @return bool
     */
    public function isSupportsTransform()
    {
        return $this->supportsTransform;
    }

    /**
     * @return bool
     */
    public function isSupportsRealShapeOperations()
    {
        return $this->supportsRealShapeOperations;
    }

    /**
     * @return bool
     */
    public function isSupportsNullGeometries()
    {
        return $this->supportsNullGeometries;
    }

    /**
     * @return bool
     */
    public function isSupportsDistanceGeodetic()
    {
        return $this->supportsDistanceGeodetic;
    }

    /**
     * @return bool
     */
    public function isSupportsLengthGeodetic()
    {
        return $this->supportsLengthGeodetic;
    }

    /**
     * @return bool
     */
    public function isSupportsNumPointsPoly()
    {
        return $this->supportsNumPointsPoly;
    }

    /**
     * @return bool
     */
    public function isSupportsDistancesLookups()
    {
        return $this->supportsDistancesLookups;
    }

    /**
     * @return bool
     */
    public function isSupportsLeftRightLookups()
    {
        return $this->supportsLeftRightLookups;
    }

    /**
     * @return bool
     */
    public function isSupportsRaster()
    {
        return $this->supportsRaster;
    }

    /**
     * @return bool
     */
    public function isSupportsGeometryFieldUniqueIndex()
    {
        return $this->supportsGeometryFieldUniqueIndex;
    }


}
