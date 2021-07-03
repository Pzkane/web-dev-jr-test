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
    private $order_by = array();
    private $limit_by = array();
    private $group_by = array();
    private $delete = false;

    private $prep_stmt;

    public function __toString(): string
    {
        $where = $this->conditions === [] ? '' : ' where ' . implode(' and ', $this->conditions);
        $order_by = $this->order_by === [] ? '' : ' order by ' . implode(' ', $this->order_by);
        $group_by = $this->group_by === [] ? '' : ' group by ' . implode(' ', $this->group_by);
        $limit = $this->limit_by === [] ? '' : ' limit ' . $this->limit_by[0] . (count($this->limit_by) > 1 ? ' offset ' . $this->limit_by[1] : '');

        if ($this->delete) // delete
        {
            if ($this->from === []) throw new Exception("QueryBuilder::DELETE::Table not specified.");
            
            $sql = 'delete from ' . $this->from[0]
                . $where;
            return $sql;
        }

        if (!empty($this->fields)) // select
        {
            $sql =  'select ' . implode(', ', $this->fields)
                . ' from ' . implode(', ', $this->from)
                . $where
                . $group_by
                . $order_by
                . $limit;
            // echo $sql;
            return $sql;
        }

        if (!empty($this->insert)) // insert
        {
            $sql = 'insert into ' . $this->insert
                . (!empty($this->insertCols) ? ' (' . implode(', ', $this->insertCols) . ')' : null)
                . ' values '. '('. implode(', ', $this->values) .')';
            return $sql;
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

    public function delete(): self
    {
        $this->delete = true;
        return $this;
    }

    public function values(string ...$values): self
    {
        foreach ($values as $value) {
            $this->values[] = $value;
        }
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
        if ($alias === null)
        {
            $this->from[] = $table;
        } else {
            $this->from[] = "${table} as ${alias}";
        }
        return $this;
    }

    public function orderBy(string $table, string $clause): self
    {
        array_push($this->order_by, $table);
        array_push($this->order_by, $clause);
        return $this;
    }

    public function limit(int $limit_by, ?int $offset): self
    {
        array_push($this->limit_by, $limit_by);

        if ($offset !== null)
        {
            array_push($this->limit_by, $offset);
        }
        return $this;
    }

    public function groupBy(string $column): self
    {
        array_push($this->group_by, $column);
        return $this;
    }
}
