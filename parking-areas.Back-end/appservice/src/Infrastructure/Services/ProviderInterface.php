<?php
namespace App\Infrastructure\Services;

interface ProviderInterface
{
    public function getContent(array $criteria);
}