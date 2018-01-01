<?php

namespace Eddmash\PhpGis\Gdal\Wrapper;

/**
 * This file is part of the powerocomponentsdemo package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Gdal
{
    const  OLCRandomRead = "RandomRead";

    // ================================= Datasource ==================================

    public static function datasourceOpen($file, $update = false)
    {
        return OGROpen($file, $update);
    }

    public static function datasourceClose($handle)
    {
        return OGR_DS_Destroy($handle);
    }

    public static function getDatasourceName($handle)
    {
        return OGR_DS_GetName($handle);
    }

    public static function getDatasourceLayerCount($_ptr)
    {
        return OGR_DS_GetLayerCount($_ptr);
    }

    public static function getDatasourceLayer($_ptr, $index)
    {
        return OGR_DS_GetLayer($_ptr, $index);
    }

    public static function getDatasourceLayerByName($_ptr, $name)
    {
        return OGR_DS_GetLayerByName($_ptr, $name);
    }

    // ================================= Layer ==================================

    public static function layerTestCapability($layerHandle, $capability)
    {
        return OGR_L_TestCapability($layerHandle, $capability);
    }

    public static function getLayerFeatureCount($layerHandle)
    {
        return OGR_L_GetFeatureCount($layerHandle);
    }

    public static function getLayerName($layerHandle)
    {
        return OGR_L_GetName($layerHandle);
    }

    public static function getLayerDefn($layerHandle)
    {
        return OGR_L_GetLayerDefn($layerHandle);
    }

    public static function getLayerFeature($layerHandle, $index)
    {
        return OGR_L_GetFeature($layerHandle, $index);
    }

    public static function getLayerNextFeature($layerHandle)
    {
        return OGR_L_GetNextFeature($layerHandle);
    }

    public static function getLayerSpatialReference($layerHandle)
    {
        return OGR_L_GetSpatialRef($layerHandle);
    }

    public static function layerResetReading($layerHandle)
    {
        return OGR_L_ResetReading($layerHandle);
    }

    // ================================= Feature ==================================

    public static function getFeatureFieldCount($featureHandle)
    {
        return OGR_F_GetFieldCount($featureHandle);
    }

    public static function getFeatureID($featureHandle)
    {
        return OGR_F_GetFID($featureHandle);
    }

    public static function getFeatureFieldDefn($featureHandle, $fli)
    {
        return OGR_F_GetFieldDefnRef($featureHandle, $fli);
    }


    public static function getFeatureDefn($featureHandle)
    {
        return OGR_F_GetDefnRef($featureHandle);
    }

    public static function getFeatureGeometry($featureHandle)
    {
        return OGR_F_GetGeometryRef($featureHandle);
    }


    public static function getFieldAsString($featureHandle, $fieldIndex)
    {
        return OGR_F_GetFieldAsString($featureHandle, $fieldIndex);
    }

    public static function getFieldAsInteger($featureHandle, $fieldIndex)
    {
        return OGR_F_GetFieldAsInteger($featureHandle, $fieldIndex);
    }

    public static function getFieldAsDouble($featureHandle, $fieldIndex)
    {
        return OGR_F_GetFieldAsDouble($featureHandle, $fieldIndex);
    }

    public static function getFieldAsDateTime(
        $featureHandle,
        $fieldIndex,
        &$year,
        &$month,
        &$day,
        &$hour,
        &$minute,
        &$second,
        &$timezone
    ) {
        return OGR_F_GetFieldAsDateTime(
            $featureHandle,
            $fieldIndex,
            $year,
            $month,
            $day,
            $hour,
            $minute,
            $second,
            $timezone
        );
    }

    // ================================= Field ==================================

    public static function getFieldName($fieldDefnHandle)
    {
        return OGR_Fld_GetNameRef($fieldDefnHandle);
    }

    public static function getFieldType($fieldDefnHandle)
    {
        return OGR_Fld_GetType($fieldDefnHandle);
    }

    public static function getFieldWidth($fieldDefnHandle)
    {
        return OGR_Fld_GetWidth($fieldDefnHandle);
    }

    public static function getFieldPrecision($fieldDefnHandle)
    {
        return OGR_Fld_GetPrecision($fieldDefnHandle);
    }

    // ================================= Feature Definition ==================================
    public static function getDefnFieldCount($featureDfnHandle)
    {
        return OGR_FD_GetFieldCount($featureDfnHandle);
    }

    public static function getDefnFieldDefn($featureDfnHandle, $index)
    {
        return OGR_FD_GetFieldDefn($featureDfnHandle, $index);
    }

    public static function getDefnFieldIndexByName($featureDfnHandle, $name)
    {
        return OGR_FD_GetFieldIndex($featureDfnHandle, $name);
    }

    public static function getGeomTypeFromFeatureDefn($featureDefnHandle)
    {
        return OGR_FD_GetGeomType($featureDefnHandle);
    }

    // ================================= GEOMETRY Definition ==================================
    public static function getGeometryName($geometryHandle)
    {
        return OGR_G_GetGeometryName($geometryHandle);
    }

    public static function getGeometryType($geometryHandle)
    {
        return OGR_G_GetGeometryType($geometryHandle);
    }

    public static function getGeometryDimension($geometryPtr)
    {
        return OGR_G_GetDimension($geometryPtr);
    }

    public static function exportToWkt($geometryPtr)
    {
        return OGR_G_ExportToWkt($geometryPtr);
    }

    public static function exportToJson($geometryPtr)
    {
        return OGR_G_ExportToJson($geometryPtr);
    }

    public static function getGeometrySrs($geometryPtr)
    {
        return OGR_G_GetSpatialReference($geometryPtr);
    }

    public static function OSRExportToProj4($srsPtr)
    {
        return OSRExportToProj4($srsPtr);
    }

    public static function OSRExportToWkt($srsPtr)
    {
        return OSRExportToWkt($srsPtr);
    }

    public static function OSRExportToPrettyWkt($srsPtr)
    {
        return OSRExportToPrettyWkt($srsPtr);
    }


    public static function getAuthorityCode($srsPtr, $key = null)
    {
        return OSRGetAuthorityCode($srsPtr, $key);
    }

    public static function getAuthorityName($srsPtr, $key = null)
    {
        return OSRGetAuthorityName($srsPtr, $key);
    }

    public static function getAttrValue($srsPtr, $key, $child = 0)
    {
        return OSRGetAttrValue($srsPtr, $key, $child);
    }


    public static function OSRIsProjected($srsPtr)
    {
        return OSRIsProjected($srsPtr);
    }

    public static function OSRIsGeographic($srsPtr)
    {
        return OSRIsGeographic($srsPtr);
    }

    public static function OSRIsLocal($srsPtr)
    {
        return OSRIsLocal($srsPtr);
    }

    public static function OSRIsSame($srsPtr, $srsPtr2)
    {
        return OSRIsSame($srsPtr, $srsPtr2);
    }

    public static function OSRIsGeocentric($srsPtr)
    {
        return OSRIsGeocentric($srsPtr);
    }

    public static function OSRClone($srsPtr)
    {
        return OSRClone($srsPtr);
    }
}
