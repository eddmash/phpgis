<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 1/2/18
 * Time: 6:48 PM
 */

namespace Eddmash\PhpGis\Helpers;


use Eddmash\PhpGis\Gdal\SpatialReference;
use Eddmash\PhpGis\Gdal\SpatialReferenceInterface;
use Eddmash\PhpGis\Gdal\Wrapper\Gdal;

class CoordTransform
{
    /**
     * @inheritDoc
     */
    public function __construct(
        SpatialReferenceInterface $source,
        SpatialReferenceInterface $target
    ) {
        $this->ptr = Gdal::CoordinateTransform(
            $source->getPointer(),
            $target->getPointer()
        );
        $this->sourceName = $source->getName();
        $this->targetName = $target->getName();
    }

    /**
     * @inheritDoc
     */
    public function __destruct()
    {
        Gdal::DestroyCoordinateTransform($this->ptr);
    }


}