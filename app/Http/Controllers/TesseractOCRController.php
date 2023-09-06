<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class TesseractOCRController extends Controller
{
    public function index()
    {
        $result = [''];
        return view('ocr.convert-img-to-text', compact('result'));
    }

    public function processImage(Request $request)
    {
        $language = $request->input('language');
        $image = $request->file('img');
        if ($image) {
            $extension = $image->getClientOriginalExtension();

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($extension, $allowedExtensions)) {
                $imageName = 'test.jpg';
                try {
                    $image->move(public_path('assets/image/product'), $imageName);
                    $imagePath = public_path('assets/image/product/' . $imageName);
                    $text = new TesseractOCR($imagePath);
                    $text->executable(public_path('assets/Tesseract-OCR/tesseract.exe'));
                    if ($language == 1) {
                        $text->lang('eng');
                    } else {
                        $text->lang('vie');
                    }
                    $result = explode("\n", $text->run());
                } catch (\Exception $exception) {
                    $result = [];
                    return view('ocr.convert-img-to-text', compact('result'));
                }
                $oldImagePath = public_path('assets/image/product/test');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                return view('ocr.convert-img-to-text', compact('result'))->with('success', 'Image has been scanned successfully.');
            }
        }
        return redirect()->route('ocr.index')->with('failure', 'The uploaded file must be in the correct image format (jpg, jpeg, png, gif).');
    }
}
