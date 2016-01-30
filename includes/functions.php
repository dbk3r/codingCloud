<?php
include_once 'config.php';



function write_log($log_text) {
	$myfile = fopen(LOGFILE, "a") or die("Unable to open file!");	
	fwrite($myfile, $log_text . "\n");
	fclose($myfile);	
}

function getContentType($ext) {
	
	include 'content_allowed.php';
	$ret = "";
	if(in_array(strtolower($ext), $contentType_Audio)) { $ret =  "Audio" ;}
	if(in_array(strtolower($ext), $contentType_Video)) { $ret = "Video" ;}	
	return $ret;
}	

function db_read_content($conn, $f_audio, $f_video, $f_blender, $searchtext) {
	
	$arr_filter = array(); $fall="";$k="";
	if($f_audio == "on") {array_push($arr_filter,'\'Audio\'');}
	if($f_video == "on") {array_push($arr_filter,'\'Video\'');} 
	if($f_blender == "on") {array_push($arr_filter,'\'Blender\'');} 	
	$fi = join(',',  $arr_filter);  	
	if($searchtext != "") {$search_filter = " AND content_description LIKE '%".$searchtext."%'";} else {$search_filter="";}
	$filter = "content_type IN (" .$fi. ")".$search_filter;
	#write_log("SELECT * from cc_content WHERE $filter ORDER BY id DESC");
	
	$sql = "SELECT * from cc_content WHERE $filter ORDER BY id DESC";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
    
	    while($row = $result->fetch_assoc()) {
	    	$onRightclick = " oncontextmenu=\"wfAction(event,'" .$row["content_uuid"]."');\"" ;
			if($row["content_type"] == "Video") { $av = $row["content_uuid"]."','". "content/" .$row["content_uuid"]."/lowres.mp4";}
			elseif($row["content_type"]=="Audio") { $av = $row["content_uuid"]."','". "content/" .$row["content_uuid"]."/".$row["content_filename"];}
			
			$onClick = " onclick=\"cActivate(event,'".$row["content_type"]."' ,'" . $av ."');\"" ;
	    	if($row["content_type"] == "Audio") { $thumbnail = "<img class=thumbnail src='img/audio.png'>"; }
			if($row["content_type"] == "Video" || $row["content_type"] == "blender") {
					if (file_exists ( CONTENT_DIR.$row["content_uuid"]."/".$row["content_thumbnail"] )) {
						$thumbnail = "<img class=thumbnail src='content/".$row["content_uuid"]."/".$row["content_thumbnail"]."'>";
					} else {
						$thumbnail = "<img class=thumbnail src='img/video.png'>";
					}
			}			
	    	
			echo "<div $onRightclick $onClick class=content id=".$row["content_uuid"].">\n";
			echo "	<div class=content-a>\n";
			echo "		<table border=0 width=100%cellspacing=0 cellpadding=0><tr>";			
			echo "			<td valign=middle align=left width=110>$thumbnail</td>";
			echo "			<td valign=top align=left>";
			echo "				<table height=100% border=0 width=100%>";
			echo "					<tr><td colspan=2 class=ContentDescription>".$row["content_description"]." - [".$row['content_filesize']."]</td></tr>";
			if($row["content_type"] == "blender") {
				echo "					<tr><td width=50% class=mediainfos valign=top>Scene Name: ".$row["content_sceneName"]."</td>";
				echo "						<td class=mediainfos width=50%>";
				echo "							Start Frame: ".$row["content_startFrame"]."<br>";
				echo "							End Frame: ".$row["content_endFrame"];				
				echo "						</td></tr>";
			} else {
				echo "					<tr><td width=50% class=mediainfos valign=top>Länge: ".$row["content_duration"]."</td>";			
				echo "						<td class=mediainfos width=50%>";
				echo "							Größe: ".$row["content_videoDimension"]."<br>";
				echo "							Video-Codec: ".$row["content_videoCodec"]. " | ". $row["content_videoBitrate"]."<br>";
				echo "							Audio-Codec: ".$row["content_audioCodec"]. " | ". $row["content_audioChannel"]. " | ". $row["content_audioSamplingrate"];
				echo "						</td></tr>";
			}
			echo "				</table></td>";
			echo "		<tr></table>";	
			echo "	</div>\n";	
			echo "</div>\n";	
			      
	    }
		echo "<div class=content-head></div>";	
	} else {
	    echo "<div class=content-head><div class=content-head-a>kein Content vorhanden</div></div>";
	}
}	

