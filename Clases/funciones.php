<?php

function validaTipoArchivo($file, $nomArchivo, $tipoData) {

    if (!in_array($file[$nomArchivo]['type'], $tipoData)) {
        return 1;
    } else {
        return 0;
    }
}

function SendMail($From, $FromName, $To, $ToName, $Subject, $Text, $Html, $AttmFiles, $replyto, $replyname) {
    $OB = "----=_OuterBoundary_000";
    $IB = "----=_InnerBoundery_001";
    $Html = $Html ? $Html : preg_replace("/\n/", "{br}", $Text)
            or die("neither text nor html part present.");
    $Text = $Text ? $Text : "Sorry, but you need an html mailer to read this mail.";
    $From or die("sender address missing");
    $To or die("recipient address missing");

    $headers = "MIME-Version: 1.0\r\n";
    $headers.="From: " . $FromName . " <" . $From . ">\n";
    $headers.="To: " . $ToName . " <" . $To . ">\n";
    $headers.="Reply-To: " . $replyname . " <" . $replyto . ">\n";
    $headers.="X-Priority: 1\n";
    $headers.="X-MSMail-Priority: High\n";
    $headers.="X-Mailer: My PHP Mailer\n";
    $headers.="Content-Type: multipart/mixed;\n\tboundary=\"" . $OB . "\"\n";

    //Messages start with text/html alternatives in OB
    $Msg = "This is a multi-part message in MIME format.\n";
    $Msg.="\n--" . $OB . "\n";
    $Msg.="Content-Type: multipart/alternative;\n\tboundary=\"" . $IB . "\"\n\n";

    //plaintext section 
    $Msg.="\n--" . $IB . "\n";
    $Msg.="Content-Type: text/plain;\n\tcharset=\"iso-8859-1\"\n";
    $Msg.="Content-Transfer-Encoding: quoted-printable\n\n";
    // plaintext goes here
    $Msg.=$Text . "\n\n";

    // html section 
    $Msg.="\n--" . $IB . "\n";
    $Msg.="Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";
    $Msg.="Content-Transfer-Encoding: base64\n\n";
    // html goes here 
    $Msg.=chunk_split(base64_encode($Html)) . "\n\n";

    // end of IB
    $Msg.="\n--" . $IB . "--\n";

    // attachments
    if ($AttmFiles) {
        foreach ($AttmFiles as $AttmFile) {
            $patharray = explode("/", $AttmFile);
            $FileName = $patharray[count($patharray) - 1];
            $Msg.= "\n--" . $OB . "\n";
            $Msg.="Content-Type: application/octetstream;\n\tname=\"" . $FileName . "\"\n";
            $Msg.="Content-Transfer-Encoding: base64\n";
            $Msg.="Content-Disposition: attachment;\n\tfilename=\"" . $FileName . "\"\n\n";

            //file goes here
            $fd = fopen($AttmFile, "r");
            $FileContent = fread($fd, filesize($AttmFile));
            fclose($fd);
            $FileContent = chunk_split(base64_encode($FileContent));
            $Msg.=$FileContent;
            $Msg.="\n\n";
        }
    }

    //message ends
    $Msg.="\n--" . $OB . "--\n";
    mail($To, $Subject, $Msg, $headers);
    //syslog(LOG_INFO,"Mail: Message sent to $ToName <$To>");
}

function fecha_mysql($falta) {

    if (!empty($falta)) {

        $falta = preg_replace('/(-|\/)/', '/', $falta);
        $pos1 = strpos($falta, '/');
        if ($pos1 > 0) {

            $day1 = substr($falta, 0, $pos1);
        }
        $posu1 = strrpos($falta, '/');

        if ($posu1 > $pos1) {

            $month1 = substr($falta, $pos1 + 1, $posu1 - $pos1 - 1);
        }

        $year1 = substr($falta, $posu1 + 1);

        if (checkdate($month1, $day1, $year1)) {

            //    $fechabus = mktime(0,0,0,$month,$day,$year);
            $falta = $year1 . '/' . $month1 . '/' . $day1;
        } else {
            $ERROR = 'La Fecha desde no es valida.';
        }
    }
    return $falta;
}

