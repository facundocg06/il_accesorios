<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file',
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->getPathName();
            }
        }

        $result = $this->mailService->sendEmail(
            $request->to,
            $request->subject,
            $request->message,
            $attachments
        );

        if ($result) {
            return response()->json(['message' => 'Correo enviado correctamente.']);
        }

        return response()->json(['error' => 'Error al enviar el correo.'], 500);
    }
}
