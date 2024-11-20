<?php

namespace App\Models\Services;

use App\Models\Repository\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Repository\SaleRepositoryInterface;
use App\Models\Repository\StockSalesRepositoryInterface;

class SaleService
{
    protected $saleRepository;
    protected $customerRepository;
    protected $stockSaleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository,CustomerRepositoryInterface $customerRepositoryInterface,StockSalesRepositoryInterface $stockSaleRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->customerRepository = $customerRepositoryInterface;
        $this->stockSaleRepository = $stockSaleRepository;
    }

    public function getAll()
    {
        return $this->saleRepository->all();
    }

    public function registerSale($data)
    {
        return DB::transaction(function () use ($data) {
            // Generar datos para la venta y detalles de venta
            $customer = $this->customerRepository->findByCI($data['ci_customer']);
            if(!$customer){
                //Aqui vooy a registrar al customer
                $customer = $this->customerRepository->create([
                    'ci_customer' => $data['ci_customer'],
                    'name_customer' => $data['name_customer'],
                    'phone_customer' => $data['phone_customer']?:null,
                    'email_customer' => $data['email_customer']?:null,
                ]);
            }
            $saleData = $this->generateDataCreateSale($data);
            $salesNotesData = $saleData['salesNotes'];

            // Crear la venta (sales_notes)
            $sale = $this->saleRepository->createSale([
                'customer_id' => $customer->id,
                'sale_date' => $saleData['sale_date'],
                'total_quantity' => $saleData['total_quantity'],
                'sale_state' => $saleData['sale_state'],
                'payment_method' => $saleData['payment_method'],
            ]);

            // Asignar la venta creada a cada detalle de venta
            foreach ($salesNotesData as $salesNote) {
                $this->saleRepository->createSaleDetail([
                    'stock_sale_id' => $salesNote['stock_sale_id'],
                    'sale_note_id' => $sale->id,
                    'unitsale_price' => $salesNote['unitsale_price'],
                    'amount' => $salesNote['amount'],
                    'subtotal_price' => $salesNote['subtotal_price'],
                ]);
                //Despues de registrar aqui Descontar ese producto
                $this->stockSaleRepository->updateStock($salesNote['stock_sale_id'],$salesNote['amount']);
            }

            return $sale; // Devolver la venta creada
        });
    }

    public function generateDataCreateSale($data)
    {
        $salesNotes = [];

        foreach ($data['products'] as $product) {
            $salesNotes[] = [
                'stock_sale_id' => $product['variety_id'],
                'unitsale_price' => $product['price'],
                'amount' => $product['quantity'],
                'subtotal_price' => $product['price'] * $product['quantity'],
            ];
        }

        return [
            'sale_date' => now(),
            'total_quantity' => array_sum(array_column($salesNotes, 'subtotal_price')),
            'sale_state' => 'RESERVADA',
            'payment_method' => $data['payment_method'],
            'salesNotes' => $salesNotes,
        ];
    }
    public function confirmSale($id_sale){
        return DB::transaction(function () use ($id_sale) {
            $sale = $this->saleRepository->find($id_sale);
            $this->saleRepository->confirmSale($sale);
        });
    }
}
