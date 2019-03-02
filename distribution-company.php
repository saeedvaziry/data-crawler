<!DOCTYPE html>
<html>
<head>
	<title>FBOT</title>
	<meta charset="utf-8">
</head>
<body>
<?php
include('simple_html_dom.php');
function fetch($url)
{
    try {
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
        	// $file = fopen('data.csv', 'w');
            foreach ($links as $link) {
            	if (substr($link->getAttribute('href'), 0, 23) == 'DistCompanyDetails.aspx') {
         		   	$linkContent = file_get_contents('http://report.imed.ir/additionals/' . $link->getAttribute('href'));
            		echo $linkContent;
            		die();
            		// fwrite($file, $link->getAttribute('href') . '\n');
            	}
            }
            // fclose($file);
        }
    } catch (Exception $e) {
		echo "Error " . $e->getMessage();
    }
}
ob_end_flush();
ob_implicit_flush();
echo "<h2>Please wait...</h2>";
fetch('http://report.imed.ir/additionals/confirmeddistcmp.aspx');
?>
</body>
</html>