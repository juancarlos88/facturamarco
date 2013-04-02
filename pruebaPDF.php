<?php
function pdf_create($html, $filename='', $stream=TRUE) {
    
    require_once("Clases/dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
$html = 'HIOLA';
pdf_create($html, 'prueba', TRUE);
?>
