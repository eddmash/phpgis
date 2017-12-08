<?php
/**
 * This file is part of the ziamis package.
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
    ],
];

$app = new PhpGis($connectionParams);
$app->consoleRunner();

