<?php

namespace Core\Domain\Product\ObjectValues;

use Core\Domain\Product\Factory\ProductVariationValidatorFactory;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\Notification\Notification;

class ProductVariation
{
    public Notification $notification;

    /**
     * @throws NotificationException
     */
    public function __construct(
        public string $variation,
        public string $size,
        public string $color,
        public int $quantity,
        public string $unity,
        public int $order,
    ) {
        $this->notification = new Notification();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    protected function validation(): void
    {
        ProductVariationValidatorFactory::create()->validate($this);

        if ( $this->notification->hasErrors() ) {
            throw NotificationException::messages(
                messages: $this->notification->messages()
            );
        }
    }
}