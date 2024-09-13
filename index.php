<?php

define('BASE_DIR', realpath(__DIR__));

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . '/utils/ClientIp.php';
require_once __DIR__ . '/utils/ClientLanguage.php';
require_once __DIR__ . '/utils/WebGL.php';

echo "<h1>Detecto</h1>";

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use foroco\BrowserDetection;

$crawler = new CrawlerDetect();
$browser = new BrowserDetection();
$uainfo = $browser->getAll($_SERVER['HTTP_USER_AGENT']);     
$ip = ClientIp::get()['ip'];
$ipApiResult = json_decode(file_get_contents("http://ip-api.com/json/".$ip));
$webGL = new WebGL();

echo "<h2>All your browser info belongs to us</h2>";
echo "<hr/>";
echo "<div id='juice'>";
echo "Your Time Zone is ".'<script type="text/javascript">'.'document.write(Intl.DateTimeFormat().resolvedOptions().timeZone);'.'</script>'."</br>";
$offset = '<script type="text/javascript">'.'document.write(-(new Date().getTimezoneOffset() / 60));'.'</script>';
if ($offset[0] != '-') $offset = '+'.$offset;
$offset = 'GMT'.$offset;
echo "Your Time Zone offset is ".$offset."</br>";
echo "Your IP is ".$ip."</br>";
echo "Your ISP host is ".gethostbyaddr(ip: $ip)."</br>";
echo "Your locale is ".'<script type="text/javascript">'.'document.write(Intl.DateTimeFormat().resolvedOptions().locale);'.'</script>'."</br>";
echo "Your language is ".ClientLanguage::get()."</br>";
echo "Your languages is ".'<script type="text/javascript">'.'document.write(navigator.languages);'.'</script>'."</br>";
try {
    if ($ipApiResult->status == "success") {
        echo "Your country is ".$ipApiResult->country."</br>";
        echo "Your region is ".$ipApiResult->regionName."</br>";
        echo "Your city is ".$ipApiResult->city."</br>";
        echo "Your ISP is ".$ipApiResult->isp."</br>";
        echo "Your ISP timezone is ".$ipApiResult->timezone."</br>";
        echo "Your ISP zipcode ".$ipApiResult->zip."</br>";
    }
} catch (Exception $e) {
    echo '[!] Exception using Ip API: ',  $e->getMessage(), "</br>";
}
echo "Your User-Agent string is ".$_SERVER['HTTP_USER_AGENT']."</br>";
echo "Your device type is ".$uainfo['device_type']."</br>";
echo "Your OS family is ".$uainfo['os_family']."</br>";
echo "Your OS name is ".$uainfo['os_name']."</br>";
echo "Your OS version is ".$uainfo['os_version']."</br>";
echo "Your OS is 64-bit? ".($uainfo['64bits_mode'] ? "true" : "false")."</br>";
echo "Your browser vendor is ".'<script type="text/javascript">'.'document.write(navigator.vendor);'.'</script>'."</br>";
echo "Your browser name is ".$uainfo['browser_name']."</br>";
echo "Your browser version is ".$uainfo['browser_version']."</br>";
echo "Are you just a web crawler? ".($crawler->isCrawler() ? "true" : "false")."</br>";
echo "Your viewport width is ".'<script type="text/javascript">'.'document.write(window.innerWidth);'.'</script>'."</br>";
echo "Your viewport height is ".'<script type="text/javascript">'.'document.write(window.innerHeight);'.'</script>'."</br>";
echo "Your screen width is ".'<script type="text/javascript">'.'document.write(screen.width);'.'</script>'."</br>";
echo "Your screen height is ".'<script type="text/javascript">'.'document.write(screen.height);'.'</script>'."</br>";
echo "Your screen DPI is ".'<script type="text/javascript">'.'document.write(window.devicePixelRatio);'.'</script>'."</br>";
echo "Your hardware concurrency is ".'<script type="text/javascript">'.'document.write(navigator.hardwareConcurrency);'.'</script>'."</br>";
echo "Your WebGL vendor is "."<script type='text/javascript'>document.write(vendor);</script>"."</br>";
echo "Your WebGL renderer is "."<script type='text/javascript'>document.write(renderer);</script>"."</br>";
echo "</br>";
echo "All your HTTP headers are: "."</br>";
foreach (getallheaders() as $name => $value) {
    echo "$name: $value"."</br>";
}
echo "</div>";
echo "<hr/>";
echo "<h3>It happened ".gmdate('Y-m-d H:i:s')." GMT</h3>";
echo "<h5>Proudly brought to u by rextextau</h5>";