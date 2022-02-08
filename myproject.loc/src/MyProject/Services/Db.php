<?php
namespace MyProject\Services;

use MyProject\Exceptions\DbException;

class Db
{
    static private $instance;
    private $pdo;

    /**
     * Undocumented function
     */
    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];
    
        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); 
            $this->pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
        } catch (\Exception $e) {
            throw new DbException($e);
        } 
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

     /**
      * Undocumented function
      *
      * @param string $sql
      * @param array $params
      * @param string $className
      * @return array|null
      */
     public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
     {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        
        if ($result === false) {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
     }

     /**
      * Undocumented function
      *
      * @return integer
      */
    public function getLastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
}