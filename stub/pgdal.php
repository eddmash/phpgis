<?php

/**
 * This file is part of the pgdal package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGRRegisterAll()
{

}

/**
 * Closes opened datasource and releases allocated resources.
 *
 * @param resource $handle handle to allocated datasource object.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_DS_Destroy($handle)
{

}

/**
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 * @param $file
 * @param bool $update
 * @return null|resource a file pointer resource on success, or null on error.
 */
function OGROpen($file, $update = false)
{

}

/**
 * Returns the name of the data source.
 *
 * @param resource $handle handle to the data source to get the name from.
 * @since 1.1.0
 * @return string name
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_DS_GetName($handle)
{

}

/**
 * Get the number of layers in this data source.
 *
 * @param resource $handle handle to the data source from which to get the number of layers.
 * @since 1.1.0
 * @return int layer count.
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_DS_GetLayerCount($handle)
{

}

/**
 * Fetch the next available feature from this layer.
 *
 * @param resource $layerHandle handle to the layer from which feature are read.
 * @return resource an handle to a feature, or NULL if no more features are available.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_L_GetNextFeature($layerHandle)
{

}

/**
 * Fetch a layer by index.
 *
 * @param resource $handle handle to the data source from which to get the layer.
 * @param int $layer_id a layer number between 0 and OGR_DS_GetLayerCount()-1.
 * @since 1.1.0
 * @return resource
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_DS_GetLayer($handle, $layer_index)
{
}

/**
 * Return the layer name.
 *
 * @param resource $layerHandle handle to the layer.
 * @return string the layer name (must not been freed)
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_L_GetName($layerHandle)
{

}

function OGR_L_ResetReading($layerHandle)
{

}

/**
 * Test if this layer supported the named capability.
 *
 * @param resource $layerHandle handle to the layer to get the capability from.
 * @param string $test the name of the capability to test.
 * @return bool true if the layer has the requested capability, or false otherwise also returns false for any
 * unrecognised capabilities.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_L_TestCapability($layerHandle, $test)
{

}

/**
 * Fetch a layer by name.
 *
 * @param resource $handle handle to the data source from which to get the layer.
 * @param string $name the layer name of the layer to fetch.
 * @return string layer resource, or NULL if the layer is not found or an error occurs.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_DS_GetLayerByName($handle, $name)
{

}

/**
 * Fetch the feature count in this layer.
 *
 * @param resource $layerHandle handle to the layer that owned the features.
 * @param bool $force Flag indicating whether the count should be computed even if it is expensive.
 * @since 1.1.0
 * @return int feature count, -1 if count not known.
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_L_GetFeatureCount($layerHandle, $force = false)
{

}

/**
 * Fetch a feature by its identifier.
 *
 * @param resource $layerHandle handle to the layer that owned the feature.
 * @param int $feature_index the feature id of the feature to read.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_L_GetFeature($layerHandle, $feature_index)
{

}

/**
 * Fetch number of fields on this feature.
 *
 * @param resource $featureHandle 	handle to the feature to get the fields count from.
 * @return int
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_F_GetFieldCount($featureHandle)
{

}

/**
 * Get feature identifier.
 *
 * @param resource $featureHandle handle to the feature from which to get the feature identifier.
 * @return int|null feature id or null if none has been assigned.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_F_GetFID($featureHandle)
{

}

function OGR_F_GetDefnRef($featureHandle){

}
function OGR_FD_GetGeomType($featureDfnHandle){

}
function OGR_F_GetGeometryRef($featureDfnHandle){

}

/**
 * Fetch definition for this field.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 * @param resource $handle handle to the feature on which the field is found.
 * @param int $fieldIndex the field to fetch, from 0 to GetFieldCount()-1.
 * @return resource an handle to the field definition (from the OGRFeatureDefn).
 */
function OGR_F_GetFieldDefnRef($handle, $fieldIndex)
{

}

/**
 * Fetch name of this field.
 *
 * @param resource $handle handle to the field definition.
 * @return string the name of the field definition.
 * @since 1.1.0
 *
 * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
 */
function OGR_Fld_GetNameRef($handle){

}


function OGR_G_GetGeometryName($geometryHandle){

}

function OGR_G_GetDimension($geometryHandle){

}

function  OGR_G_ExportToWkt($geometryPtr){}

function  OGR_G_GetSpatialReference($geometryPtr){}


