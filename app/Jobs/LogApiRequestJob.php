<?php

namespace App\Jobs;

use App\Models\ApiRequestLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogApiRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    protected $service;

    protected $requestBody;

    protected $httpStatusCode;

    protected $responseBody;

    protected $ipAddress;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $service, $requestBody, $httpStatusCode, $responseBody, $ipAddress)
    {
        $this->userId = $userId;
        $this->service = $service;
        $this->requestBody = $requestBody;
        $this->httpStatusCode = $httpStatusCode;
        $this->responseBody = $responseBody;
        $this->ipAddress = $ipAddress;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ApiRequestLog::create([
            'user_id' => $this->userId,
            'service' => $this->service,
            'request_body' => json_encode($this->requestBody),
            'http_status_code' => $this->httpStatusCode,
            'response_body' => json_encode($this->responseBody),
            'ip_address' => $this->ipAddress,
        ]);
    }
}
