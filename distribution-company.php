<?php

require 'vendor/autoload.php';
require 'simple_html_dom.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$url = 'http://report.imed.ir/additionals/confirmeddistcmp.aspx';

$postdata = http_build_query([
    '__EVENTTARGET' => '',
    '__EVENTARGUMENT' => '',
    '__VIEWSTATE' => '/wEPDwUKLTEzNjkwMzg2Nw9kFgJmD2QWAgIDD2QWAgIBD2QWBAIDDxBkEBUDAB7YtNix2qnYqiDYqtmI2LLbjNi5INqp2YbZhtiv2YcK2KfYtdmG2KfZgRUDABNEaXN0cmlidXRpb25Db21wYW55BUd1aWxkFCsDA2dnZ2RkAg8PPCsADgIAFCsAAg8WCB4cRW5hYmxlRW1iZWRkZWRCYXNlU3R5bGVzaGVldGceFUVuYWJsZUVtYmVkZGVkU2NyaXB0c2ceF0VuYWJsZUFqYXhTa2luUmVuZGVyaW5naB4SUmVzb2x2ZWRSZW5kZXJNb2RlCylxVGVsZXJpay5XZWIuVUkuUmVuZGVyTW9kZSwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxNi4yLjUwNC4wLCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTI5YWMxYTkzZWMwNjNkOTIBZBcDBQhQYWdlU2l6ZQIZBQ9TZWxlY3RlZEluZGV4ZXMWAAULRWRpdEluZGV4ZXMWAAEWAhYLZGRlFCsAAAspeFRlbGVyaWsuV2ViLlVJLkdyaWRDaGlsZExvYWRNb2RlLCBUZWxlcmlrLldlYi5VSSwgVmVyc2lvbj0yMDE2LjIuNTA0LjAsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MjlhYzFhOTNlYzA2M2Q5MgE8KwAHAAspc1RlbGVyaWsuV2ViLlVJLkdyaWRFZGl0TW9kZSwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxNi4yLjUwNC4wLCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTI5YWMxYTkzZWMwNjNkOTIBFgIeBF9lZnMWAh4TY3NfcG9wdXBzX0Nsb3NlVGV4dAUFQ2xvc2VkZGRmZBgBBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WAQUaY3RsMDAkTWFpbkNvbnRlbnQkUmFkR3JpZDHOEUDFf2AisjXIGA9qdyKQCos5WsLwNdEbD7F2M3OpEg==',
    '__VIEWSTATEGENERATOR' => 'CED35E73',
    '__EVENTVALIDATION' => '/wEdAAcjgnzNha2KXhtfEpCvyFWOgn557R8169iIAEMkRLL5utqGFY8C1DpnlaAxK3W6xG0ZQ91GxpCVRnePUCqL5Idx6I7TvDQh1iAz26PM/37fn3rUOjkapy9hxZzF9Y8CPpdqye8Tx2E4u3YokW8uuO97kXAF6FOXYvfjgH902/lOgIbGmZTfc7C8PLm9HuX/QVg=',
    'ctl00$MainContent$DDL_AskerType' => 'DistributionCompany',
    'ctl00$MainContent$btn_serach' => 'جستجو',
    'ctl00$MainContent$txt_Company' => '',
    'ctl00$MainContent$txt_cmp' => '',
    'ctl00_MainContent_RadGrid1_ClientState' => ''
]);
$opts = array('http' => [
    'method'  => 'POST',
    'header'  => 'Content-type: application/x-www-form-urlencoded, Origin: http://report.imed.ir, Referer: http://report.imed.ir/additionals/confirmeddistcmp.aspx, User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) snap Chromium/72.0.3626.119 Chrome/72.0.3626.119 Safari/537.36',
    'content' => $postdata
]);
$context  = stream_context_create($opts);
$content = file_get_contents($url, false, $context);
$dom = new DOMDocument;
$dom->loadHTML($content);
$links = $dom->getElementsByTagName('a');
if ($links) {
    $spreadsheet = new Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'نام شرکت')
        ->setCellValue('B1', 'تلن تماس')
        ->setCellValue('C1', 'آدرس ایمیل')
        ->setCellValue('D1', 'مدیرعامل')
        ->setCellValue('E1', 'استان / شهر')
        ->setCellValue('F1', 'آدرس')
        ->setCellValue('G1', 'مسئول فنی');
    $i = 2;
    foreach ($links as $key => $link) {
        if (substr($link->getAttribute('href'), 0, 23) == 'DistCompanyDetails.aspx') {
            $linkContent = file_get_contents('http://report.imed.ir/additionals/' . $link->getAttribute('href'));
            $dm = new DOMDocument;
            $dm->loadHTML('<?xml encoding="utf-8" ?>' . $linkContent);

            $a = $dm->getElementById('ctl00_MainContent_lbl_CompName');
            $b = $dm->getElementById('ctl00_MainContent_lbl_Tel');
            $c = $dm->getElementById('ctl00_MainContent_lbl_Email');
            $d = $dm->getElementById('ctl00_MainContent_lbl_Name');
            $e = $dm->getElementById('ctl00_MainContent_lbl_State');
            $f = $dm->getElementById('ctl00_MainContent_lbl_Address');
            $g = $dm->getElementById('ctl00_MainContent_lbl_TechOfficer');

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $a->nodeValue)
                ->setCellValue('B' . $i, $b->nodeValue)
                ->setCellValue('C' . $i, $c->nodeValue)
                ->setCellValue('D' . $i, $d->nodeValue)
                ->setCellValue('E' . $i, $e->nodeValue)
                ->setCellValue('F' . $i, $f->nodeValue)
                ->setCellValue('G' . $i, $g->nodeValue);

            $i++;
        }
    }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="distribution-company.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}