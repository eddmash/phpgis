<?php

/**
 * This file is part of the powercomponents package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eddmash\PhpGis\Model;


use Eddmash\PhpGis\Model\Fields\LinestringField;
use Eddmash\PhpGis\Model\Fields\PointField;
use Eddmash\PhpGis\Model\Fields\PolygonField;

trait ModelFieldsTrait
{

    /**
     * @since 1.1.0
     * @param array $opts
     * @return PointField
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public static function PointField($opts=[])
    {
        return PointField::createObject($opts);
    }

    /**
     * @param $opt
     * @return PolygonField
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public static function PolygonField($opt=[])
    {
        return PolygonField::createObject($opt);
    }

    /**
     * @param $opt
     * @return LinestringField
     * @since 1.1.0
     *
     * @author Eddilbert Macharia (http://eddmash.com) <edd.cowan@gmail.com>
     */
    public function LinestringField($opt=[])
    {
        return LinestringField::createObject($opt);
    }
}