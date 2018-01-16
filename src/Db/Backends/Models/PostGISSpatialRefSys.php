<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 1/2/18
 * Time: 9:07 PM
 */

namespace Eddmash\PhpGis\Models;


use Eddmash\PhpGis\Model\Model;
use Eddmash\PhpGis\PhpGis;

class PostGISSpatialRefSys extends Model
{

    private function unboundFields()
    {
        return [
            'srid' => Model::IntegerField(),
            'auth_name' => Model::CharField(['maxLength' => 256]),
            'auth_srid' => Model::IntegerField(),
            'srtext' => Model::CharField(['maxLength' => 256]),
            'proj4text' => Model::CharField(['maxLength' => 256]),
        ];
    }

    public function getMetaSettings()
    {
        return [
            'appName' => PhpGis::NAME,
            'dbTable' => 'spatial_ref_sys',
            'managed' => false,
        ];
    }
}