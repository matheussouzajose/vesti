<?php

namespace Core\Application\UseCase\Product\Dto;

class CreateProductInputDto
{
    public function __construct(
        public string $companyId,
        public string $token,
        public array $data
    ) {
    }
}