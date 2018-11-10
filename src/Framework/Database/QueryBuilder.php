<?php

namespace LPF\Framework\Database;

/**
 * Tiny QueryBuilder class
 * to help build MySQL queries
 */
class QueryBuilder
{
    protected $data = [];
    protected $query = "";
    protected $hasWhere = false;

    /**
     * Construct query builder
     *
     * @param string $query
     */
    public function __construct($query = "")
    {
        $this->query = trim($query);

        $this->query .= " ";
    }

    /**
     * Create query builder
     *
     * @param [type] $q
     * @return QueryBuilder
     */
    public static function create($q)
    {
        return new QueryBuilder($q);
    }

    /**
     * Select
     *
     * @param string $table
     * @param string $fields
     * @return QueryBuilder
     */
    public function select($table, $fields = '*')
    {
        return $this->appendQuery("SELECT $fields FROM $table");
    }

    /**
     * Create query builder and select all
     * fields from provided table
     *
     * @param string $t
     * @return QueryBuilder
     */
    public static function table($t, $fields = '*')
    {
        return new QueryBuilder("SELECT $fields FROM $t");
    }

    /**
     * Where clause
     *
     * @param string $column
     * @param string $comp
     * @param mixed $value
     * @return QueryBuilder
     */
    public function where($column, $comp, $value)
    {
        if ($this->hasWhere) {
            $c = $this->setData($column, $value);
            $this->appendQuery("AND $column $comp $c");
        } else {
            $c = $this->setData($column, $value);
            $this->appendQuery("WHERE $column $comp $c");
            $this->hasWhere = true;
        }

        return $this;
    }

    /**
     * Left join tables
     *
     * @param string $table
     * @param string $colA
     * @param string $colB
     * @return QueryBuilder
     */
    public function leftJoin($table, $colA, $colB)
    {
        return $this->appendQuery("LEFT JOIN $table ON $colA = $colB");
    }

    /**
     * Right join tables
     *
     * @param string $table
     * @param string $colA
     * @param string $colB
     * @return QueryBuilder
     */
    public function rightJoin($table, $colA, $colB)
    {
        return $this->appendQuery("LEFT JOIN $table ON $colA = $colB");
    }

    /**
     * Or where clause
     *
     * @param string $column
     * @param string $comp
     * @param mixed $value
     * @return QueryBuilder
     */
    public function orWhere($column, $comp, $value)
    {
        $c = $this->setData($column, $value);
        return $this->appendQuery("OR $column $comp $c");
    }

    /**
     * And where clause
     *
     * @param string $column
     * @param string $comp
     * @param mixed $value
     * @return QueryBuilder
     */
    public function andWhere($column, $comp, $value)
    {
        $c = $this->setData($column, $value);
        $this->appendQuery("AND $column $comp $c");
        return $this;
    }

    /**
     * Where is null clause
     *
     * @param string $column
     * @return QueryBuilder
     */
    public function whereNull($column)
    {
        if ($this->hasWhere) {
            return $this->appendQuery("AND $column IS NULL");
        } else {
            $r = $this->appendQuery("WHERE $column IS NULL");
            $this->hasWhere = true;
            return $r;
        }
    }

    /**
     * Or null clause
     *
     * @param string $column
     * @return QueryBuilder
     */
    public function orNull($column)
    {
        return $this->appendQuery("OR $column IS NULL");
    }

    /**
     * And null clause
     *
     * @param string $column
     * @return QueryBuilder
     */
    public function andNull($column)
    {
        return $this->appendQuery("AND $column IS NULL");
    }

    /**
     * Order by
     *
     * @param string $column
     * @param string $order
     * @return QueryBuilder
     */
    public function orderBy($columns, $order = 'ASC')
    {
        return $this->appendQuery("ORDER BY $columns $order");
    }

    /**
     * Group by
     *
     * @param string $columns
     * @return QueryBuilder
     */
    public function groupBy($columns)
    {
        return $this->appendQuery("GROUP BY $columns");
    }

    /**
     * Limit
     *
     * @param int $start
     * @param int $offset
     * @return QueryBuilder
     */
    public function limit($start, $offset)
    {
        return $this->appendQuery("LIMIT $start, $offset");
    }

    /**
     * Append string to query
     *
     * @param string $query
     * @return void
     */
    public function appendQuery($query = "")
    {
        $this->query .= $query . " ";
        return $this;
    }

    /**
     * Insert data to table
     *
     * @param string $table
     * @param array $data
     * @return QueryBuilder
     */
    public function insert($table, $data = [])
    {
        $keys = array_keys($data);
        $fieldsStr = implode(",", $keys);

        $values = [];
        foreach($data as $key => $value) {
            $values[] = $this->setData($key, $value);
        }
        $valuesStr = implode(",",$values);
        
        return $this->appendQuery("INSERT INTO $table ($fieldsStr) VALUES ($valuesStr)");
    }

    /**
     * DELETE where equal
     *
     * @param string $table
     * @param string $column
     * @param mixed $value
     * @return QueryBuilder
     */
    public function delete($table, $column, $value) 
    {
        $k = $this->setData($table . "_". $column, $value);
        return $this->appendQuery("DELETE FROM $table WHERE $column = $k");
    }

    /**
     * Set data for parameter
     *
     * @param string $column
     * @param string $value
     * @return string
     */
    public function setData($column, $value)
    {
        $k = str_replace(".", "_", $column);
        $this->data[$k] = $value;
        return ":" . $k;
    }

    /**
     * Returns query
     *
     * @return string
     */
    public function getQuery(): string
    {
        return trim($this->query);
    }

    /**
     * Returns data related to that query
     *
     * @param array $data
     * @return array
     */
    public function getQueryData($data = []): array
    {
        return array_merge($this->data, $data);
    }

    /**
     * Run query builder query
     *
     * @param DBConnectionInterface $connection
     * @return mixed
     */
    public function run(DBConnectionInterface $connection)
    {
        return $connection->runQuery($this->getQuery(), $this->getQueryData());
    }
}
