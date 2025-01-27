<?php

namespace App\Models\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Messages\ErrorMessages;
use App\Models\Repository\SupplierRepositoryInterface;
use App\Models\Supplier;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAll()
    {
        return $this->supplierRepository->all();
    }
    public function find($id)
    {
        return $this->supplierRepository->find($id);
    }
    public function createSupplier(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->supplierRepository->create($data);
        });
    }

    public function deleteSupplier($idsupplier)
    {
        return DB::transaction(function () use ($idsupplier) {
            $supplier = $this->supplierRepository->find($idsupplier);
            if (!$supplier) {
                return ErrorMessages::SUPPLIER_NOT_FOUND;
            }
            $supplier = $this->supplierRepository->delete($supplier);
            return $supplier;
        });
    }
    public function updateSupplier($idsupplier, $data)
    {
        return DB::transaction(function () use ($idsupplier, $data) {
            $supplier = $this->supplierRepository->find($idsupplier);
            if (!$supplier) return ErrorMessages::SUPPLIER_NOT_FOUND;

            return $this->supplierRepository->update($supplier,$data);
        });
    }

    public function countAllSuppliers()
    {
        return Supplier::count();
    }
}
