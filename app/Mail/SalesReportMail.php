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
    use Queueable, SerializesModels;

    public $startDate;
    public $endDate;
    public $filePath;
    public $emailSubject;

    public function __construct($startDate, $endDate, $filePath, $emailSubject)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filePath = $filePath;
        $this->emailSubject = $emailSubject;
    }

    public function build()
    {
        return $this->view('content.reports.sendReport')
            ->subject($this->emailSubject) // Usamos la variable ya formateada
            ->attach($this->filePath, [
                'as' => 'reporte_ventas.csv',
                'mime' => 'text/csv',
            ]);
    }
}
