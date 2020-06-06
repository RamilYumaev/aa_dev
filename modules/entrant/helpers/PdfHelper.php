<?php


namespace modules\entrant\helpers;


use kartik\mpdf\Pdf;

class PdfHelper
{
    public static function generate($content, $fileName) {
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            'filename' => $fileName,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD,
            // your html content input
            'content' => $content,
            'marginLeft' => 20,
            'marginRight' => 10,
            'marginTop' => 15,
            'marginBottom' => 15,
            // format content from your own css file if needed or use the
            'cssFile' => '@frontend/web/css/pdf-documents.css',
            'defaultFont' => 'Times New Roman',
            'defaultFontSize'=> 8, //pt
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            // call mPDF methods on the fly
            //'marginTop' => 40,
        ]);
        return $pdf;
    }

}