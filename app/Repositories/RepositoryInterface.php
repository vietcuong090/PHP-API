<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     *
     * @param  $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     *
     * @param  array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     *
     * @param  $id
     * @param  array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findFirstByField($field, $value);
}