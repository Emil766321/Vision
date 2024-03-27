<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ClassificationService
{
    /**
     * Classify the image with the onnx model
     */
    public function predict($file_path, $file_extension)
    {
        $response = [];

        switch($file_extension){
            case 'jpg':
            case 'jpeg':
                $response = $this->predict_jpg($file_path);

                return $response;

            case 'zip':
                // predict all the images of a zip folder
                $response = $this->predict_zip($file_path);

                return $response;

            default:
                $response[0]['text'] = "You have uploaded a " . $file_extension . " file. Please upload a jpeg or jpg file.";

                return $response;
        }
    }

    /**
     * Classify a jpg or jpeg image
     */
    private function predict_jpg($img_path)
    {
        $response = [];

        // resize image
        $img = $this->resize_image($img_path, 224, 224, "jpg");

        // make a pixel array from the image
        $pixels = $this->get_pixels($img);

        // get the class for the image
        $response[0] = $this->run_onnx($pixels);

        return $response;
    }

    /**
     * Classify all pictures in a zip folder
     */
    private function predict_zip($zip_path)
    {
        $response = [];

        $files = $this->unzip($zip_path);

        $response[0]['text'] = $files;

        for ($i = 0; $i < count($files); $i++) {
            if($i != 0){
                // resize image
                $img = $this->resize_image($files[$i]['path'], 224, 224, $files[$i]['type']);

                if($img != ""){
                    // make a pixel array from the image
                    $pixels = $this->get_pixels($img);

                    // get the class for the image
                    $response[$i] = $this->run_onnx($pixels);
                } else {
                    $response[$i]['class'] = [];
                    $response[$i]['text'] = "This image is not supported by the onnx model";
                }
            } else {
                $response[$i]['text'] = '';
                $response[$i]['class'] = [];
            }
        }

        // remove the files & the directory created when we unzipped the folder
        for ($i=0; $i < count($files); $i++) {
            if($i != 0){
                unlink($files[$i]['path']);
            }
        }
        rmdir($files[0]['path']);

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

        // sort array by descending number
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
     * Unzip a folder
     */
    private function unzip($path)
    {
        $files = [];

        $zip = new \ZipArchive;
        if ($zip->open($path) === true) {
            for($i = 0; $i < $zip->numFiles; $i++) {
                $files[$i]['name'] = $zip->getNameIndex($i);
                $files[$i]['info'] = pathinfo($files[$i]['name']);
            }
            $zip->extractTo('../public/storage/images/zip');
            $zip->close();
        }

        for ($i=0; $i < count($files); $i++) {
            if($i == 0){
                $files[$i]['path'] = "../public/storage/images/zip/" . $files[$i]['info']['basename'];
            } else {
                $files[$i]['path'] = "../public/storage/images/zip/" . $files[$i]['name'];
                switch($files[$i]['info']['extension']){
                    case 'jpeg':
                    case 'jpg':
                        $files[$i]['type'] = "jpg";
                        break;
                    default:
                        $files[$i]['type'] = $files[$i]['info']['extension'];
                        break;
                }
            }
        }

        // set an array that will contain the files usable
        $usefull_files = [];

        // set an array with the files that needs to be deleted
        $useless_files = [];

        // set the index for the usefull_files array
        $index_usefull_files = 0;

        // set the index for the useless_files array
        $index_useless_files = 0;

        for ($i=0; $i < count($files); $i++) {
            //if this is the parent folder, copy it
            if($i==0){
                $usefull_files[$index_usefull_files] = $files[$i];
                $index_usefull_files++;
            } else {
                // set the string for the dir to delete
                $exclude_dir = "__MACOSX/".$files[0]['info']['basename'];

                // check if the file is not from the __MACOSX folder
                if($files[$i]['info']['dirname'] != $exclude_dir){
                    // check if the file are only jpg or jpeg
                    if($files[$i]['info']['extension'] == "jpg" || $files[$i]['info']['extension'] == "jpeg"){
                        $usefull_files[$index_usefull_files] = $files[$i];
                        $index_usefull_files++;
                    } else {
                        $useless_files[$index_useless_files] = $files[$i];
                        $index_useless_files++;
                    }
                } else {
                    $useless_files[$index_useless_files] = $files[$i];
                    $index_useless_files++;
                }
            }
        }

        // remove all the useless files
        foreach($useless_files as $file){
            unlink($file['path']);
        }

        // remove the two useless directories of the mac zipped folder if they exists
        if(is_dir('../public/storage/images/zip/__MACOSX/'.$usefull_files[0]['info']['basename'])){
            rmdir('../public/storage/images/zip/__MACOSX/'.$usefull_files[0]['info']['basename']);
        }
        if(is_dir('../public/storage/images/zip/__MACOSX')){
            rmdir('../public/storage/images/zip/__MACOSX');
        }

        return $usefull_files;
    }

    /**
     * Remove the specified resource from storage.
     */
    private function destroy($img)
    {
        imagedestroy($img);
    }

}
