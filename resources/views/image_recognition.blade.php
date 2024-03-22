@extends('layouts.image_recognition_layout')

@section('content')

<div class="classifier">
    <p>{{request('animal')}}</p>
    <img src="{{asset('storage/images/salamander.jpeg');}}" alt="Picture of a st bernard ">

    <?php
    // get the image trough the path and store it in $img
    $img = imagecreatefromjpeg(Storage::path('/public/images/salamander.jpeg'));

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

    // call the onnx model
    $model = new OnnxRuntime\Model(Storage::path('/public/onnx-models/efficientnet-lite4-11-qdq.onnx'));

    // run the onnx model with the pixel array in parameter
    $response = $model->predict(['images:0' => [$float_pixels]]);
    $results = $response["Softmax:0"];

    // print_r($results);

    // sort the results to get the 3 most likely

    // load the json file with the responses
    $json_data = file_get_contents(Storage::path('/public/onnx-models/labels_map.json'));

    // convert the json string to a php array
    $labels = json_decode($json_data, true);

    // check if the array is filled
    if ($labels === null) {
        echo "An error occured when we try to decode the answers\n";
        exit(1);
    }

    // copy the array so the original one is not changed
    $sorted_array = $results[0];

    // sort array by descending numbre
    arsort($sorted_array);

    // get the 3 first index
    $top_indices = array_slice(array_keys($sorted_array), 0, 3);

    // get trough the 5 top index
    foreach ($top_indices as $r) {
        // chek on the label map which picture is it
        if (array_key_exists(strval($r), $labels)) {
            // show what the picture is
            echo "-> " . $labels[strval($r)] . "</br>";
        } else {
            echo "Étiquette non trouvée pour l'indice : " . $r . "\n";
        }
    }

    // $inputInfo = $model->outputs();
    // print_r($inputInfo);
    ?>
</div>

@endsection
