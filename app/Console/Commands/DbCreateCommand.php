<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class DbCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create database if not exists';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = env('DB_DATABASE', false);
        $schema = env('DB_SCHEMA', 'public');
        $username = env('DB_USERNAME', 'homestead');

        if (!$database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return;
        }

        try {
            $pdo = $this->getPDOConnection();

            $isExist = $pdo->query(sprintf('SELECT 1 FROM pg_database WHERE datname = %s', $database));
            if ($isExist === false) {
                $pdo->exec(sprintf('CREATE DATABASE %s;', $database));
            }

            if (env('DB_CONNECTION') === 'pgsql') {
                unset($pdo);
                $pdo = $this->getPDOConnection($database);
                $pdo->exec(sprintf('CREATE SCHEMA %s;',$schema));
                $pdo->exec(sprintf('ALTER SCHEMA %s OWNER TO %s', $schema, $username));
            }

            $this->info(sprintf('Successfully created'));
        } catch (\PDOException $e) {
            $this->error(sprintf('Failed create with error: %s', $e->getMessage() . $e->getTraceAsString()));
        }
    }

    /**
     * @param string|null $database
     * @return PDO
     */
    private function getPDOConnection(?string $database = null)
    {
        $driver = env('DB_CONNECTION', 'pgsql');
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', 5432);
        $username = env('DB_USERNAME', 'homestead');
        $password = env('DB_PASSWORD', 'secret');

        $dsn = sprintf('%s:host=%s;port=%d;', $driver, $host, $port);
        if ($database) {
            $dsn .= sprintf('dbname=%s;', $database);
        }

        return new PDO($dsn, $username, $password);
    }
}
