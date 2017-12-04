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

    public static function layerTestCapability($_ptr, $capability)
    {
        return OGR_L_TestCapability($_ptr, $capability);
    }

    public static function getLayerFeatureCount($_ptr)
    {
        return OGR_L_GetFeatureCount($_ptr);
    }

    public static function getLayerName($_ptr)
    {
        return OGR_L_GetName($_ptr);
    }

    public static function getLayerFeature($_ptr, $index)
    {
        return OGR_L_GetFeature($_ptr, $index);
    }

    public static function getLayerNextFeature($_ptr)
    {
        return OGR_L_GetNextFeature($_ptr);
    }

    public static function layerResetReading($_ptr)
    {
        return OGR_L_ResetReading($_ptr);
    }

// ================================= Feature ==================================

    public static function getFeatureFieldCount($_ptr)
    {
        return OGR_F_GetFieldCount($_ptr);
    }

    public static function getFeatureID($_ptr)
    {
        return OGR_F_GetFID($_ptr);
    }

    public static function getFeatureFieldDefn($_ptr, $fli)
    {
        return OGR_F_GetFieldDefnRef($_ptr, $fli);
    }


    public static function getFeatureDefn($_ptr)
    {
        return OGR_F_GetDefnRef($_ptr);
    }

    public static function getFeatureGeometry($featureHandle)
    {
        return OGR_F_GetGeometryRef($featureHandle);
    }

    public static function getFeatureGeomType($_ptrDefn)
    {
        return OGR_FD_GetGeomType($_ptrDefn);
    }


// ================================= Field ==================================

    public static function getFieldName($_ptr)
    {
        return OGR_Fld_GetNameRef($_ptr);
    }

// ================================= Feature Definition ==================================
// ================================= GEOMETRY Definition ==================================
    public static function getGeometryName($geometryHandle)
    {
        return OGR_G_GetGeometryName($geometryHandle);
    }

    public static function getGeometryDimension($geometryPtr)
    {
        return OGR_G_GetDimension($geometryPtr);
    }

    public static function exportToWkt($geometryPtr)
    {
        return OGR_G_ExportToWkt($geometryPtr);
    }

    public static function getSrs($geometryPtr)
    {
        return OGR_G_GetSpatialReference($geometryPtr);
    }
}