<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 1/3/18
 * Time: 5:33 AM
 */

namespace Eddmash\PhpGis\Db;


use Eddmash\PhpGis\Db\Backends\Features\BaseFeatures;
use Eddmash\PhpGis\Db\Backends\Operations\BaseOperations;
use Eddmash\PowerOrm\Db\ConnectionInterface;

/**
 * Class ConnectionHandle
 * @package Eddmash\PhpGis\Db
 */
class ConnectionHandle
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * ConnectionHandle constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @inheritDoc
     */
    public function __call($name, $arguments)
    {
        call_user_func_array([$this->connection, $name], $arguments);
    }


    /**
     * @return Backends\Operations\OperationsInterface
     */
    public function getOperations()
    {
        return BaseOperations::getPlatformOperations(
            $this->connection->getDatabasePlatform()
        );
    }

    /**
     * @return BaseFeatures
     * @throws \Eddmash\PowerOrm\Exception\OrmException
     */
    public function getFeatures()
    {
        return BaseFeatures::getFeatures($this->connection->getDatabasePlatform());
    }

}