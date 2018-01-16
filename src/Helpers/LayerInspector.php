<?php
/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Helpers;

use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Gdal\Layer;
use Eddmash\PhpGis\Gdal\OgrFields\OgrField;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDate;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDateTime;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger64;
use Eddmash\PhpGis\Gdal\OgrFields\OFTReal;
use Eddmash\PhpGis\Gdal\OgrFields\OFTTime;
use Eddmash\PhpGis\Model\Model;
use Eddmash\PowerOrm\Form\Fields\CharField;
use Eddmash\PowerOrm\Form\Fields\DateField;
use Eddmash\PowerOrm\Form\Fields\DecimalField;
use Eddmash\PowerOrm\Form\Fields\IntegerField;
use Eddmash\PowerOrm\Form\Fields\TimeField;
use Eddmash\PowerOrm\Helpers\Tools;
use Eddmash\PowerOrm\Migration\FormatFileContent;
use Eddmash\PowerOrm\Model\Field\BigIntegerField;
use Eddmash\PowerOrm\Model\Field\DateTimeField;

class LayerInspector
{
    /**
     * @var DataSource
     */
    private $ds;
    /**
     * @var
     */
    private $modelname;

    private $layerPos;
    private $mapping;

    public function __construct(DataSource $ds, $modelname)
    {
        $this->ds = $ds;
        $this->modelname = $modelname;
    }


    private function addGeometryField(Layer $layer)
    {
        $name = str_replace("25D", "", $layer->getGeomType()->getName());
        $field = $layer->getGeomType()->getOrmField();
        $srid = $layer->getSrs()->getSrid();
        $name = strtolower($name);

        $args = sprintf(
            "['srid'=>%s, 'is_geographic'=>%s, 'dimensions'=>%s]",
            ($srid) ? $srid : 4326,
            'false',
            2
        );

        $this->mapping[$name] = strtoupper($layer->getGeomType()->getName());
        return sprintf("'%s' => Model::%s(%s)", $name, $field, $args);
    }

    private function addField(OgrField $field)
    {
        $name = strtolower($field->getName());
        $this->mapping[$name] = $field->getName();
        $args = '';
        switch (true):
            case $field instanceof OFTInteger64:
                $modelField = BigIntegerField::class;
                break;
            case $field instanceof OFTInteger:
                $modelField = IntegerField::class;
                break;
            case $field instanceof OFTDate:
                $modelField = DateField::class;
                break;
            case $field instanceof OFTDateTime:
                $modelField = DateTimeField::class;
                break;
            case $field instanceof OFTTime:
                $modelField = TimeField::class;
                break;
            case $field instanceof OFTReal:
                $modelField = DecimalField::class;
                $args = sprintf(
                    "['maxDigits'=>%s, 'decimalPlaces'=>%s]",
                    $field->getWidth(),
                    $field->getPrecision()
                );
                break;
            default:
                $modelField = CharField::class;
                $args = sprintf("['maxLength'=>%s]", $field->getWidth());
        endswitch;

        return sprintf(
            "'%s' => Model::%s(%s)",
            $name,
            end(explode("\\", $modelField)),
            $args
        );
    }

    /**
     * @param $layerIndex
     * @throws \Eddmash\PhpGis\Gdal\Exceptions\GdalException
     */
    public function getModel($layerIndex)
    {
        $content = FormatFileContent::createObject();
        $content->addItem('<?php');
        $content->addItem(
            PHP_EOL.sprintf(
                '/**Model generated at %s on %s by PowerOrm(%s)*/',
                date('h:m:i'),
                date('D, jS F Y'),
                POWERORM_VERSION
            ).PHP_EOL
        );
        $content->addItem(sprintf('use %s;'.PHP_EOL, Model::class));
        $content->addItem(
            sprintf(
                "class %s extends Model{",
                $this->modelname
            )
        );
        $content->addIndent();
        $content->addItem("private function unboundFields(){");
        $content->addIndent();

        $layer = $this->ds->getLayerByIndex($layerIndex);
        $content->addItem("return [");
        $content->addIndent();

        foreach (range(0, $layer->getFieldCount() - 1) as $index) :
            $field = $layer->getField($index);
            $content->addItem($this->addField($field).", ");
        endforeach;
        $content->addItem($this->addGeometryField($layer));
        $content->reduceIndent();
        $content->addItem("];");

        $content->reduceIndent();
        $content->addItem("}");
        $content->reduceIndent();
        $content->addItem("}");

        return $content->toString();
    }

    public function getMappingAssoc()
    {
        return Tools::stringify(
            $this->mapping,
            0,
            0,
            true
        );
    }

    /**
     * @return mixed
     */
    public function getMapping()
    {
        return $this->mapping;
    }
}
