<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 1/2/18
 * Time: 10:08 AM
 */

namespace Eddmash\PhpGis\Exceptions;


use Throwable;

class LayerMapError extends \Error
{
    /**
     * @inheritDoc
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}