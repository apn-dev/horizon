<?php

namespace Core\Database;

interface DatabaseInterface
{
    /**
     * @param string $table
     * @return mixed
     */
    public function getTable(string $table);

    /**
     * @param mixed $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function findBy(array $parameters);
}