function add_DBJob($mysqli, $db, $uuid, $wf) {
	
		$sql = "SELECT * from cc_content where content_uuid='".$uuid."'";
		$result = $mysqli->query($sql);
		while($c = $result->fetch_assoc()) {
			$src_filename =  $c['content_filename'];
			$dest_filename=$src_filename;
			$content_type = $c['content_type'];	
		}
	
		$sql = "SELECT * from cc_wf WHERE wf_short='" . $wf . "'";
		$result = $mysqli->query($sql);	
    		
	    while($row = $result->fetch_assoc()) {
			
			// read processes		    	
			$pids = explode(',',$row["wf_pids"]);
			
			foreach($pids as $pid) {
				write_log($pid);
			    $sql2 = "SELECT * from cc_process where process_shortName='".$pid."'";
				$processes = $mysqli->query($sql2);
			    
	    		while($pidRow = $processes->fetch_assoc()) {
	    			if($pidRow["process_shortName"] == "genLowres")  { $dest_filename = "lowres.mp4";}
	    			if($pidRow["process_type"] == "genThumbnail") {$dest_filename = $src_filename.".png" ;}
	    			if($pidRow["process_type"] == "genThumbnail" && $content_type == "Audio")
					{
						continue;
					}
					if($pidRow["process_type"] == "transcode" && $content_type == "Audio")
					{
						continue;
					}
					if($pidRow["process_type"] == "mediainfo" && $content_type == "blender")
					{
						$essential_bin = "blender";
					}
					if($pidRow["process_type"] == "genThumbnail" && $content_type == "blender")
					{
						$essential_bin = "blender";
					}
					else
					{
						$essential_bin = $pidRow["process_essential"];
					}
					
	    				$sql3 = "INSERT INTO `$db`.`cc_jobs` (uuid, job_type,job_essential,state,job_cmd,content_type,dest_filename,src_filename) VALUES (
	    									'".$uuid."',
	    									'".$pidRow["process_type"]."',
	    									'".$essential_bin."',
	    									'0',
	    									'".$pidRow["process_cmd"]."',
	    									'".$content_type."',
	    									'".$dest_filename."',
	    									'".$src_filename."'
	    									);";
											
						$mysqli->query($sql3);					
				}
			
			}
	    }
	
}

function add_DBContent($conn, $content_filename, $content_uuid, $content_type) {
	
	
	$sql = "INSERT INTO cc_content (content_description,content_filename,content_uuid,content_type) VALUES ('$content_filename','$content_filename','$content_uuid','$content_type')";

	if ($conn->query($sql) === TRUE) {
	    
	} else {
		$ret_json = "add DBContent failed";
	    
	}
}


function unzip_file($file, $path) {	
	
	$zip = new ZipArchive;
	$res = $zip->open($file);
	if ($res === TRUE) {
	  $zip->extractTo($path);
	  $zip->close();	
	  $ret = TRUE;	  
	} else {
		$ret = FALSE;
	}
	return $ret;
}

 
function generate_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
} 
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // vergib einen Sessionnamen
    $secure = SECURE;
    // Damit wird verhindert, dass JavaScript auf die session id zugreifen kann.
    $httponly = true;
    // Zwingt die Sessions nur Cookies zu benutzen.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Holt Cookie-Parameter.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Setzt den Session-Name zu oben angegebenem.
    session_name($session_name);
    session_start();            // Startet die PHP-Sitzung 
    session_regenerate_id();    // Erneuert die Session, löscht die alte. 
}

function login($email, $password, $mysqli) {
    // Das Benutzen vorbereiteter Statements verhindert SQL-Injektion.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Führe die vorbereitete Anfrage aus.
        $stmt->store_result();
 
        // hole Variablen von result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hash das Passwort mit dem eindeutigen salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // Wenn es den Benutzer gibt, dann wird überprüft ob das Konto
            // blockiert ist durch zu viele Login-Versuche 
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Konto ist blockiert 
                // Schicke E-Mail an Benutzer, dass Konto blockiert ist
                return false;
            } else {
                // Überprüfe, ob das Passwort in der Datenbank mit dem vom
                // Benutzer angegebenen übereinstimmt.
                if ($db_password == $password) {
                    // Passwort ist korrekt!
                    // Hole den user-agent string des Benutzers.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    // Login erfolgreich.
                    return true;
                } else {
                    // Passwort ist nicht korrekt
                    // Der Versuch wird in der Datenbank gespeichert
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            //Es gibt keinen Benutzer.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Hole den aktuellen Zeitstempel 
    $now = time();
 
    // Alle Login-Versuche der letzten zwei Stunden werden gezählt.
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts <code><pre>
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Führe die vorbereitet Abfrage aus. 
        $stmt->execute();
        $stmt->store_result();
 
        // Wenn es mehr als 5 fehlgeschlagene Versuche gab 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Überprüfe, ob alle Session-Variablen gesetzt sind 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Hole den user-agent string des Benutzers.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" zum Parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Wenn es den Benutzer gibt, hole die Variablen von result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Eingeloggt!!!! 
                    return true;
                } else {
                    // Nicht eingeloggt
                    return false;
                }
            } else {
                // Nicht eingeloggt
                return false;
            }
        } else {
            // Nicht eingeloggt
            return false;
        }
    } else {
        // Nicht eingeloggt
        return false;
    }
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // Wir wollen nur relative Links von $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}


