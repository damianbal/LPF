<?php

namespace LPF\Framework\Database;

class Paginator
{
    /** @var DBConnectionInterface */
    protected $connection = null;
    protected $query = "";
    protected $pages = 0;
    protected $results_num = 0;
    protected $results = [];

    /**
     * Construct Paginator
     *
     * @param DBConnectionInterface $conn
     * @param string $query
     */
    public function __construct(DBConnectionInterface $conn, $query)
    {
        $this->connection = $conn;
        $this->query = $query;
    }

    /**
     * Returns total number of pages for query
     *
     * @return int
     */
    public function getNumPages()
    {
        return $this->pages;
    }

    /**
     * Returns number of total results
     *
     * @return int
     */
    public function getNumResults()
    {
        return $this->results_num;
    }

    /**
     * Returns fetched results
     *
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Fetch results
     *
     * @param integer $page
     * @param integer $perPage
     * @param array $data
     * @return array|mixed
     */
    public function fetchResults($page = 0, $perPage = 10, $data = [])
    {
        $this->results_num = count($this->connection->runQuery($this->query, $data));
        $this->pages = ceil($this->results_num / $perPage);

        $merged_data = array_merge($data, ['s' => (int) $page * (int) $perPage, 'o' => (int) $perPage]);

        $new_query = $this->query . " LIMIT :s, :o";

        $this->results = $this->connection->runQuery($new_query, $merged_data);
    }
}
