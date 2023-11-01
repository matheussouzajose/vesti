<?php

namespace Core\Application\UseCase\Product;

use Core\Application\UseCase\Product\Dto\ProductOutputDto;
use Core\Domain\Product\Entity\Product;
use Core\Domain\Product\ObjectValues\ProductVariation;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Infrastructure\Http\Exceptions\FileGetContentsException;
use Core\Infrastructure\Http\FileGetContents\FileGetContents;

class ListProductsUseCase
{
    protected string $urlVariations = __DIR__ . '/../../../../ERP/Api/variacoes.json';
    protected string $urlProducts = __DIR__ . '/../../../../ERP/Api/produtos.json';

    public function __construct(
        protected FileGetContents $fileGetContents,
    ) {
    }

    /**
     * @throws NotificationException|FileGetContentsException
     */
    public function __invoke(): ProductOutputDto
    {
        $variations = $this->getVariations();
        $products = $this->getProducts($variations);

        return $this->output($products, 200);
    }

    /**
     * @throws NotificationException|FileGetContentsException
     */
    private function getProducts(array $variations): array
    {
        $products = $this->fileGetContents->get(filename: $this->urlProducts);
        $iterator = new \ArrayIterator($products);
        $data = [];

        while ($iterator->valid()) {
            $current = $iterator->current();
            $product = new Product(
                reference: $current['referencia'],
                name: $current['nome'],
                price: $current['preco'],
                promotion: $current['promocao'],
                composition: $current['composicao'],
                brand: $current['marca'],
                description: $current['descricao']
            );

            if ( isset($variations[$current['referencia']]) ) {
                foreach ($variations[$current['referencia']] as $variation) {
                    $product->addVariation(
                        new ProductVariation(
                            variation: $variation['variacao'],
                            size: $variation['tamanho'],
                            color: $variation['cor'],
                            quantity: $variation['quantidade'],
                            unity: $variation['unidade'],
                            order: $variation['ordem']
                        )
                    );
                }
            }
            $data[] = $product;
            $iterator->next();
        }

        return $data;
    }

    private function getVariations(): array
    {
        $variations = $this->fileGetContents->get(filename: $this->urlVariations);
        $iterator = new \ArrayIterator($variations);
        $variationsIndexed = [];
        while ($iterator->valid()) {
            $variation = strstr($iterator->current()['variacao'], '_', true);
            $variationsIndexed[$variation][] = $iterator->current();
            $iterator->next();
        }

        return $variationsIndexed;
    }

    private function output(array $data, int $statusCode): ProductOutputDto
    {
        return new ProductOutputDto(
            result: $data,
            statusCode: $statusCode
        );
    }
}