<?php
namespace FasterPay\Services;

interface HttpServiceInterface
{
    public function getHttpClient();
    public function getEndpoint();
}