function fecha_mysql2($falta) {

    if (!empty($falta)) {

        $pos1 = strpos($falta, '/');

        if ($pos1 > 0) {
            $month1 = substr($falta, 0, $pos1);
        }
        $posu1 = strrpos($falta, '/');

        if ($posu1 > $pos1) {
            $day1 = substr($falta, $pos1 + 1, $posu1 - $pos1 - 1);
        }
        $year1 = substr($falta, $posu1 + 1);

        if (checkdate($month1, $day1, $year1)) {
            //    $fechabus = mktime(0,0,0,$month,$day,$year);
            $falta = $year1 . '/' . $month1 . '/' . $day1;
        } else {
            $ERROR = 'La Fecha desde no es valida.';
        }
    }
    return $falta;
}

function fecha_human($fecha_exp) {

    if (!empty($fecha_exp)) {
        $pos = strpos($fecha_exp, '-');
        if ($pos > 0)
            $year = substr($fecha_exp, 0, $pos);

        $posu = strrpos($fecha_exp, '-');
        if ($posu > $pos)
            $month = substr($fecha_exp, $pos + 1, $posu - $pos - 1);

        $day = substr($fecha_exp, $posu + 1);

        if (checkdate($month, $day, $year)) {
            //    $fechabus = mktime(0,0,0,$month,$day,$year);
            $fecha_exp = $day . "/" . $month . "/" . $year;
        }else
            $ERROR = 'La Fecha desde no es valida.';
    }
    return $fecha_exp;
}

function get_week_boundaries($int_time) {
    //first: find monday 0:00
    $weekdayid = date("w", $int_time);
    $dayid = date("j", $int_time);
    $monthid = date("n", $int_time);
    $yearid = date("Y", $int_time);
    $beginofday = mktime(0, 0, 0, $monthid, $dayid, $yearid);
    $beginofweek = $beginofday - (($weekdayid - 1) * 86400); //86400 == seconds of one day (24 hours)
    //now add the value of one week and call it the end of the week
    //NOTE: End of week is Sunday, 23:59:59. I think you could also use Monday 00:00:00 but I though that'd suck
    $endofweek = ($beginofweek + 7 * 86400) - 1;
    $week["begin"] = $beginofweek;
    $week["end"] = $endofweek;
    $week["pov"] = $int_time;
    return $week;
}

function GetUserInfo($idTarget, $conn) {

    /* This function Get All User Info */
    $sTable = "sys_users";
    $sSql = "SELECT * FROM $sTable WHERE idUser = $idTarget";
    //echo $sSql;
    $uRes = mysql_query($sSql, $conn);
    $aRes = mysql_fetch_array($uRes, MYSQL_ASSOC);

    return $aRes;
}

function unhtmlspecialchars($string) {

    $string = str_replace('&amp;', '&', $string);
    $string = str_replace('&#039;', '\'', $string);
    $string = str_replace('&quot;', '\"', $string);
    $string = str_replace('&lt;', '<', $string);
    $string = str_replace('&gt;', '>', $string);
    return $string;
}

function cambia_nombre($imgfile_name) {

    $imgfile_name = str_replace("�", "n", $imgfile_name);
    $imgfile_name = str_replace("�", "N", $imgfile_name);
    $imgfile_name = str_replace(" ", "_", $imgfile_name);
    $imgfile_name = str_replace("#", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "a", $imgfile_name);
    $imgfile_name = str_replace("�", "e", $imgfile_name);
    $imgfile_name = str_replace("�", "i", $imgfile_name);
    $imgfile_name = str_replace("�", "o", $imgfile_name);
    $imgfile_name = str_replace("�", "u", $imgfile_name);
    $imgfile_name = str_replace("(", "_", $imgfile_name);
    $imgfile_name = str_replace(")", "_", $imgfile_name);
    $imgfile_name = str_replace("[", "_", $imgfile_name);
    $imgfile_name = str_replace("]", "_", $imgfile_name);
    $imgfile_name = str_replace("?", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "_", $imgfile_name);
    $imgfile_name = str_replace("!", "_", $imgfile_name);
    $imgfile_name = str_replace("&", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "_", $imgfile_name);
    $imgfile_name = str_replace(",", "_", $imgfile_name);
    $imgfile_name = str_replace("'", "_", $imgfile_name);
    $imgfile_name = str_replace(";", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "a", $imgfile_name);
    $imgfile_name = str_replace("�", "e", $imgfile_name);
    $imgfile_name = str_replace("�", "i", $imgfile_name);
    $imgfile_name = str_replace("�", "o", $imgfile_name);
    $imgfile_name = str_replace("�", "u", $imgfile_name);
    $imgfile_name = str_replace("`", "_", $imgfile_name);
    $imgfile_name = str_replace("/", "_", $imgfile_name);
    $imgfile_name = str_replace("\\", "_", $imgfile_name);
    $imgfile_name = str_replace("'", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "_", $imgfile_name);
    $imgfile_name = str_replace("�", "_", $imgfile_name);
    return $imgfile_name;
}

