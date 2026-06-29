<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function generate()
    {
        $url = 'https://www.example.com';
        $size = 300;
      return  $qrCodeUrl = 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chl=' . urlencode($url);

        return view('admin.qrcode', compact('qrCodeUrl'));
    }
}
