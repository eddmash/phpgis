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


use Eddmash\PhpGis\Db\Types\PointType;
use Eddmash\PhpGis\Db\Types\SpatialType;
use Eddmash\PhpGis\Exceptions\NotImplementedError;

class Mysql extends BaseOperations
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
        if ($spatialType::GEOM_TYPE && is_subclass_of($spatialType, SpatialType::class)):
            return $spatialType::GEOM_TYPE;
        endif;
        throw new NotImplementedError(__METHOD__." for ".$spatialType::GEOM_TYPE." NOT IMPLEMENTED");
    }

    /**
     * @param SpatialType $spatialType
     * @param $sqlExpr
     * @return string
     * @throws NotImplementedError
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function convertToDatabaseValueSQL(SpatialType $spatialType, $sqlExpr)
    {
        if ($spatialType instanceof PointType):
            return sprintf('AsText(%s)', $sqlExpr);
        endif;

        throw new NotImplementedError(__METHOD__." for ".$spatialType::GEOM_TYPE." NOT IMPLEMENTED");
    }

    public function convertToPHPValueSQL(SpatialType $spatialType, $sqlExpr)
    {
        return sprintf('GeomFromText("%s")', $sqlExpr);
    }


}