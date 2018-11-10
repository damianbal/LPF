<?php

namespace LPF\Framework\Database;

/**
 * PDO Driver for DBConnectionInterface
 */
class PDOConnection implements DBConnectionInterface
{
    /**
     * Construct PDO Connection
     *
     *
     * @param array $conn
     */
    public function __construct($conn)
    {
        try {
            $this->pdo = new \PDO(
                "mysql:host=" . $conn['host'] . ";dbname=" . $conn['dbname'] . ";port=" . $conn['port'],
                $conn['user'],
                $conn['pass']
            );

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            print "Error PDO: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Run query and return results (assoc array)
     *
     * @param string $query
     * @param array $data
     * @return array|mixed
     */
    public function runQuery($query, $data = [])
    {
        $stmt = $this->createQuery($query);

        $stmt->execute($data);

        return $stmt->fetchAll();
    }

    /**
     * Creates PDO statement
     *
     * @param string $query
     * @return \PDOStatement
     */
    private function createQuery($query)
    {
        return $this->pdo->prepare($query);
    }
}
