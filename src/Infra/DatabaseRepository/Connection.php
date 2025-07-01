<?php

declare(strict_types=1);

namespace Fulll\Infra\DatabaseRepository;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__.'/../../../vendor/autoload.php';

class Connection
{
    protected EntityManager $entityManager;
    public function __construct()
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/src/Infra/DatabaseEntity'],
            isDevMode: true
        );
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../../../fleet.sqlite',
        ], $config);

        $this->entityManager = new EntityManager($connection, $config);
    }
}