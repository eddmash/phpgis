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

phpinfo();
//try{
//
////    $ds = new DataSource('KEN_adm/KEN_adm1.shp');
////    $ds = new DataSource('cities/cities.shp');
//    $ds = new DataSource('world/TM_WORLD_BORDERS-0.3.shp');
//    echo " Datasource <strong>".$ds->getName()."</strong> has <strong>".$ds->getLayerCount()."</strong> layers <br>";
//    foreach ($ds as $index => $layer) :
//        echo " LAYER ". $layer." FEATURE COUNT ".$layer->getFeatureCount()." GEOM ".$layer->getGeomType()."<br>";
//        if($layer->getSrs()):
//            echo " LAYER SRS ". $layer->getSrs()->exportToWkt()."<br>";
//            echo " PROJ4 ".$layer->getSrs()->exportToProj4()."<br>";
//        else:
//            echo "NO-SRS <br>";
//        endif;
//        echo "################# FEATURES ################### <br><br><br>";
//
//        foreach ($layer as $feature):
//            echo $feature->getFeatureID().". GEOM TYPE :: ".$feature->getGeomType()." NAME ".$feature->getGeometry().
//                " DIMESION "
//                .$feature->getGeometry()->getDimension()
//                ."<br>";
//            $srs = $feature->getGeometry()->getSrs();
//            echo "isPro ".$srs->isProjected(). " isGeo ".$srs->isGeographic()." isLocal ".$srs->isLocal()." isSame "
//                .$srs->isSame($srs). " isGEOC".$srs->isGeocentric()."<br>";
//            echo "AUTHORITY {".$srs->getAuthorityName("GEOGCS"). "} CODE {".$srs->getAuthorityCode("GEOGCS")."} <br>";
//            echo "DATUM ".$srs->getAttralue("DATUM")."<br>";
//            echo "WKT :: ".$srs->exportToWkt()."<br>";
//            echo $feature->getFeatureID()." ---- FIELD COUNT :: ".$feature->getFieldCount()
//                ." Types { <small>".$feature->getFieldNames()."</small> } <br>";
//
//            foreach ($feature as $field) :
//                echo " ********* ".$field."<br>";
//            endforeach;
//            echo "<br><br><br>";
//        endforeach;
//    endforeach;
//}catch (GdalException $exception){
//    echo $exception->getMessage()."<br>";
//}


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