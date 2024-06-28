<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
  public function all();

  public function add(array $data);

  public function update(array $data, $id);

  public function delete($id);

  public function find($id);

}