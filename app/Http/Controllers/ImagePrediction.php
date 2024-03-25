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
        $response = [
            'text' => "",
            'class' => []
        ];

        $file_extension = request('image')->getClientOriginalExtension();
        $file_path = request('image');

        if($file_extension == "jpeg" || $file_extension == "jpg"){

            $response = $this->predict_jpg($file_path);

            return view('image_classed', [
                "response" => $response['text'],
                "class" => $response['class']
            ]);

        } else {
            $response['text'] = "You have uploaded a " . $file_extension . " file. Please upload a jpeg or jpg file.";

            return view('image_classed', [
                "response" => $response['text']
            ]);
        }
    }

    /**
     * Classify a jpg or jpeg image
     */
    private function predict_jpg($img_path)
    {
        $response = [
            'text' => "",
            'class' => []
        ];

        // resize image
        $img = $this->resize_image($img_path, 224, 224, "jpg");

        // make a pixel array from the image
        $pixels = $this->get_pixels($img);

        // get the class for the image
        $response = $this->run_onnx($pixels);

        return $response;
    }

    /**
     * Make an array of pixels from an image
     */
    private function get_pixels($img)
    {
        // make a pixel array from the image
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

        return $float_pixels;
    }

    /**
     * Run the onnx model "efficientnet" to classify a pixel array
     */
    private function run_onnx($pixel_array)
    {
        $response = [
            'text' => "",
            'class' => []
        ];

        // get the onnx model
        $model = new \OnnxRuntime\Model(Storage::path('/public/onnx-models/efficientnet-lite4-11-qdq.onnx'));

        // run the onnx model with the pixel array in parameter
        $model_response = $model->predict(['images:0' => [$pixel_array]]);
        $results = $model_response["Softmax:0"];

        // sort the results to get the 3 most likely

        // load the json file with the responses
        $json_data = file_get_contents(Storage::path('/public/onnx-models/labels_map.json'));

        // convert the json string to a php array
        $labels = json_decode($json_data, true);

        // check if the array is filled
        if ($labels === null) {
            $response['text'] = "An error occured when we try to decode the answers</br>";
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
                $response['text'] = "No class found for index : " . $r . "</br>";
            }
            $i++;
        }

        // set the answer array with the 3 classes of the pictures
        $response['class'] = $class;

        return $response;
    }

    /**
     * Resize an image
     */
    private function resize_image($img_path, int $size_x, int $size_y, string $param)
    {
        $img = "";
        switch($param){
            case "jpg":
                $default_img = imagecreatefromjpeg($img_path); //get the image
                list($width, $height) = getimagesize($img_path);

                $img = imagecreatetruecolor($size_x, $size_y);
                imagecopyresampled($img, $default_img, 0, 0, 0, 0, $size_x, $size_y, $width, $height);

                $this->destroy($default_img);

                break;
            case "png":
                break;
            default:
                break;
        }

        return $img;
    }

    /**
     * Remove the specified resource from storage.
     */
    private function destroy($img)
    {
        imagedestroy($img);
    }
}
