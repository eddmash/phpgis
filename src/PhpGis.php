<?php
/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis;

use Doctrine\DBAL\Types\Type;
use Eddmash\PhpGis\Db\Types\LineStringType;
use Eddmash\PhpGis\Db\Types\MultiLineStringType;
use Eddmash\PhpGis\Db\Types\MultiPointType;
use Eddmash\PhpGis\Db\Types\MultiPolygonType;
use Eddmash\PhpGis\Db\Types\PointType;
use Eddmash\PhpGis\Db\Types\PolygonType;
use Eddmash\PhpGis\Commands\InspectCommand;
use Eddmash\PowerOrm\BaseOrm;
use Eddmash\PowerOrm\Components\Component;

/**
 * PhpGis is component of the powerorm.
 *
 * To be able to take its full capability its needs to be registered with orm.
 *
 * 'components' => [PhpGis::class]
 *
 * Class PhpGis
 * @package Eddmash\PhpGis
 * @since   1.1.0
 *
 * @author  Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
class PhpGis extends Component
{
    const VERSION = "1.0.0";

    private $orm;

    public function __construct()
    {
    }

    /**
     * @return \Eddmash\PowerOrm\Db\ConnectionInterface
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     */
    public static function getConnection()
    {
        return BaseOrm::getDbConnection();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @since  1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     */
    public function ready(BaseOrm $baseOrm)
    {
        $this->registerDbalTypes($baseOrm);
        $this->orm = $baseOrm;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return "gis";
    }

    /**
     * @inheritDoc
     */
    public function getCommands()
    {
        return [
            InspectCommand::class,
        ];
    }

    /**
     * @param BaseOrm $baseOrm
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     * @since  1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function registerDbalTypes(BaseOrm $baseOrm)
    {
        $this->registerDoctrineTypeMapping(
            "POINT",
            PointType::class
        );
        $this->registerDoctrineTypeMapping(
            "multipoint",
            MultiPointType::class
        );
        $this->registerDoctrineTypeMapping(
            "linestring",
            LineStringType::class
        );
        $this->registerDoctrineTypeMapping(
            "multilinestring",
            MultiLineStringType::class
        );
        $this->registerDoctrineTypeMapping(
            "polygon",
            PolygonType::class
        );
        $this->registerDoctrineTypeMapping(
            "multipolygon",
            MultiPolygonType::class
        );
    }


    /**
     * @param BaseOrm $baseOrm
     * @param         $dbType
     * @param         $doctrineType
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     * @since  1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function registerDoctrineTypeMapping(
        $doctrineType,
        $typeClass
    ) {
        Type::addType(strtoupper($doctrineType), $typeClass);
    }


    /**
     * @return mixed
     */
    public function getOrm()
    {
        return $this->orm;
    }
}
