<?php

namespace Core\Domain\Product\Validator;

use Core\Domain\Shared\Validation\ValidatorInterface;
use Rakit\Validation\Validator;

class ProductValidator implements ValidatorInterface
{
    public const CONTEXT = 'product';

    public function validate(object $object): void
    {
        $data = $this->convertEntityForArray($object);

        $validation = (new Validator())->validate($data, [
            'reference' => 'numeric|min:0',
            'name' => 'required',
            'price' => 'required',
            'promotion' => 'required|min:0',
            'composition' => 'required',
            'brand' => 'required',
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
            'reference' => $object->reference,
            'name' => $object->name,
            'price' => $object->price,
            'promotion' => $object->promotion,
            'composition' => $object->composition,
            'brand' => $object->brand,
        ];
    }
}