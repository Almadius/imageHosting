<?php

namespace App\Http\Services;

use App\Contracts\ImageRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected ImageRepositoryInterface $imageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function saveImages(array $images): array
    {
        $uploadedImages = [];
        foreach ($images as $image) {
            $uploadedImages[] = $this->saveImage($image);
        }
        return $uploadedImages;
    }

    protected function saveImage(UploadedFile $image): \App\Models\Image
    {
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $normalized_name = Str::slug($originalName);
        $extension = $image->getClientOriginalExtension();
        $fileName = $this->generateUniqueFileName($normalized_name, $extension);

        $image->storeAs('images', $fileName, 'public');

        return $this->imageRepository->save(['name' => $fileName]);
    }

    protected function generateUniqueFileName($name, $extension, $counter = 0): string
    {
        $newName = $name . ($counter ? "_{$counter}" : '') . '.' . $extension;
        if (Storage::disk('public')->exists('images/' . $newName)) {
            return $this->generateUniqueFileName($name, $extension, ++$counter);
        }
        return $newName;
    }

    public function getAllImages($sortBy = 'name', $direction = 'asc'): \Illuminate\Support\Collection
    {
        return $this->imageRepository->findAll($sortBy, $direction);
    }

    public function getImageById(int $id): ?\App\Models\Image
    {
        return $this->imageRepository->findById($id);
    }

    public function getImagesByIds(array $ids): \Illuminate\Support\Collection
    {
        return $this->imageRepository->findManyByIds($ids);
    }

    public function createZipFromImagesByIds(array $ids): string
    {
        $images = $this->getImagesByIds($ids);
        $zip = new \ZipArchive();
        $zipFileName = 'images_' . time() . '.zip';
        $zipFilePath = Storage::path($zipFileName);

        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            foreach ($images as $image) {
                $filePath = Storage::disk('public')->path('images/' . $image->name);
                if (File::exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();
        } else {
            throw new \Exception("Cannot create zip file.");
        }
        return $zipFilePath;
    }
}

