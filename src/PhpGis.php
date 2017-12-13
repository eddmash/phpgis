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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Eddmash\PhpGis\Db\Types\LineStringType;
use Eddmash\PhpGis\Db\Types\MultiLineStringType;
use Eddmash\PhpGis\Db\Types\MultiPointType;
use Eddmash\PhpGis\Db\Types\MultiPolygonType;
use Eddmash\PhpGis\Db\Types\PointType;
use Eddmash\PhpGis\Db\Types\PolygonType;
use Eddmash\PhpGis\Gdal\Commands\ConsoleApplication;
use Eddmash\PowerOrm\BaseOrm;
use Eddmash\PowerOrm\Components\Component;
use Eddmash\PowerOrm\Components\ComponentInterface;

class PhpGis extends Component
{
    const VERSION = "1.0.0";


    public function __construct()
    {
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
    private function registerDoctrineTypeMapping(BaseOrm $baseOrm, $dbType, $doctrineType)
    {
        $baseOrm->getDatabaseConnection()->getDatabasePlatform()->registerDoctrineTypeMapping($dbType, $doctrineType);
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
        Type::addType("point", PointType::class);
        Type::addType("multipoint", MultiPointType::class);
        Type::addType("linestring", LineStringType::class);
        Type::addType("multilinestring", MultiLineStringType::class);
        Type::addType("polygon", PolygonType::class);
        Type::addType("multipolygon", MultiPolygonType::class);


        $this->registerDoctrineTypeMapping($baseOrm,PointType::GEOM_TYPE, "point");
        $this->registerDoctrineTypeMapping($baseOrm,MultiPointType::GEOM_TYPE, "multipoint");
        $this->registerDoctrineTypeMapping($baseOrm,LineStringType::GEOM_TYPE, "linestring");
        $this->registerDoctrineTypeMapping($baseOrm,MultiLineStringType::GEOM_TYPE, "multilinestring");
        $this->registerDoctrineTypeMapping($baseOrm,PolygonType::GEOM_TYPE, "polygon");
        $this->registerDoctrineTypeMapping($baseOrm,MultiPolygonType::GEOM_TYPE, "multipolygon");
    }

    /**
     * @inheritDoc
     */
    function getName()
    {
        return "gis";
    }


}