<?php

namespace Core\Infrastructure\Http\FileGetContents;

use Core\Infrastructure\Http\Exceptions\FileGetContentsException;

class FileGetContents
{
    /**
     * @throws FileGetContentsException
     */
    public function get(string $filename): array
    {
        try {
            $jsonString = file_get_contents($filename);

            if (!$jsonString) throw FileGetContentsException::unableToRead($filename);

            $data = json_decode($jsonString, true);

            if (!$data) throw FileGetContentsException::failedToDecode();

            return $data;
        } catch (\Exception $e) {
            throw FileGetContentsException::error($e->getMessage());
        }
    }
}