<?php
/**
 * Das sind die Login-Angaben für die Datenbank
 */  
define("HOST", "localhost");     // Der Host mit dem du dich verbinden willst.
define("BRC_ADMIN", "cc_admin");    // Der Datenbank-Benutzername. 
define("BRC_ADMIN_PASSWORD", "ccpasswd");    // Das Datenbank-Passwort. 
define("DB", "cc_db");    // Der Datenbankname.
define("TABLE_PREPIX", "cc_");    // Der Datenbankname.

define("CONTENT_DIR", "/var/www/html/cc/content/");    // Content/Data Verzeichnis.
define("UPLOAD_DIR", "/var/www/html/cc/file-upload/");    // Upload Verzeichnis.
define("PUBLISH_DIR", "/mnt/dps-p-austausch/CodingCloud/");    // mountpoint Samba Verzeichnis.
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", FALSE);    // NUR FÜR DIE ENTWICKLUNG!!!!
define("LOGFILE", "/var/www/html/cc/log/cc.log");    // NUR FÜR DIE ENTWICKLUNG!!!!


$contentType_Audio = array('mp3','wav', 'wma', 'flac');
$contentType_Video = array('avi','mov', 'mxf', 'mp4', 'mkv', '3gp');
// A list of permitted file extensions
$allowed = array('3gp', 'mpg', 'mkv', 'avi', 'mov', 'mxf', 'mp4', 'png', 'jpg', 'gif','zip', 'blend', 'mp3', 'wav', 'wma', 'flac');

