<?php

namespace App\Contracts;

use App\Models\Image;
use Illuminate\Support\Collection;

interface ImageRepositoryInterface
{
    public function save(array $imageData): Image;
    public function findById(int $id): ?Image;
    public function findAll($sortBy = 'name', $direction = 'asc'): Collection;
    public function findManyByIds(array $ids): Collection;
}
