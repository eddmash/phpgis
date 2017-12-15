<?php
/**
 * This file is part of the ziamis package.
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
use Eddmash\PowerOrm\BaseOrm;
use Eddmash\PowerOrm\Components\Component;

class PhpGis extends Component
{
    const VERSION = "1.0.0";


    public function __construct()
    {
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     */
    function ready(BaseOrm $baseOrm)
    {
        $this->registerDbalTypes($baseOrm);
    }

    /**
     * @inheritDoc
     */
    function getName()
    {
        return "gis";
    }

    /**
     * @param BaseOrm $baseOrm
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function registerDbalTypes(BaseOrm $baseOrm)
    {

        $this->registerDoctrineTypeMapping(
            $baseOrm,
            PointType::GEOM_TYPE,
            "point",
            PointType::class
        );
        $this->registerDoctrineTypeMapping(
            $baseOrm,
            MultiPointType::GEOM_TYPE,
            "multipoint",
            MultiPointType::class
        );
        $this->registerDoctrineTypeMapping(
            $baseOrm,
            LineStringType::GEOM_TYPE,
            "linestring",
            LineStringType::class
        );
        $this->registerDoctrineTypeMapping(
            $baseOrm,
            MultiLineStringType::GEOM_TYPE,
            "multilinestring",
            MultiLineStringType::class
        );
        $this->registerDoctrineTypeMapping(
            $baseOrm,
            PolygonType::GEOM_TYPE,
            "polygon",
            PolygonType::class
        );
        $this->registerDoctrineTypeMapping(
            $baseOrm,
            MultiPolygonType::GEOM_TYPE,
            "multipolygon",
            MultiPolygonType::class
        );
    }


    /**
     * @param BaseOrm $baseOrm
     * @param $dbType
     * @param $doctrineType
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function registerDoctrineTypeMapping(BaseOrm $baseOrm, $dbType, $doctrineType, $typeClass)
    {
        Type::addType($doctrineType, $typeClass);
        $baseOrm->getDatabaseConnection()->getDatabasePlatform()->registerDoctrineTypeMapping($dbType, $doctrineType);
    }

}