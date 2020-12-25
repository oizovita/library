<?php

namespace Core;

use Exception;

/**
 *
 * Class Model
 * @package Core
 */
class Model
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @var DB
     */
    private DB $db;
    /**
     * @var DB
     */
    private DB $baseSql;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = App::getInstance()->db;
    }

    /**
     * @return DB
     */
    public function query()
    {
        return $this->db;
    }

    /**
     * Delete entry by id
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function delete($id)
    {
        $this->db->delete($this->getTable())->where('id', $id)->exec();
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table ?? strtolower(basename(str_replace('\\', '/', get_class($this)))) . 's';
    }

    /**
     * Create new entry
     *
     * @param $fields
     * @return mixed
     * @throws Exception
     */
    public function create(array $fields)
    {
        $this->db->insert($this->getTable(), $fields)->exec();
        return $this->db->select($this->getTable(), ['*'])->where('id', $this->db->lastId())->first();
    }

    /**
     * Get one entry by id
     *
     * @param  array  $fields
     * @return Model
     * @throws Exception
     */
    public function where(array $fields)
    {
        $this->baseSql = $this->db->select($this->getTable(), ['*']);
        foreach ($fields as $field) {
            $this->baseSql->where($field[0], $field[1], $field[2] ?? '=');
        }

        return $this;
    }

    /**
     * Update entry by id
     *
     * @param $id
     * @param $fields
     * @return mixed
     * @throws Exception
     */
    public function update($id, array $fields)
    {
        $this->db->update($this->getTable(), $fields)->where('id', $id)->exec();
        return $this->db->select($this->getTable(), ['*'])->where('id', $id)->first();
    }

    /**
     * Get all entries
     *
     * @return array
     * @throws Exception
     */
    public function get()
    {
        return $this->db->select($this->getTable(), ['*'])->get();
    }
}