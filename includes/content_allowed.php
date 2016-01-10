<?php
$contentType_Audio = array('m4a', 'mp3','wav', 'wma', 'flac');
$contentType_Video = array('avi','mov', 'mxf', 'mp4', 'mkv', '3gp', 'm4v');
$contentType_Xtra = array('zip');

$allowed = array_merge($contentType_Audio, $contentType_Video, $contentType_Xtra);

?>