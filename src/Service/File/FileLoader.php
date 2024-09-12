<?php

namespace App\Service\File;

class FileLoader
{
    public function loadFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return [];
        }
        $data = [];
        $file = new \SplFileObject($filePath);

        while (!$file->eof()) {
            $data[] = json_decode(trim($file->fgets()), true);
        }
        return $data;
    }
}