function segundos_tiempo($segundos) {

    $minutos = $segundos / 60;
    $horas = floor($minutos / 60);
    $minutos2 = $minutos % 60;
    $segundos_2 = $segundos % 60 % 60 % 60;
    if ($minutos2 < 10)
        $minutos2 = '0' . $minutos2;
    if ($segundos_2 < 10)
        $segundos_2 = '0' . $segundos_2;

    if ($segundos < 60) { /* segundos */
        $resultado = round($segundos);
    } elseif ($segundos > 60 && $segundos < 3600) {/* minutos */
        $resultado = $minutos2 . 'p' . $segundos_2;
    } else {/* horas */
        $resultado = $horas . 'p' . $minutos2 . 'p' . $segundos_2;
    }
    return $resultado;
}

function str_splits($text, $split = 1) {

    if (!is_string($text))
        return false;
    if (!is_numeric($split) && $split < 1)
        return false;

    $len = strlen($text);
    $array = array();
    $s = 0;
    $e = $split;

    while ($s < $len) {

        $e = ($e < $len) ? $e : $len;
        $array[] = substr($text, $s, $e);
        $s = $s + $e;
    }
    return $array;
}

function segundos_tiempo2($segundos) {

    $minutos = $segundos / 60;
    $horas = floor($minutos / 60);
    $dias = floor($horas / 24);
    $horas2 = $horas % 24;
    $minutos2 = $minutos % 60;
    $segundos_2 = $segundos % 60 % 60 % 60;
    if ($horas2 < 10)
        $horas2 = '0' . $horas2;
    if ($minutos2 < 10)
        $minutos2 = '0' . $minutos2;
    if ($segundos_2 < 10)
        $segundos_2 = '0' . $segundos_2;

    if ($segundos < 60) { /* segundos */
        $resultado = round($segundos) . ' segundos';
    } elseif ($segundos > 60 && $segundos < 3600) {/* minutos */
        $resultado = $minutos2 . 'p' . $segundos_2;
    } elseif ($segundos > 3600 && $segundos < 86400) {/* horas */
        $resultado = $horas . 'p' . $minutos2 . 'p' . $segundos_2;
    } else {/* horas */
        $resultado = $dias . ' dias ' . $horas2 . 'p' . $minutos2 . 'p' . $segundos_2;
    }
    return $resultado;
}

function eliminaCaractExtranos($string, $arrayChars) {

    $result = $string;
    foreach ($arrayChars as $key => $val) {

        $result = str_replace($key, $val, $result);
    }
    return $result;
}

function nombre_mes($mes) {

    if ($mes == 1) {
        $mes_nombre = "Enero";
    } else if ($mes == 2) {
        $mes_nombre = "Febrero";
    } else if ($mes == 3) {
        $mes_nombre = "Marzo";
    } else if ($mes == 4) {
        $mes_nombre = "Abril";
    } else if ($mes == 5) {
        $mes_nombre = "Mayo";
    } else if ($mes == 6) {
        $mes_nombre = "Junio";
    } else if ($mes == 7) {
        $mes_nombre = "Julio";
    } else if ($mes == 8) {
        $mes_nombre = "Agosto";
    } else if ($mes == 9) {
        $mes_nombre = "Septiembre";
    } else if ($mes == 10) {
        $mes_nombre = "Octubre";
    } else if ($mes == 11) {
        $mes_nombre = "Noviembre";
    } else if ($mes == 12) {
        $mes_nombre = "Diciembre";
    }
    return $mes_nombre;
}

?>
