<?php

/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Db;


use Doctrine\DBAL\Schema\SchemaException;

class Connection extends \Doctrine\DBAL\Connection
{

    public function insert($tableExpression, array $data, array $types = array())
    {

        try {
            $_data = [];
            $table = $this->getSchemaManager()->createSchema()->getTable($tableExpression);
            foreach ($data as $col => $val) :
                $_data[$col] = $table->getColumn($col)->getType()
                    ->convertToPHPValueSQL(
                        $val,
                        $this->getDatabasePlatform()
                    );
            endforeach;
            $data = $_data;
        } catch (SchemaException $e) {
            echo $e->getMessage()."<br>";
        }

        return parent::insert($tableExpression, $data, $types);
    }
}