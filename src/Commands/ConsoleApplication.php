<?php
/**
 * This file is part of the ziamis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Gdal\Commands;


use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleApplication
{

    public static function run()
    {
        $output = new ConsoleOutput();
        $application = new Application();
        $def = new ListCommand();
        $application->add($def);
        $application->setDefaultCommand($def->getName());
        $application->add(new CreateSqlCommand());
        $application->run(null, $output);

    }
}