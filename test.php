<?php

declare(strict_types=1);

use FpDbTest\AlekseySh\SQL\Constraints;
use FpDbTest\AlekseySh\SQL\QueryBuilder;
use FpDbTest\Database;
use FpDbTest\DatabaseTest;
use FpDbTest\QueryBulderAdapter;
use FpDbTest\AlekseySh\SQL\Specifier\Collection as SpecifierCollection;
use FpDbTest\AlekseySh\SQL\Specifier\Resolver\IntResolver;
use FpDbTest\AlekseySh\SQL\Specifier\Resolver\FloatResolver;
use FpDbTest\AlekseySh\SQL\Specifier\Resolver\ChoicesResolver;
use FpDbTest\AlekseySh\SQL\Specifier\Resolver\PrimaryKeyResolver;

if (!class_exists('mysqli')) {
    class mysqli {
        public $connect_errno;
        
        public function __construct(
            protected string $host,
            protected string $user,
            protected string $password,
            protected string $database,
            protected int $port = 3306
        ) {
        }
    }
}

spl_autoload_register(function ($class) {
    $a = array_slice(explode('\\', $class), 1);
    if (!$a) {
        throw new Exception();
    }
    $filename = implode('/', [__DIR__, ...$a]) . '.php';
    require_once $filename;
});

$mysqli = @new mysqli('localhost', 'root', 'password', 'database', 3306);
if ($mysqli->connect_errno) {
    throw new Exception($mysqli->connect_error);
}

$specifierCollection = new SpecifierCollection(
    '?',
    null,
    [
        'd' => new IntResolver(),
        'f' => new FloatResolver(),
        'a' => new ChoicesResolver(),
        '#' => new PrimaryKeyResolver(),
    ]
);


$queryBuilder = new QueryBulderAdapter(
    new QueryBuilder(
        $specifierCollection,
        new Constraints([
            1000000000000,
            'SELECT',
        ])
    )
);

$db = new Database($mysqli, $queryBuilder);

$test = new DatabaseTest($db);
$test->testBuildQuery();

exit('OK');
