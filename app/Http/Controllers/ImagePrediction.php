<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ClassificationService;
use App\Models\Classification;

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
    public function predict(Request $request)
    {
        $response = [];

        if(empty(request('image'))){
            return view('image_recognition', [
                "error" => "You must upload a file"
            ]);
        }

        $file_extension = request('image')->getClientOriginalExtension();
        $file_path = request('image');

        $response = $this->classification->predict($file_path, $file_extension);

        $this->store($request);

        return view('image_classed', [
            "response" => $response
        ]);
    }

    /**
     * store the image in the batabase
     */
    public function store(Request $request)
    {
        $image = $request->file('image');

        $request->validate([
            'image' => 'mimes:jpg,jpeg,zip'
        ]);

        if($image->getClientOriginalExtension() == "zip"){

            // Get the folder of the unzipped files
            $folder_path = "../public/storage/images/zip";
            // List of name of files inside specified folder
            $folder = glob($folder_path.'/*');
            $files = glob($folder[0].'/*');

            $i = 0;
            foreach($files as $file) {
                if(is_file($file)){
                    $extention = pathinfo($file, PATHINFO_EXTENSION);
                    $filename = time().$i.'.'.$extention;
                    $path = 'storage/uploaded_images/';

                    copy($file, $path.$filename);

                    Classification::create([
                        'image' => $path.$filename,
                        'user_id' => auth()->user()->id
                    ]);

                    // Delete the given file
                    unlink($file);
                }
                $i += 1;
            }

            rmdir($folder[0]);

        } else {
            if($request->has('image')){
                $extention = $image->getClientOriginalExtension();
                $filename = time().'.'.$extention;
                $path = 'storage/uploaded_images/';

                $image->move(public_path($path), $filename);
            }

            Classification::create([
                'image' => $path.$filename,
                'user_id' => auth()->user()->id
            ]);
        }
    }
    /**
     * show the images uploaded by the user
     */
    public function show(Request $request)
    {
        $images = Classification::get();

        return view('history', compact('images'));
    }
}
