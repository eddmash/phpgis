<?php
/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Eddmash\PhpGis\Commands;

use Eddmash\PhpGis\Gdal\DataSource;
use Eddmash\PhpGis\Helpers\LayerInspector;
use Eddmash\PowerOrm\Helpers\FileHandler;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InspectCommand extends Command
{
    public function configure()
    {
        $this->setName($this->guessCommandName())
            ->setDescription(
                'Inspects the given OGR-compatible data source '.
                '(e.g., a shapefile) and outputs'.PHP_EOL.
                '                      a Powerorm model with the given model name.'.
                ' For example:'.
                PHP_EOL.'                      vendor/bin/pmanage '.
                'inspect zipcode.shp Zipcode'
            )
            ->addArgument(
                'datasource',
                InputArgument::REQUIRED,
                'Datasource to read. '
            )->addArgument(
                'modelname',
                InputArgument::REQUIRED,
                'Name of the model to create. '
            )->addOption(
                "write",
                null,
                InputOption::VALUE_NONE,
                "Write this class to file"
            )->addOption(
                "mapping",
                null,
                InputOption::VALUE_NONE,
                "Tells inspect to also generate a mapping".
                " dictionary for use with LayerMapping."
            );
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $dataSource = $input->getArgument('datasource');
        $modelname = $input->getArgument('modelname');
        $write = $input->getOption('write');

        $ds = new DataSource($dataSource);
        try {
            $importer = new LayerInspector($ds, ucfirst($modelname));
            // this is because shapefiles only have one layer
            $content = $importer->getModel(0);

            if ($write):

                // write content to file.
                $handler = new FileHandler(
                    dirname(dirname(dirname($_SERVER['PHP_SELF']))),
                    ucfirst($modelname).".php"
                );

                $handler->write($content);
            else:
                $output->writeln($content);

                if ($input->getOption('mapping')):
                    $output->writeln("-- <fg=yellow>Mapping Info</>");
                    $output->writeln($importer->getMappingAssoc());
                endif;
        endif;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
    }
}
