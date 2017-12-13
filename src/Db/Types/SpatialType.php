<?php
/**
 * This file is part of the ziamis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Db\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Eddmash\PhpGis\Db\Backends\Operations\BaseOperations;
use Eddmash\PhpGis\Db\Backends\Operations\OperationsInterface;

abstract class SpatialType extends Type
{
    const GEOM_TYPE = "Geometry";

    public function getName()
    {
        return static::GEOM_TYPE;
    }

    /**
     * Gets an array of database types that map to this Doctrine type.
     *
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return array
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform)
    {
        return $this->getOperations($platform)->getMappedDatabaseTypes($this);
    }

    /**
     * @param $platform
     * @since 1.1.0
     * @return OperationsInterface
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function getOperations(AbstractPlatform $platform)
    {
        return BaseOperations::getOperator($platform);
    }


    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array $fieldDeclaration The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return BaseOperations::getOperator($platform)->getSpatialSqlDeclaration($this, $fieldDeclaration);
    }

    /**
     * Modifies the SQL expression (identifier, parameter) to convert to a database value.
     *
     * @param string $sqlExpr
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return BaseOperations::getOperator($platform)->convertToDatabaseValueSQL($this, $sqlExpr);
    }

    /**
     * Modifies the SQL expression (identifier, parameter) to convert to a PHP value.
     *
     * @param string $sqlExpr
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return BaseOperations::getOperator($platform)->convertToPHPValueSQL($this, $sqlExpr);
    }

    /**
     * Does working with this column require SQL conversion functions?
     *
     * This is a metadata function that is required for example in the ORM.
     * Usage of {@link convertToDatabaseValueSQL} and
     * {@link convertToPHPValueSQL} works for any type and mostly
     * does nothing. This method can additionally be used for optimization purposes.
     *
     * @return boolean
     */
    public function canRequireSQLConversion()
    {
        return true;
    }


}