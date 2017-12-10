<?php

/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Db\Backends\Operations;


use Eddmash\PhpGis\Db\Types\SpatialType;
use Eddmash\PhpGis\Exceptions\NotImplementedError;

class Postgresql extends BaseOperations
{

    /**
     * @param SpatialType $spatialType
     * @param $fieldDeclaration
     * @return string
     * @throws NotImplementedError
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getSpatialSqlDeclaration(SpatialType $spatialType, $fieldDeclaration)
    {
        $geom = $spatialType->getName();
        $dimensions = $fieldDeclaration['dimensions'];
        $isGeographic = $fieldDeclaration['is_geographic'];
        $srid = $fieldDeclaration['srid'];

        //todo raster
        if($dimensions == 3):
            $geom = sprintf("%sZ", $geom);
        endif;

        if($isGeographic):
            if($srid != 4326):
                throw new  NotImplementedError('PostGIS only supports geography columns with an SRID of 4326.');
            endif;
            return sprintf('geography(%s,%d)', $geom, $srid);
        endif;
        return sprintf('geometry(%s,%d)', $geom, $srid);
    }


}