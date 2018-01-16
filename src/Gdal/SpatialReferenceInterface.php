<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 1/3/18
 * Time: 6:02 AM
 */

namespace Eddmash\PhpGis\Gdal;


/**
 * Class SpatialReference
 *
 * The spatial reference specifies the projection and datum used by the layer's data.
 *
 * @package Eddmash\PhpGis\Gdal
 * @author  : Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 */
interface SpatialReferenceInterface
{
    public function getName();

    public function getAuthorityCode($key);

    public function getAuthorityName($key);

    public function getAttralue($attr, $child = 0);

    public function isProjected();

    public function isGeographic();

    public function isLocal();

    public function isSame(SpatialReferenceInterface $spatialReference);

    public function isGeocentric();

    /**
     * @since  1.1.0
     * @return string
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function exportToProj4();

    /**
     * @since  1.1.0
     * @return string
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function exportToWkt();

    public function exportToPrettyWkt();

    public function getPointer();

    /**
     * @return int
     * @since  1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getSrid();
}