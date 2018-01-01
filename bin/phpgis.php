<?php
/**
 * This file is part of the phpgis package.
 *
 * (c) Eddilbert Macharia (http://eddmash.com)<edd.cowan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Eddmash\PhpGis\PhpGis;

$connectionParams = [
    "db" => [
        'dbname' => 'tester',
        'user' => 'root',
        'password' => 'root1.',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
//        'driver' => 'pdo_pgsql',
    ],
];

$app = new PhpGis($connectionParams);
$app->consoleRunner();
