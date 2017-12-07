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


use Eddmash\PhpGis\PhpGis;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends \Symfony\Component\Console\Command\ListCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = sprintf('<info>%s</info>', BaseCommand::$headerMessage);
        $output->writeln(sprintf($message, PhpGis::VERSION));

        parent::execute($input, $output); // TODO: Change the autogenerated stub
    }

}