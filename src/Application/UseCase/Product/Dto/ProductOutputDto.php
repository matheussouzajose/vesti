<?php

namespace Core\Application\UseCase\Product\Dto;

class ProductOutputDto
{
    public function __construct(
        public array $result,
        public int $statusCode
    ) {
    }
}