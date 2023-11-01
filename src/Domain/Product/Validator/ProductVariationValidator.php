<?php

namespace Core\Domain\Product\Validator;

use Core\Domain\Shared\Validation\ValidatorInterface;
use Rakit\Validation\Validator;

class ProductVariationValidator implements ValidatorInterface
{
    public const CONTEXT = 'product-variation';

    public function validate(object $object): void
    {
        $data = $this->convertEntityForArray($object);

        $validation = (new Validator())->validate($data, [
            'variation' => 'required',
            'size' => 'required',
            'color' => 'required',
            'quantity' => 'required|min:0',
            'unity' => 'required',
            'order' => 'required|min:0',
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $object->notification->addError([
                    'context' => self::CONTEXT,
                    'message' => $error,
                ]);
            }
        }
    }

    private function convertEntityForArray(object $object): array
    {
        return [
            'variation' => $object->variation,
            'size' => $object->size,
            'color' => $object->color,
            'quantity' => $object->quantity,
            'unity' => $object->unity,
            'order' => $object->order,
        ];
    }
}