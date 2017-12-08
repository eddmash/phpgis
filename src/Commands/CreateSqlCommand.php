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


use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Tools\OgrInpect;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSqlCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName($this->guessCommandName())
            ->setDescription('Get sql statements to use when creating database tables for the provided datasource')
            ->addArgument(
                'datasource',
                InputArgument::REQUIRED,
                'Datasource to read. '
            )->addArgument(
                'tablename',
                InputArgument::REQUIRED,
                'Name of the database table to create. '
            )->addOption(
                'db',
                null,
                InputOption::VALUE_REQUIRED,
                'database',
                'psql'
            );;
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $dataSource = $input->getArgument('datasource');
        $tableName = $input->getArgument('tablename');
        $db = $input->getOption('db');

        $ds = new DataSource($dataSource);

        $inspect = new OgrInpect($ds, $tableName, $db);
        foreach ($inspect as $mapping) :
            $output->writeln($mapping);
        endforeach;
    }
}