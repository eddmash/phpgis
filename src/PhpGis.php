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

class PhpGis
{
    const VERSION = "1.0.0";

    /**
     * @var Connection
     */
    private static $connection;

    /**
     * $connectionParams = array(
     * 'dbname' => 'mydb',
     * 'user' => 'user',
     * 'password' => 'secret',
     * 'host' => 'localhost',
     * 'driver' => 'pdo_mysql',
     * );
     * @var array
     */
    private $db;

    public function __construct($configs)
    {
        foreach ($configs as $name => $config) :
            $this->{$name} = $config;
        endforeach;

        $this->init();
    }

    public function consoleRunner()
    {
        ConsoleApplication::run();
    }

    public function webRunner()
    {
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    private function init()
    {

        if (!self::$connection) :

            $config = new \Doctrine\DBAL\Configuration();

            $this->db["wrapperClass"] = \Eddmash\PhpGis\Db\Connection::class;
            self::$connection = \Doctrine\DBAL\DriverManager::getConnection($this->db, $config);
        endif;

        Type::addType("point", PointType::class);
        Type::addType("multipoint", MultiPointType::class);
        Type::addType("linestring", LineStringType::class);
        Type::addType("multilinestring", MultiLineStringType::class);
        Type::addType("polygon", PolygonType::class);
        Type::addType("multipolygon", MultiPolygonType::class);
    }

    /**
     * @return Connection
     */
    public static function getConnection()
    {
        return self::$connection;
    }
}