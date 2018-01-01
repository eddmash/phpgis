<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 12/25/17
 * Time: 7:41 PM
 */

namespace Eddmash\PhpGis\Commands;

use Eddmash\PowerOrm\Console\Command\BaseCommand;

class Command extends BaseCommand
{
    public function guessCommandName()
    {
        return sprintf("gis:%s", parent::guessCommandName());
    }
}
