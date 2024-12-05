<?php


$id = isset($_GET['id']) ? $_GET['id'] : '';

$url_for_domain = "https://starshare.live:443/live/rvdgdf7647564/bvchgfd235454/{$id}.m3u8";

$headers_for_domain = [
    "User-Agent: OTT Navigator/1.6.7.4 (Linux;Android 11) ExoPlayerLib/2.15.1",
    "Host: starshare.live:443",
    "Connection: Keep-Alive",
    "Accept-Encoding: gzip"
];

$ch_for_domain = curl_init($url_for_domain);


curl_setopt($ch_for_domain, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_for_domain, CURLOPT_HEADER, true);  // Include headers in the output
curl_setopt($ch_for_domain, CURLOPT_FOLLOWLOCATION, false);  // Disable automatic redirection
curl_setopt($ch_for_domain, CURLOPT_HTTPHEADER, $headers_for_domain);


$response_for_domain = curl_exec($ch_for_domain);


$status_code_for_domain = curl_getinfo($ch_for_domain, CURLINFO_HTTP_CODE);


curl_close($ch_for_domain);


if ($status_code_for_domain == 302 && preg_match('/Location: (.+?)\n/', $response_for_domain, $matches_for_domain)) {
    $location_url = trim($matches_for_domain[1]);


    $domain = parse_url($location_url, PHP_URL_HOST);
} else {

    http_response_code(500);
    echo "Error extracting domain: $status_code_for_domain";
    exit;
}


$url_for_m3u8 = "https://starshare.live:443/live/rvdgdf7647564/bvchgfd235454/{$id}.m3u8";

$headers_for_m3u8 = [
    "User-Agent: OTT Navigator/1.6.7.4 (Linux;Android 11) ExoPlayerLib/2.15.1",
    "Host: starshare.live:443",
    "Connection: Keep-Alive",
    "Accept-Encoding: gzip"
];


$ch_for_m3u8 = curl_init($url_for_m3u8);


curl_setopt($ch_for_m3u8, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_for_m3u8, CURLOPT_FOLLOWLOCATION, true);  // Follow redirects
curl_setopt($ch_for_m3u8, CURLOPT_HTTPHEADER, $headers_for_m3u8);


$response_for_m3u8 = curl_exec($ch_for_m3u8);


$final_url_for_m3u8 = curl_getinfo($ch_for_m3u8, CURLINFO_EFFECTIVE_URL);


$status_code_for_m3u8 = curl_getinfo($ch_for_m3u8, CURLINFO_HTTP_CODE);


curl_close($ch_for_m3u8);


if ($status_code_for_m3u8 == 200) {

    $modified_response_text_for_m3u8 = str_replace("/hlsr/", "http://{$domain}/hlsr/", $response_for_m3u8);


    echo $modified_response_text_for_m3u8;
} else {

    if ($status_code_for_m3u8 == 403) {

        http_response_code(403);
        echo "Error: 403 Forbidden";
    } else {

        http_response_code(500);
        echo "Error: $status_code_for_m3u8";
    }
}
?>
