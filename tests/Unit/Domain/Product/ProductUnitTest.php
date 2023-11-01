<?php

namespace Tests\Unit\Domain\Product;

use Core\Domain\Product\Entity\Product;
use Core\Domain\Product\ObjectValues\ProductVariation;
use Core\Domain\Product\Validator\ProductValidator;
use Core\Domain\Shared\Exception\NotificationException;
use PHPUnit\Framework\TestCase;

class ProductUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_throw_error_when_property_is_empty()
    {
        $this->expectExceptionObject(NotificationException::messages(ProductValidator::CONTEXT));

        new Product(
            reference: -1,
            name: '',
            price: '',
            promotion: -2,
            composition: '',
            brand: '',
            description: '',
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_new_product_success()
    {
        $product = new Product(
            reference: 1761196,
            name: 'SHORT CURTO',
            price: '109,90',
            promotion: 86,
            composition: '100% Algodão',
            brand: 'Joana Modas',
            description: 'Short Curto',
        );

        $this->assertNotEmpty($product->id());
        $this->assertEquals(1761196, $product->reference);
        $this->assertEquals('SHORT CURTO', $product->name);
        $this->assertEquals('109,90', $product->price);
        $this->assertEquals(86, $product->promotion);
        $this->assertEquals('100% Algodão', $product->composition);
        $this->assertEquals('Joana Modas', $product->brand);
        $this->assertEquals('Short Curto', $product->description);
    }

    /**
     * @throws NotificationException
     */
    public function test_add_variation()
    {
        $product = new Product(
            reference: 1761196,
            name: 'SHORT CURTO',
            price: '109,90',
            promotion: 86,
            composition: '100% Algodão',
            brand: 'Joana Modas',
            description: 'Short Curto',
        );

        $variation40 = new ProductVariation(
            variation: '1761196_40_CLARA',
            size: '40',
            color: 'CLARA',
            quantity: 6,
            unity: 'UN',
            order: 3
        );

        $variation42 = new ProductVariation(
            variation: '1761196_42_CLARA',
            size: '42',
            color: 'CLARA',
            quantity: 5,
            unity: 'UN',
            order: 4
        );

        $variation48 = new ProductVariation(
            variation: '1761196_48_CLARA',
            size: '48',
            color: 'CLARA',
            quantity: 0,
            unity: 'UN',
            order: 7
        );

        $product->addVariation(variation: $variation40);
        $product->addVariation(variation: $variation42);
        $product->addVariation(variation: $variation48);

        $this->assertCount(3, $product->variations);

        $product->removeVariation(variation: $variation42);

        $this->assertCount(2, $product->variations);
    }
}