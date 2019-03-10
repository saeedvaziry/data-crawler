<?php

error_reporting(0);

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
    'ctl00$MainContent$DDL_AskerType' => 'Guild',
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
        ->setCellValue('A1', 'نام واحد فروشنده ( مطابق تابلو )')
        ->setCellValue('B1', 'نوع فعالیت')
        ->setCellValue('C1', 'شماره پروانه کسب')
        ->setCellValue('D1', 'تاریخ صدور پروانه کسب')
        ->setCellValue('E1', 'تاریخ اعتبار پروانه کسب')
        ->setCellValue('F1', 'نام و نام خانوادگی صاحب پروانه کسب')
        ->setCellValue('G1', 'شماره تماس در مواقع ضروری')
        ->setCellValue('H1', 'پست الکترونیکی')
        ->setCellValue('I1', 'استان / شهر محل فعالیت')
        ->setCellValue('J1', 'آدرس')
        ->setCellValue('K1', 'سطح فعالیت')
        ->setCellValue('L1', 'نام و نام خانوادگی مسئول فنی');
    $i = 2;
    foreach ($links as $key => $link) {
        if (substr($link->getAttribute('href'), 0, 17) == 'GuildDetails.aspx') {
            $linkContent = file_get_contents('http://report.imed.ir/additionals/' . $link->getAttribute('href'));
            $dm = new DOMDocument;
            $dm->loadHTML('<?xml encoding="utf-8" ?>' . $linkContent);

            $a = $dm->getElementById('ctl00_MainContent_lbl_SellerName');
            $b = $dm->getElementById('ctl00_MainContent_lbl_ActivityType');
            $c = $dm->getElementById('ctl00_MainContent_lbl_LicNO');
            $d = $dm->getElementById('ctl00_MainContent_lbl_LicStartDate');
            $e = $dm->getElementById('ctl00_MainContent_lbl_LicEndDate');
            $f = $dm->getElementById('ctl00_MainContent_lbl_Name');
            $g = $dm->getElementById('ctl00_MainContent_lbl_Tel');
            $h = $dm->getElementById('ctl00_MainContent_lbl_Email');
            // $i = $dm->getElementById('ctl00_MainContent_lbl_City');
            $j = $dm->getElementById('ctl00_MainContent_lbl_Address');
            $k = $dm->getElementById('ctl00_MainContent_lbl_Level');
            $l = $dm->getElementById('ctl00_MainContent_lbl_TechOfficer');

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $a ? $a->nodeValue : '')
                ->setCellValue('B' . $i, $b ? $b->nodeValue : '')
                ->setCellValue('C' . $i, $c ? $c->nodeValue : '')
                ->setCellValue('D' . $i, $d ? $d->nodeValue : '')
                ->setCellValue('E' . $i, $e ? $e->nodeValue : '')
                ->setCellValue('F' . $i, $f ? $f->nodeValue : '')
                ->setCellValue('G' . $i, $g ? $g->nodeValue : '')
                ->setCellValue('H' . $i, $h ? $h->nodeValue : '')
                // ->setCellValue('I' . $i, $i ? $i->nodeValue : '')
                ->setCellValue('J' . $i, $j ? $j->nodeValue : '')
                ->setCellValue('K' . $i, $k ? $k->nodeValue : '')
                ->setCellValue('L' . $i, $l ? $l->nodeValue : '');

            ob_end_flush();
            ob_implicit_flush();
            echo $i . "\n";
            $i++;
        }
    }
    $writer = new Xlsx($spreadsheet);
    $writer->save('guild.xlsx');
    echo "Finished";
    exit;
}