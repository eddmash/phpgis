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
use Eddmash\PhpGis\Model\Fields\SpatialField;

interface OperationsInterface
{

    /**
     * @param SpatialType $spatialType
     * @return array
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function getMappedDatabaseTypes(SpatialType $spatialType);

    public function getSpatialSqlDeclaration(SpatialType $spatialType, $fieldDeclaration);

    public function convertToDatabaseValueSQL(SpatialType $spatialType, $sqlExpr);

    public function convertToPHPValueSQL(SpatialType $spatialType, $sqlExpr);

    public function getDbType(SpatialField $field);
}
