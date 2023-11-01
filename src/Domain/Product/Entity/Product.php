<?php

namespace Core\Domain\Product\Entity;

use Core\Domain\Product\Factory\ProductValidatorFactory;
use Core\Domain\Product\ObjectValues\ProductVariation;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;

class Product extends Entity
{
    /**
     * @param ProductVariation[] $variations
     * @throws NotificationException
     */
    public function __construct(
        protected int $reference,
        protected string $name,
        protected string $price,
        protected int $promotion,
        protected string $composition,
        protected string $brand,
        protected ?string $description = null,
        protected ?Uuid $id = null,
        protected ?array $variations = [],
    ) {
        parent::__construct();

        $this->id = $this->id ?? Uuid::random();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    protected function validation(): void
    {
        ProductValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw NotificationException::messages(
                messages: $this->notification->messages()
            );
        }
    }

    public function addVariation(ProductVariation $variation): void
    {
        $this->variations[] = $variation;
    }

    public function removeVariation(ProductVariation $variation): void
    {
        $this->variations = array_filter($this->variations, function ($item) use ($variation) {
            return $item->variation !== $variation->variation;
        });
    }
}