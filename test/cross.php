<?php
$data = $_REQUEST;
$url =  'http://shecodes.workingclock.com/';
$url = $url.$data['url'];
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo json_encode($result);
?>