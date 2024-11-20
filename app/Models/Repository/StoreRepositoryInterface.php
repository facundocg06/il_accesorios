<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface StoreRepositoryInterface
{
    public function all();
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function find($id);
}
