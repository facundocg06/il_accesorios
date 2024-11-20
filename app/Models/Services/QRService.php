<?php

namespace App\Models\Services;

use App\Models\QRPayment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class QRService
{
    public function generateQr($sale)
    {
        try {

            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = 77049267; // Valor estático
            $lcNombreUsuario       = 'Diego Alexander TECNOWEB'; // Valor estático
            $lnCiNit               = 12570076; // Valor estático
            $lcNroPago             = "test-" . rand(100000, 999999);
            //$lnMontoClienteEmpresa = $sale->total_quantity; // Mantienes esta variable del request si es dinámica
            $lnMontoClienteEmpresa = 0.01; // Valor estático
            $lcCorreo              = 'diegorojasrios31@gmail.com'; // Valor estático
            $lcUrlCallBack         = "http://localhost:8000/";
            $lcUrlReturn           = "http://localhost:8000/";
            $laPedidoDetalle       = ''; // Mantienes esta variable del request si es dinámica
            $lcUrl                 = ""; // Debes especificar qué quieres hacer con esta variable estática

            $loClient = new Client();
            $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            $laHeader = [
                'Accept' => 'application/json'
            ];
            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];
            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);
            $laResult = json_decode($loResponse->getBody()->getContents());

            // Obtener el código de transacción
            $codTransaction = explode(";", $laResult->values)[0];

            // Obtener la imagen QR en base64
            $qrImage = explode(";", $laResult->values)[1];
            $laQrImage = "data:image/png;base64," . json_decode($qrImage)->qrImage;

            // Crear un registro en la tabla QRPayment
            QRPayment::create([
                'cod_transaction' => $codTransaction,
                'cod_qr' => $codTransaction,
                'qr_code' => $laQrImage,
                'sale_note_id' => $sale->id,
            ]);

            return $laQrImage;

            //echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
        } catch (\Throwable $th) {
            return $th->getMessage() . " - " . $th->getLine();
        }
    }


    // public function urlCallback(Request $request)
    // {
    //     $Venta = $request->input("PedidoID");
    //     $Fecha = $request->input("Fecha");
    //     $NuevaFecha = date("Y-m-d", strtotime($Fecha));
    //     $Hora = $request->input("Hora");
    //     $MetodoPago = $request->input("MetodoPago");
    //     $Estado = $request->input("Estado");
    //     $Ingreso = true;

    //     try {
    //         $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'Values' => true];
    //     } catch (\Throwable $th) {
    //         $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'Values' => false];
    //     }

    //     return response()->json($arreglo);
    // }
}
