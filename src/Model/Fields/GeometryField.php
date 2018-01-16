<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 12/29/17
 * Time: 9:02 PM
 */

namespace Eddmash\PhpGis\Model\Fields;

class GeometryField extends SpatialField
{
    protected $dim=2;
    protected $geography=false;

    public function getConstructorArgs()
    {
        $kwargs =  parent::getConstructorArgs();
        if ($this->dim != 2):
            $kwargs['dim'] = $this->dim;
        endif;

        if ($this->geography):
            $kwargs['geography'] = $this->geography;
        endif;
        return $kwargs;
    }

    /**
     * @return bool
     */
    public function isGeography()
    {
        return $this->geography;
    }

    /**
     * @return int
     */
    public function getDim()
    {
        return $this->dim;
    }


}
