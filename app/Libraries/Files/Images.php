<?php

namespace App\Libraries\Files;

use CodeIgniter\Files\File;

class Images
{
    private object $image;

    public function __construct()
    {
        $this->image = service('image', 'gd');
    }

    public function store(object $image, string $directory): string
    {
        if (!$image->hasMoved()) {
            $filePath = WRITEPATH . 'uploads/' . $image->store($directory);
        }

        $this->image->withFile($filePath)->fit(100, 100, 'center')->save($filePath);

        $filePathName = explode(DIRECTORY_SEPARATOR, $filePath);

        return end($filePathName);
    }

    public function remove(string $file, string $directory)
    {
        unlink(WRITEPATH . 'uploads/' . $directory . DIRECTORY_SEPARATOR . $file);
    }

    public function retrieve(string $image): array
    {
        $image = WRITEPATH . env('storage.root') . env('storage.product') . DIRECTORY_SEPARATOR . $image;

        $file = new File($image);

        return [
            'type' => $file->getMimeType(),
            'length' => $file->getSize(),
            'file' => $image
        ];
    }
}
