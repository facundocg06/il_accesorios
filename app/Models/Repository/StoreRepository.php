<?php

namespace App\Models\Repository;

use App\Models\Store;

class StoreRepository implements StoreRepositoryInterface
{
    public function all(){
        return Store::all();
    }
    public function create($data){
        return Store::create($data);
    }
    public function update($id, $data){
        return Store::find($id)->update($data);
    }
    public function delete($id){
        return Store::find($id)->delete();
    }
    public function find($id){
        return Store::find($id);
    }
}
