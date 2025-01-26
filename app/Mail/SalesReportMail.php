<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalesReportMail extends Mailable
{
    public $filePath;
    public $startDate;
    public $endDate;

    public function __construct($filePath, $startDate, $endDate)
    {
        $this->filePath = $filePath;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this->view('content.reports.sendReport')
            ->subject("Reporte de Ventas del {$this->startDate} al {$this->endDate}")
            ->attach($this->filePath, [
                'as' => 'reporte_ventas.csv',
                'mime' => 'text/csv',
            ]);
    }
}
