<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;

class ImageApiController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function upload(ImageRequest $request): \Illuminate\Http\JsonResponse
    {
        $uploadedImages = $this->imageService->saveImages($request->file('images'));
        return response()->json(['success' => 'Images uploaded successfully.', 'data' => $uploadedImages]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $image = $this->imageService->getImageById($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return response()->json($image);
    }
}
