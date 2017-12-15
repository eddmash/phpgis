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


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Eddmash\PhpGis\Db\Types\SpatialType;
use Eddmash\PowerOrm\Db\ConnectionInterface;

abstract class BaseOperations implements OperationsInterface
{

    public function getMappedDatabaseTypes(SpatialType $type)
    {
        return [strtolower($type->getName())];
    }

    /**
     * @param AbstractPlatform $platform
     * @return OperationsInterface
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public static function getOperations(ConnectionInterface $connection)
    {
        $name = sprintf(
            "Eddmash\PhpGis\Db\Backends\Operations\%s",
            ucfirst($connection->getDatabasePlatform()->getName())
        );

        return new $name();
    }
}