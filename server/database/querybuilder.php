<?php

class QueryBuilder
{
    private $fields = array();
    private $columns = array();
    private $conditions = array();
    private $insert = array();
    private $insertCols = array();
    private $values = array();
    private $from = array();

    private $prep_stmt;

    public function __toString(): string
    {
        $where = $this->conditions === [] ? '' : ' where ' . implode(' and ', $this->conditions);

        if (!empty($this->fields))
        {
            return 'select ' . implode(', ', $this->fields)
                . ' from ' . implode(', ', $this->from)
                . $where;
        }

        if (!empty($this->insert))
        {
            return 'insert into ' . $this->insert
                . (!empty($this->insertCols) ? ' (' . implode(', ', $this->insertCols) . ')' : null)
                . ' values '. '('. implode(', ', $this->values) .')';
        }
    }

    public function prepare(object $connection, bool $need_binding = true): object
    {
        $this->prep_stmt = $connection->prepare($this->__toString());
        return $need_binding ? $this : $this->prep_stmt;
    }

    public function bind(string $types, string ...$values): object
    {
        if ($this->prep_stmt)
        {
            $this->prep_stmt->bind_param($types, ...$values);
            return $this->prep_stmt;
        } else {
            throw new Exception("QueryBuilder::Statement not prepared.");
        }
    }

    public function select(string ...$fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function insert(string $table, ?string ...$columns): self
    {
        $this->insert = $table;

        foreach ($columns as $column) {
            $this->insertCols[] = $column;
        }

        return $this;
    }

    public function values(string ...$values): self
    {
        $this->values = $values;
        return $this;
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
        if ($alias === null) {
            $this->from[] = $table;
        } else {
            $this->from[] = "${table} as ${alias}";
        }
        return $this;
    }
}
