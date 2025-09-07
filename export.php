<?php
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    header('Location: index.php');
    exit;
}

$note = getNoteById($_GET['id']);

if (!$note) {
    header('Location: index.php');
    exit;
}

$type = $_GET['type'];

if ($type === 'pdf') {
    // PDF Export
    require_once 'vendor/autoload.php';
    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Note Taking App');
    $pdf->SetTitle($note['title']);
    $pdf->SetSubject('Note');
    $pdf->SetKeywords('note, export');
    
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    
    $html = '<h1>' . htmlspecialchars($note['title']) . '</h1>';
    $html .= '<p>' . nl2br(htmlspecialchars($note['content'])) . '</p>';
    
    // Add image if exists
    if ($note['image_path'] && file_exists($note['image_path'])) {
        $html .= '<img src="' . $note['image_path'] . '" style="max-width: 400px;">';
    }
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output($note['title'] . '.pdf', 'D');
    
} elseif ($type === 'word') {
    // Word Export
    require_once 'vendor/autoload.php';
    
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    
    $section->addText($note['title'], array('bold' => true, 'size' => 16));
    $section->addTextBreak(1);
    $section->addText($note['content']);
    
    // Add image if exists
    if ($note['image_path'] && file_exists($note['image_path'])) {
        $section->addImage($note['image_path'], array('width' => 400, 'height' => 300));
    }
    
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment;filename="' . $note['title'] . '.docx"');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
    
} else {
    header('Location: index.php');
    exit;
}
?>