<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 1/1/18
 * Time: 9:39 PM
 */

namespace Eddmash\PhpGis\Helpers;


use Eddmash\PhpGis\Exceptions\LayerMapError;
use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Gdal\Layer;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDate;
use Eddmash\PhpGis\Gdal\OgrFields\OFTDateTime;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger;
use Eddmash\PhpGis\Gdal\OgrFields\OFTInteger64;
use Eddmash\PhpGis\Gdal\OgrFields\OFTReal;
use Eddmash\PhpGis\Gdal\OgrFields\OFTString;
use Eddmash\PhpGis\Gdal\OgrFields\OFTTime;
use Eddmash\PhpGis\Gdal\OgrFields\OgrField;
use Eddmash\PhpGis\Gdal\SpatialReferenceInterface;
use Eddmash\PhpGis\Model\Fields\GeometryField;
use Eddmash\PhpGis\Model\Fields\SpatialField;
use Eddmash\PhpGis\PhpGis;
use Eddmash\PowerOrm\Exception\FieldDoesNotExist;
use Eddmash\PowerOrm\Helpers\ArrayHelper;
use Eddmash\PowerOrm\Model\Field\AutoField;
use Eddmash\PowerOrm\Model\Field\BigAutoField;
use Eddmash\PowerOrm\Model\Field\BigIntegerField;
use Eddmash\PowerOrm\Model\Field\CharField;
use Eddmash\PowerOrm\Model\Field\DateField;
use Eddmash\PowerOrm\Model\Field\DateTimeField;
use Eddmash\PowerOrm\Model\Field\DecimalField;
use Eddmash\PowerOrm\Model\Field\EmailField;
use Eddmash\PowerOrm\Model\Field\Field;
use Eddmash\PowerOrm\Model\Field\FloatField;
use Eddmash\PowerOrm\Model\Field\ForeignKey;
use Eddmash\PowerOrm\Model\Field\IntegerField;
use Eddmash\PowerOrm\Model\Field\SlugField;
use Eddmash\PowerOrm\Model\Field\SmallIntegerField;
use Eddmash\PowerOrm\Model\Field\TextField;
use Eddmash\PowerOrm\Model\Field\TimeField;
use Eddmash\PowerOrm\Model\Field\URLField;
use Eddmash\PowerOrm\Model\Meta;

class LayerMapper
{
    /**
     * @var Meta
     */
    private $meta;
    /**
     * @var DataSource
     */
    private $datasource;

    /**
     * @var array
     */
    private $mapping;

    /**
     * @var Layer
     */
    private $layer;
    private $ogrfield;
    private $fields = [];
    private $geomField;
    private $coorddim;
    private $transform;

    /**
     * @inheritDoc
     */
    public function __construct(
        Meta $meta,
        $datasource,
        $mapping,
        $layer = 0,
        $datasourceSrs = null,
        $transform = true
    ) {
        $this->meta = $meta;
        $this->mapping = $mapping;

        if (is_string($datasource)):
            $this->datasource = new DataSource($datasource);
        else:
            $this->datasource = $datasource;
        endif;

        $this->layer = $this->datasource->getLayerByIndex($layer);

        $this->checkLayer();

        if (PhpGis::getConnection()->getFeatures()->isSupportsTransform()):
            $this->geomField = $this->getGeometryField();
        else:
            $transform = false;
        endif;

        if ($transform):
            $this->datasourceSrs = $this->getSrs($datasourceSrs);
            $this->transform = $this->coordTransform();
        else:
            $this->transform = $transform;
        endif;
    }

