<?php

use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Gdal\Exceptions\GdalException;

require "../vendor/autoload.php";
/**
 * This file is part of the pgdal package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

try{

    $ds = new DataSource('usa_states/usa_state_shapefile.shp');
    echo " Datasource <strong>".$ds->getName()."</strong> has <strong>".$ds->getLayerCount()."</strong> layers <br>";
    foreach ($ds as $index => $layer) :
        echo " LAYER ". $layer." FEATURE COUNT ".$layer->getFeatureCount()."<br>";
        foreach ($layer as $feature):
            echo $feature->getFeatureID()." ---- FIELD COUNT :: ".$feature->getFieldCount()
                ." Fields { <small>".$feature->getFieldNames()."</small> } <br>";

            foreach ($feature as $field) :
                echo " ********* ".$field."<br>";
            endforeach;

        endforeach;
    endforeach;
}catch (GdalException $exception){
    echo $exception->getMessage()."<br>";
}
//OGRRegisterAll();
//$ds = OGROpen('usa_states/usa_state_shapefile.shp');
//if ($ds):
//    echo "DATASOURCE NAME :: ".OGR_DS_GetName($ds)."<br>";
//    $lcount = OGR_DS_GetLayerCount($ds);
//    echo "LAYER COUNT :: ".$lcount."<br>";
//    for($i=0; $i< $lcount; $i++){
//        echo "-LAYER  :: ".$i."<br>";
//        $layer = OGR_DS_GetLayer($ds, $i);
//        if($layer):
//            $fcount = OGR_L_GetFeatureCount($layer);
//            echo "-FEATURE COUNT :: ".$fcount."<br>";
//
//            while($feature = OGR_L_GetNextFeature($layer)){
//                if($feature):
//                    $fi = OGR_F_GetFID($feature);
//                    $fieldCount = OGR_F_GetFieldCount($feature);
//                    echo "-- Feature $fi <br>";
//                    echo "---- FIELD COUNT :: ".$fieldCount."<br>";
//                    $fields = [];
//                    for($fli=0; $fli< $fieldCount; $fli++){
//                        $fieldDfn = OGR_F_GetFieldDefnRef($feature, $fli);
//                        $type = OGR_Fld_GetType($fieldDfn);
//                        $typeName = OGR_GetFieldTypeName($type);
//                        $fields[] = OGR_Fld_GetNameRef($fieldDfn)." <small>($typeName)</small> ";
//                    }
//                    echo "---- FIELDS [ ".implode(", ", $fields)." ]<br>";
//                else:
//                    echo "NO FEATURE FOUND <br>";
//                endif;
//
//                OGR_F_Destroy($feature);
//            }
//
//        else:
//            echo "NO LAYER FOUND <br>";
//        endif;
//    }
//else:
//    echo "FAILED TO OPEN<br>";
//endif;
//
//OGR_DS_Destroy($ds);
//echo "<br>";