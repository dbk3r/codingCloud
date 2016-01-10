<?php
/**
 * Das sind die Login-Angaben für die Datenbank
 */  
define("HOST", "localhost");     // Der Host mit dem du dich verbinden willst.
define("CC_ADMIN", "cc_admin");    // Der Datenbank-Benutzername. 
define("CC_ADMIN_PASSWORD", "ccpasswd");    // Das Datenbank-Passwort. 
define("DB", "cc_db");    // Der Datenbankname.
define("TABLE_PREPIX", "cc_");    // Der Datenbankname.

define("CONTENT_DIR", "/var/www/html/cc/content/");    // Content/Data Verzeichnis.
define("UPLOAD_DIR", "/var/www/html/cc/file-upload/");    // Upload Verzeichnis.
define("PUBLISH_DIR", "/mnt/nas/cc_share/CodingCloud/");    // mountpoint Samba Verzeichnis.
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", FALSE);    // NUR FÜR DIE ENTWICKLUNG!!!!
define("LOGFILE", "/var/www/html/cc/log/cc.log");    // NUR FÜR DIE ENTWICKLUNG!!!!


$contentType_Audio = array('m4a', 'mp3','wav', 'wma', 'flac');
$contentType_Video = array('avi','mov', 'mxf', 'mp4', 'mkv', '3gp', 'm4v');
$contentType_Xtra = array('zip');
// A list of permitted file extensions
$allowed = array_merge($contentType_Audio, $contentType_Video, $contentType_Xtra);

