<?php
/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Gdal\Commands;


use Eddmash\PhpGis\PhpGis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{

    public static $headerMessage = 'PHPGIS (%s) by Eddilbert Macharia(edd.cowan@gmail.com)(http://eddmash.com)';


    protected function configure()
    {
        $this->setName($this->guessCommandName());
    }


    /**
     * Returns the name of the current class in lower case and strips off the "Command".
     *
     * @return string
     */
    public function guessCommandName()
    {
        $name = get_class($this);
        $name = substr($name, strripos($name, '\\') + 1);
        $name = (false === strripos($name, 'Command')) ? $name : substr($name, 0, strripos($name, 'Command'));

        return strtolower($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = sprintf('<info>%s</info>', self::$headerMessage);
        $output->writeln(sprintf($message, PhpGis::VERSION));

        $out = $this->handle($input, $output);
        if (!empty($output) && !empty($out)):
            $output->writeln('success');
        endif;
    }


    public abstract function handle(InputInterface $input, OutputInterface $output);
}