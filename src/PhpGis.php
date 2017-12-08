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
        ConsoleApplication::run();
    }

    private function init()
    {

        if (!self::$connection) :

            $config = new \Doctrine\DBAL\Configuration();

            self::$connection = \Doctrine\DBAL\DriverManager::getConnection($this->db, $config);
        endif;
    }

    /**
     * @return Connection
     */
    public static function getConnection()
    {
        return self::$connection;
    }
}