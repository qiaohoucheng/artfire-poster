<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ImagesController extends Controller
{
    //
    public function index()
    {
        Image::configure(array('driver' => 'gd'));
        $img = Image::make('bg/1.jpg');
        if(!file_exists('code2.jpg')){
            $img2 = Image::make('code.jpg')->resize(200, 200);
            $img2->save('code2.jpg');
        }
        $img->insert('code2.jpg', 'bottom-right', 195, 80);
        $img->insert('code2.jpg', 'bottom-right', 195, 80);
        return $img->response('jpg');
    }
    function yuan_img($imgpath = null) {
        $ext     = pathinfo($imgpath );
        $src_img = null;
        switch ($ext['extension']) {
            case 'jpg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'jpeg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'png':
                $src_img = imagecreatefrompng($imgpath);
                break;
        }
        $wh  = getimagesize($imgpath);
        $w   = $wh[0];
        $h   = $wh[1];
        $w   = min($w, $h);
        $h   = $w;
        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);
        $r   = $w /2; //圆半径
        $y_x = $r; //圆心X坐标
        $y_y = $r; //圆心Y坐标
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }
        $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.png';

        imagepng($img,'storage/'.$filename);

        return $this->path='storage/'.$filename;
    }
}
