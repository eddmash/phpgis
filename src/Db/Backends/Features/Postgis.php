<?php

/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Db\Backends\Features;

class Postgis extends BaseFeatures
{
    protected $supports3dFunctions = true;
    protected $supports3dStorage=true;
    protected $supportsLeftRightLookups = true;
    protected $supportsRaster = true;
}
