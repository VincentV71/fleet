<?php

declare(strict_types=1);

namespace Fulll\Infra\DatabaseRepository;

use AllowDynamicProperties;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Fulll\Domain\Exception\DatabaseConnectionException;

require_once __DIR__.'/../../../vendor/autoload.php';

#[AllowDynamicProperties]
class Database
{
    private static ?EntityManager $entityManager = null;

    private function __construct()
    {
        try {
            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__ . '/src/Infra/DatabaseEntity'],
                isDevMode: true
            );
            $connection = DriverManager::getConnection([
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../../../fleet.sqlite',
            ], $config);

            self::$entityManager = new EntityManager($connection, $config);

        } catch(\Throwable $e) {
            throw new DatabaseConnectionException(
                'Can not start database connection. Original message : '. $e->getMessage()
            );
        }
    }

    public static function getEntityManager(): EntityManager
    {
        if(!self::$entityManager) {
            new self();
        }

        return self::$entityManager;
    }
}