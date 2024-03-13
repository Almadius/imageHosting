<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageWebController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $images = $this->imageService->getAllImages();
        return view('images.index', compact('images'));
    }

    public function download($id)
    {
        $image = $this->imageService->getImageById($id);

        if (!$image) {
            return redirect()->back()->withErrors(['error' => 'Image not found.']);
        }

        $filePath = public_path('images/' . $image->name);

        if (File::exists($filePath)) {
            return response()->download($filePath, $image->name);
        } else {
            return redirect()->back()->withErrors(['error' => 'File not found.']);
        }
    }


    public function downloadMultiple(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['error' => 'No images specified.'], 400);
        }

        try {
            $zipFilePath = $this->imageService->createZipFromImagesByIds($ids);
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function upload(ImageRequest $request)
    {
        $uploadedImages = $this->imageService->saveImages($request->file('images'));

        return redirect('/images')->with('success', 'Images uploaded successfully.');
    }
}

