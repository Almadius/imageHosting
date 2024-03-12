<?php

namespace App\Repositories;

use App\Contracts\ImageRepositoryInterface;
use App\Models\Image;
use Illuminate\Support\Collection;

class EloquentImageRepository implements ImageRepositoryInterface
{
    public function save(array $imageData): Image
    {
        return Image::create($imageData);
    }

    public function findById(int $id): ?Image
    {
        return Image::find($id);
    }

    public function findAll($sortBy = 'name', $direction = 'asc'): Collection
    {
        return Image::orderBy($sortBy, $direction)->get();
    }

    public function findManyByIds(array $ids): Collection
    {
        return Image::findMany($ids);
    }
}
