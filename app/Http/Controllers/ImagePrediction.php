<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagePrediction extends Controller
{
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
        $response_text = "salut";

        // resize image
        $filename = request('image');
        $default_img = imagecreatefromjpeg($filename); //get the image
        list($width, $height) = getimagesize(request('image'));

        $newwidth = 224;
        $newheight = 224;

        $img = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($img, $default_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $this->destroy($default_img);

        // imagejpeg($destination, Storage::path('public/images/test.jpeg'), 100);

        // make a pixek array from the image
        $pixels = [];
        $width = imagesx($img);
        $height = imagesy($img);

        for ($y = 0; $y < $height; $y++) {
            $row = [];
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $color = imagecolorsforindex($img, $rgb);
                $row[] = [$color['red'], $color['green'], $color['blue']];
            }
            $pixels[] = $row;
        }

        // convert the pixel rgb array (0 - 255) to float (-1.0 to 1.0)
        $float_pixels = [];
        foreach ($pixels as $row) {
            $float_row = [];
            foreach ($row as $pixel) {
                $float_row[] = [($pixel[0] / 127.5) - 1.0, ($pixel[1] / 127.5)- 1.0, ($pixel[2] / 127.5) - 1.0];
            }
            $float_pixels[] = $float_row;
        }

        // get the onnx model
        $model = new \OnnxRuntime\Model(Storage::path('/public/onnx-models/efficientnet-lite4-11-qdq.onnx'));

        // run the onnx model with the pixel array in parameter
        $response = $model->predict(['images:0' => [$float_pixels]]);
        $results = $response["Softmax:0"];

        // sort the results to get the 3 most likely

        // load the json file with the responses
        $json_data = file_get_contents(Storage::path('/public/onnx-models/labels_map.json'));

        // convert the json string to a php array
        $labels = json_decode($json_data, true);

        // check if the array is filled
        if ($labels === null) {
            $response_text = "An error occured when we try to decode the answers</br>";
            exit(1);
        }

        // copy the array so the original one is not changed
        $sorted_array = $results[0];

        // sort array by descending numbre
        arsort($sorted_array);

        // get the 3 first index
        $top_indices = array_slice(array_keys($sorted_array), 0, 3);

        $i = 0;
        $class = [];
        // get trough the 5 top index
        foreach ($top_indices as $r) {
            // chek on the label map which picture is it
            if (array_key_exists(strval($r), $labels)) {
                // show what the picture is
                $class[$i] = "-> " . $labels[strval($r)]  ;
            } else {
                $response_text = "No class found for index : " . $r . "</br>";
            }
            $i++;
        }

        return view('image_classed', [
            "response" => $response_text,
            "class" => $class
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    private function destroy($img)
    {
        imagedestroy($img);
    }
}
