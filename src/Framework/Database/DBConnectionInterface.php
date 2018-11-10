<?php

namespace LPF\Framework\Database;

interface DBConnectionInterface
{
    /**
     * Run DB Query and return results (assoc array)
     *
     * @param string $query
     * @param array $data
     * @return array|mixed
     */
    public function runQuery($query, $data = []); 
}
