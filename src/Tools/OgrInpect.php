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


use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Gdal\OgrFields\Field;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDate;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDateTime;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger64;
use Eddmash\PhpGis\Gdal\OgrFields\OFTReal;
use Eddmash\PhpGis\Gdal\OgrFields\OFTString;
use Eddmash\PhpGis\Gdal\OgrFields\OFTTime;

class OgrInpect implements \Iterator
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
     * @var
     */
    private $db;

    public function __construct(DataSource $ds, $tableName, $db)
    {
        $this->ds = $ds;
        $this->tableName = $tableName;
        $this->db = $db;
    }

    private function getLayerSql($pos)
    {
        $schema = new Schema();
        $table = $schema->createTable($this->tableName);

        $fieldCount = $this->ds->getLayerByIndex($pos)->getFieldCount();
        foreach (range(0, $fieldCount - 1) as $fieldID) :
            $this->addField($table, $this->ds->getLayerByIndex($pos)->getField($fieldID));
        endforeach;

        return $schema->toSql($this->getDbPlatform());
    }

    private function getDbPlatform()
    {
        switch ($this->db):
            case "mysql":
                $platform = new MySqlPlatform();
                break;
            default:
                $platform = new PostgreSqlPlatform();
        endswitch;

        return $platform;
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

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->getLayerSql($this->layerPos);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->layerPos++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->layerPos;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->layerPos < $this->ds->getLayerCount();
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->layerPos = 0;
    }

}