    public static function getFieldMappings()
    {
        return [
            AutoField::class => OFTInteger::class,
            BigAutoField::class => OFTInteger64::class,
            IntegerField::class => [
                OFTInteger::class,
                OFTReal::class,
                OFTString::class,
            ],
            FloatField::class => [OFTInteger::class, OFTReal::class],
            DateField::class => OFTDate::class,
            DateTimeField::class => OFTDateTime::class,
            EmailField::class => OFTString::class,
            TimeField::class => OFTTime::class,
            DecimalField::class => [OFTInteger::class, OFTReal::class],
            CharField::class => OFTString::class,
            SlugField::class => OFTString::class,
            TextField::class => OFTString::class,
            URLField::class => OFTString::class,
            BigIntegerField::class => [
                OFTInteger::class,
                OFTReal::class,
                OFTString::class,
            ],
            SmallIntegerField::class => [
                OFTInteger::class,
                OFTReal,
                OFTString::class,
            ],
        ];
    }

    public function save()
    {

    }

    /**
     * @throws LayerMapError
     * @throws \Eddmash\PhpGis\Gdal\Exceptions\GdalException
     * @throws \Eddmash\PowerOrm\Exception\KeyError
     */
    private function checkLayer()
    {
        foreach ($this->mapping as $modelFieldName => $ogrFieldName) :

            try {
                $modelField = $this->meta->getField($modelFieldName);
            } catch (FieldDoesNotExist $e) {
                throw new LayerMapError(
                    sprintf(
                        'Given mapping field "%s" not in given Model fields.',
                        $modelFieldName
                    )
                );
            }

            if ($modelField instanceof GeometryField):
                if ($this->geomField):
                    throw new LayerMapError(
                        'LayerMapping does not '.
                        'support more than one GeometryField per model.'
                    );
                endif;

                // Getting the coordinate dimension of the geometry field.
                $coordDim = $modelField->getDim();

                //todo validate that the mapped field and the layer are of the same geomtype
                $val = $modelField;
                $this->geomField = $modelFieldName;
                $this->coorddim = $coordDim;
            elseif ($modelField instanceof ForeignKey):
                //todo
            else:
                $ogrField = $this->layer->getField($ogrFieldName);
                if (!$this->validateMapping($ogrField, $modelField)):

                    throw new LayerMapError(
                        sprintf(
                            'OGR field "%s" (of type %s) '.
                            'cannot be mapped to Powerorm %s.',
                            $ogrFieldName,
                            get_class($ogrField),
                            get_class($modelField)
                        )
                    );

                endif;

                $val = $modelField;
            endif;


            $this->fields[$modelFieldName] = $val;
        endforeach;
    }

    /**
     * @return SpatialField|Field
     * @throws FieldDoesNotExist
     */
    public function getGeometryField()
    {
        return $this->meta->getField($this->geomField);
    }

    /**
     * @param OgrField $ogrField
     * @param Field    $modelField
     * @return bool
     * @throws \Eddmash\PowerOrm\Exception\KeyError
     */
    private function validateMapping(OgrField $ogrField, Field $modelField)
    {
        $modelClass = get_class($modelField);
        $status = array_key_exists($modelClass, static::getFieldMappings());

        if ($status):
            $mappings = (array)ArrayHelper::getValue(
                static::getFieldMappings(),
                $modelClass
            );

            $status = false;

            foreach ($mappings as $mapping) :
                if (is_subclass_of($ogrField, $mapping) ||
                    $mapping == get_class($ogrField)):
                    $status = true;
                    break;
                endif;
            endforeach;
        endif;

        return $status;
    }

    /**
     * @param $datasourceSrs
     * @return SpatialReferenceInterface
     * @throws LayerMapError
     */
    private function getSrs($datasourceSrs)
    {
        $srs = $this->layer->getSrs();
        if (!$srs):
            throw new LayerMapError('No source reference system defined.');
        endif;

        return $srs;
    }

    private function coordTransform()
    {
        $model = PhpGis::getConnection()->getOperations()
            ->getSpatialRefModelClass();

        $targetSrs = $model::objects()
            ->get(['srid' => $this->geomField->getSrid()])->srs;

        return new CoordTransform($this->datasourceSrs, $targetSrs);

    }
}
