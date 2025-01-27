<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Models\Services\StoreService;

class StorageController extends Controller
{
    protected $storeService;
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }
    public function store_list()
    {
        $stores = $this->storeService->getAll();
        return view('content.store.store-list', compact('stores'));
    }
    public function store_add()
    {
    }
    public function register_store(StoreRequest $storeRequest)
    {
        try {
            $store = $this->storeService->createStore($storeRequest->all());
            return redirect()->route('store-list')->with('success',SuccessMessages::CATEGORY_CREATED);
        } catch (Exception $e) {
            return redirect()->route('store-list')->with('error', ErrorMessages::USER_CREATION_ERROR);
        }
    }
    public function store_edit($id){

    }
    public function delete_store($id){
        dd($id);
    }

}
