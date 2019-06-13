<?php
namespace FasterPay\Services;

class GeneralService
{
    protected $httpService;

    public function __construct(HttpServiceInterface $httpService)
    {
        $this->httpService = $httpService;
    }

}