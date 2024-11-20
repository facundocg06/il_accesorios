<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;


interface UserRepositoryInterface
{
    public function all();
    public function create($data);
    public function update($data,$user);
    public function delete($id);
    public function find($id);
    public function findWhere($column, $value);
    public function findByEmail($email);
    public function findByEmailWithTrashed($email);



}
