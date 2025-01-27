<?php

namespace App\Models\Services;

use App\Http\Messages\ErrorMessages;
use App\Models\PurchaseNotes;
use App\Models\Repository\PurchaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }
    public function getAll()
    {
        return $this->purchaseRepository->all();
    }
    public function find($id)
    {
        return $this->purchaseRepository->find($id);
    }

    public function createpurchase($data)
    {
        // dd($data);
        return DB::transaction(function () use ($data) {
            $purchase = $this->purchaseRepository->create($data);
            return $purchase;
        });
    }

    public function deletepurchase($idpurchase)
    {
        return DB::transaction(function () use ($idpurchase) {
            $purchase = $this->purchaseRepository->find($idpurchase);
            if (!$purchase) {
                return ErrorMessages::PURCHASE_NOT_FOUND;
            }
            $purchase = $this->purchaseRepository->delete($purchase);
            return $purchase;
        });
    }
    public function updatepurchase($idpurchase, $data)
    {
        return DB::transaction(function () use ($idpurchase, $data) {
            $purchase = $this->purchaseRepository->find($idpurchase);
            if (!$purchase) return ErrorMessages::PURCHASE_NOT_FOUND;

            return $this->purchaseRepository->update($purchase,$data);
        });
    }
    public function countAllPurchaseNote()
    {
        return PurchaseNotes::count();
    }

    public function sumInversion(){
        return PurchaseNotes::sum('total_quantity');
    }



}
