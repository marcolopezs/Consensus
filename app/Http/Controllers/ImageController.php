<?php namespace Consensus\Http\Controllers;

class ImageController extends Controller {

    public function adaptiveResize($folder, $width, $height, $image)
    {
        $file = public_path().'/imagenes/' . $folder . '/' .$image;
        $image = \Image::make($file);
        $image->fit($width, $height);
        return $image->response();
    }

}