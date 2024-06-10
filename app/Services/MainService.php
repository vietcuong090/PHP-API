<?php

namespace App\Services;

abstract class MainService implements CRUDInterface
{
    protected $_repository;

    /**
     * MainService constructor.
     */
    public function __construct()
    {
        $this->_repository = $this->setRepository();
    }

    /**
     * get model
     *
     * @return string
     */
    abstract public function getRepository();

    /**
     * Set model
     */
    public function setRepository()
    {
        return $this->_repository = app()->make(
            $this->getRepository()
        );
    }

    /**
     * Get All
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_repository->getAll();
    }

    /**
     * Get one
     *
     * @param  $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_repository->find($id);
        return $result;
    }

    /**
     * Create
     *
     * @param  array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_repository->create($attributes);
    }

    /**
     * Update
     *
     * @param  $id
     * @param  array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        return $this->_repository->update($id, $attributes);
    }

    /**
     * Delete
     *
     * @param  $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->_repository->delete($id);
    }

    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findFirstByField($field, $value)
    {
        return $this->_repository->findFirstByField($field, $value);
    }
}
