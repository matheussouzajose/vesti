<?php

namespace Core\Application\Interfaces;

interface HttpIntegrationInterface
{
    public function get(string $url, array $options = []): array;
    public function post(string $url, array $data, array $options = []): array;
}