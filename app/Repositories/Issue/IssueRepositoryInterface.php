<?php

namespace App\Repositories\Issue;

interface IssueRepositoryInterface
{
    public function getAll();

    public function findOrFail($id);

    public function get($params, $lang);

    public function findBy($field, $values);
}
