<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ClassificationService;

class ImagePrediction extends Controller
{
    public $classification;

    public function __construct(ClassificationService $ClassificationService)
    {
        $this->classification = $ClassificationService;
    }
    /**
     * Display the page
     */
    public function classify()
    {
        return view('image_recognition');
    }

    /**
     * Classify the image with the onnx model
     */
    public function predict()
    {
        $response = [];

        $file_extension = request('image')->getClientOriginalExtension();
        $file_path = request('image');

        $response = $this->classification->predict($file_path, $file_extension);

        return view('image_classed', [
            "response" => $response
        ]);
    }
}
