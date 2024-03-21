@extends('layouts.image_recognition_layout')

@section('content')

<div class="classifier">
    <p>{{request('animal')}}</p>

    <img src="{{asset('storage/images/cat.jpeg');}}" alt="Picture of a cat ">

    <?php

        $img = imagecreatefromjpeg(Storage::path('/public/images/cat.jpeg'));

        $pixels = [];
        $width = imagesx($img);
        $height = imagesy($img);

        // for ($y = 0; $y < $height; $y++) {
        //     $row = [];
        //     for ($x = 0; $x < $width; $x++) {
        //         $rgb = imagecolorat($img, $x, $y);
        //         $color = imagecolorsforindex($img, $rgb);
        //         $row[] = [$color['red'], $color['green'], $color['blue']];
        //     }
        //     $pixels[] = $row;
        // }

        $model = new OnnxRuntime\Model(Storage::path('/public/onnx-models/bvlcalexnet-3.onnx'));

        //print_r($model->inputs());

        // $result = $model->predict(['inputs' => [$pixels]]);

        // print_r($result['detection_classes']);
    ?>
</div>

@endsection
