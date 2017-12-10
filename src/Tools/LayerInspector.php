<?php
/**
 * This file is part of the ziamis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Tools;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Gdal\Layer;
use Eddmash\PhpGis\Gdal\OgrFields\Field;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDate;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDateTime;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger64;
use Eddmash\PhpGis\Gdal\OgrFields\OFTReal;
use Eddmash\PhpGis\Gdal\OgrFields\OFTString;
use Eddmash\PhpGis\Gdal\OgrFields\OFTTime;

class LayerInspector
{
    /**
     * @var DataSource
     */
    private $ds;
    /**
     * @var
     */
    private $tableName;

    private $layerPos;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(DataSource $ds, $tableName, Connection $connection)
    {
        $this->ds = $ds;
        $this->tableName = $tableName;
        $this->connection = $connection;
    }

    public function getCreateStatement($pos)
    {
        $layer = $this->ds->getLayerByIndex($pos);
        $schema = new Schema();
        $table = $schema->createTable($this->tableName);

        $fieldCount = $this->ds->getLayerByIndex($pos)->getFieldCount();
        foreach (range(0, $fieldCount - 1) as $fieldID) :
            $this->addField($table, $layer->getField($fieldID));
        endforeach;

        $this->addGeometry($table, $layer);


        return $schema->toSql($this->getDbPlatform());
    }

    private function getDbPlatform()
    {
        return $this->connection->getDatabasePlatform();
    }

    private function addGeometry(Table $table, Layer $layer)
    {
        $type = str_replace("25D", "", $layer->getGeomType()->getName());

        $srid = $layer->getSrs()->getSrid();

        $table->addColumn(
            "geom",
            strtolower($type),
            [
                'customSchemaOptions' => [
                    "srid" => ($srid) ? $srid : 4326,
                    "is_geographic" => false,
                    "dimensions" => 2,
                ],
            ]
        );
    }

    private function addField(Table $table, Field $field)
    {
        $isDecimal = false;
        switch (true):
            case $field instanceof OFTInteger64:
                $type = "bigint";
                break;
            case $field instanceof OFTInteger :
                $type = "integer";
                break;
            case $field instanceof OFTDate:
                $type = "date";
                break;
            case $field instanceof OFTDateTime:
                $type = "datetime";
                break;
            case $field instanceof OFTTime:
                $type = "time";
                break;
            case $field instanceof OFTString:
                $type = "string";
                break;
            case $field instanceof OFTReal:
                $type = "decimal";
                $isDecimal = true;
                break;
            default:
                $type = "string";
        endswitch;

        $table->addColumn($field->getName(), $type, $this->getDoctrineColumnOptions($field, $isDecimal));
    }

    public function getDoctrineColumnOptions(Field $field, $isDecimal = false)
    {
        $options = [];
        // set constraint
        if ($field->getWidth()):
            $options['length'] = $field->getWidth();
        endif;

        if ($isDecimal) :
            if ($field->getPrecision()):
                $options['scale'] = $field->getPrecision();
            endif;
            if ($field->getWidth()):
                $options['precision'] = $field->getWidth();
            endif;
        endif;

        return $options;
    }


}