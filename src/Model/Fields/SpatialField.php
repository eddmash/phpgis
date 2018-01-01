<?php

/**
 * This file is part of the powercomponents package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Model\Fields;

use Eddmash\PhpGis\Db\Backends\Operations\BaseOperations;
use Eddmash\PowerOrm\Db\ConnectionInterface;
use Eddmash\PowerOrm\Helpers\StringHelper;
use Eddmash\PowerOrm\Model\Field\Field;

abstract class SpatialField extends Field
{
    public $srid = 4326;
    public $spatialIndex = true;
    protected $geomType;

    public function getConstructorArgs()
    {
        $kwargs = parent::getConstructorArgs();
        $kwargs['srid'] = $this->srid;

        if (!$this->spatialIndex):
            $kwargs['spatialIndex'] = false;
        endif;

        return $kwargs;
    }

    public function deconstruct()
    {
        $path = static::class;
        $name = $this->getShortClassName();

        if (StringHelper::startsWith(static::class, 'Eddmash\PhpGis\Model\Fields')):
            $path = 'Eddmash\PhpGis\Model\Model as GisModel';
        $name = sprintf('GisModel::%s', $this->getShortClassName());
        endif;

        return [
            'constructorArgs' => $this->getConstructorArgs(),
            'path' => $path,
            'fullName' => static::class,
            'name' => $name,
        ];
    }

    /**
     * @inheritDoc
     */
    public function dbType(ConnectionInterface $connection)
    {
        return BaseOperations::getPlatformOperations(
            $connection->getDatabasePlatform()
        )->getDbType($this);
    }

    public function getGeomType()
    {
        return $this->geomType;
    }
}
