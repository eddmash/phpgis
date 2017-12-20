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


use Eddmash\PhpGis\Db\Database;
use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\PhpGis;
use Eddmash\PhpGis\Tools\LayerInspector;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class InspectCommand extends BaseCommand
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
            );
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $dataSource = $input->getArgument('datasource');
        $tableName = $input->getArgument('tablename');

        $ds = new DataSource($dataSource);
        $connection = PhpGis::getConnection();
        $importer = new LayerInspector($ds, $tableName, $connection);

        $sqlStatement = $importer->getCreateStatement(0);// this is because shapefiels only have layer
        $output->writeln($sqlStatement);
    }
}