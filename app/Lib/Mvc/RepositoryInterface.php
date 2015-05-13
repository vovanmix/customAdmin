<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

interface RepositoryInterface{

    public function findAll();

    public function getById($id);

    public function findBy($field, $value);

}