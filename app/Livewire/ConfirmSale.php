<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class ConfirmSale extends Component
{
    public $sale;
    public $requestData;
    public $subtotal;
    public $discount = 0; // Ajusta esto según tus datos
    public $total;
    public $qrCode;

    public function mount($sale, $requestData)
    {
        $this->sale = unserialize(base64_decode($sale));
        $this->requestData = unserialize(base64_decode($requestData));
        $this->calculateTotals();
        if ($this->sale->payment_method === 'QR') {
            $this->qrCode = $this->sale->qrPayment->qr_code ?? null;
        }
    }

    public function consultarPago()
    {
        if ($this->sale->payment_method === 'QR') {
            $qr = $this->sale->qrPayment;
            $this->ConsultarEstadoQR($qr->cod_transaction);
        }
    }
    public function ConsultarEstadoQR($tnTransaccion)
    {
        $lnTransaccion = $tnTransaccion;

        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];
        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $lnTransaccion
        ];
        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);
        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());
        if ($laResultEstadoTransaccion->values->FechaPago !== null && $laResultEstadoTransaccion->values->HoraPago !== null) {
            // Notificar al usuario que el pago se realizó
            $this->dispatch('pagoRealizado', 'El pago se realizó el ' . $laResultEstadoTransaccion->values->FechaPago . ' a las ' . $laResultEstadoTransaccion->values->HoraPago);
            session()->flash('success', 'El QR ya Fue Pagado');
        } else {
            // Notificar al usuario que el pago aún no se ha realizado
            $this->dispatch('pagoNoRealizado', 'El pago aún no se ha realizado.');
            session()->flash('error', 'No se Pago el QR');
        }

        // $texto = '<h5 class="text-center mb-4">Estado Transacción: ' . $laResultEstadoTransaccion->values->messageEstado . '</h5><br>';
        //dd($laResultEstadoTransaccion, $loEstadoTransaccion->getStatusCode());
        return $laResultEstadoTransaccion;
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->requestData['products'])->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        $this->total = $this->subtotal - $this->discount;
    }

    public function render()
    {
        return view('livewire.confirm-sale');
    }
}
