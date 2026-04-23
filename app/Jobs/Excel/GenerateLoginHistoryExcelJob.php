<?php

namespace App\Jobs\Excel;

use App\Mail\Excel\ExcelIsReadyMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GenerateLoginHistoryExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $filePath; 

    public function __construct($email, $filePath)
    {
        $this->email = $email;
        $this->filePath = $filePath;
    }

    public function handle(): void
    {
        if (Storage::disk('public')->exists($this->filePath)) {

            try {

                Mail::to($this->email)->send(new ExcelIsReadyMail($this->filePath));

            } catch (\Throwable $th) {

                Log::info('Email for excel is ready not sent'. $th->getMessage());

            }

        } else {
           
        }
    }
}
