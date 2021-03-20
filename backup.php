<?php
$dbname = "kaizenho_test";
$dbhost = "localhost";
$dbuser   ="kaizenho_usrdb";
$dbpasswd ="01usrdb49";
$email_from_backup = "info@codnet.com.ar";
$email_to_backup = "backupdb@codnet.com.ar";

$nameFile = $dbname . date("Y-m-d-H-i-s") . '.gz';
$backupFile = 'backup/'.$nameFile;
$command = "mysqldump --opt -h $dbhost -u$dbuser -p$dbpasswd $dbname --default-character-set=latin1 | gzip > $backupFile";
system($command);


$fichero = fopen($backupFile, 'r');
$contenido = fread($fichero, filesize($backupFile)); 
$encoded_attach = chunk_split(base64_encode($contenido));	
$cabeceras="From:".$email_from_backup."\nReply-To:".$email_from_backup."\n";
$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
$cabeceras .="Mime-Version: 1.0\n";
$cabeceras .= "Content-type: multipart/mixed; ";
$cabeceras .= "boundary=\"Message-Boundary\"\n";
$cabeceras .= "Content-transfer-encoding: 7BIT\n";
$cabeceras .= "X-attachments: ".$nameFile;
	
$body_top = "--Message-Boundary\n";
$body_top .= "Content-type: text/html; charset=US-ASCII\n";
$body_top .= "Content-transfer-encoding: 7BIT\n";
$body_top .= "Content-description: Mail message body\n\n";
		
	
$mensaje=$body_top."En el archivo adjunto se encuentra el BackUp del sistema KAIZEN Test realizado el ".date('d/m/Y H:i:s');
$asunto="BackUp KAIZEN Test";
$mensaje .= "\n\n--Message-Boundary\n";
$mensaje .= "Content-type: Binary; name=\"$nameFile\"\n";
$mensaje .= "Content-Transfer-Encoding: BASE64\n";
$mensaje .= "Content-disposition: attachment; filename=\"$nameFile\"\n\n";
$mensaje .= "$encoded_attach\n";
$mensaje .= "--Message-Boundary--\n"; 	
@mail($email_to_backup,$asunto,$mensaje,$cabeceras);
?>