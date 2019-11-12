<html>
<head>
<meta charset="UTF-8" />
<style>
span { width: 90px; display:inline-block; }
</style>
</head>
<body>
<?php
$acao = @$_REQUEST['acao'];

function importSqlFile($pdo, $sqlFile, $tablePrefix = null, $InFilePath = null){
    try {  
        // Enable LOAD LOCAL INFILE
        $pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);
        
        $errorDetect = false;
        
        // Temporary variable, used to store current query
        $tmpLine = '';
        
        // Read in entire file
        $lines = file($sqlFile);
        
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || trim($line) == '') {
                continue;
            }
            
            // Read & replace prefix
            $line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);
            //////////////////////////////////////////////////////////////////////////////////////////
            // colocar replace para {{url_host}}
            //////////////////////////////////////////////////////////////////////////////////////////
            
            // Add this line to the current segment
            $tmpLine .= $line;
            
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                try {
                    // Perform the Query
                    $pdo->exec($tmpLine);
                } catch (\PDOException $e) {
                    echo "<br><pre>Error performing Query: '<strong>" . $tmpLine . "</strong>': " . $e->getMessage() . "</pre>\n";
                    $errorDetect = true;
                }
                
                // Reset temp variable to empty
                $tmpLine = '';
            }
        }
        
        // Check if error is detected
        if ($errorDetect) {
            return false;
        }
        
    } catch (\Exception $e) {
        echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
        return false;
    }
    
    return true;
}

if ($acao == "enviar"):
    $db_host = @$_REQUEST['db_host'];
    $db_name = @$_REQUEST['db_name'];
    $db_user = @$_REQUEST['db_user'];
    $db_pass = @$_REQUEST['db_pass'];

    $url_host = $_SERVER['HTTP_HOST']; //url da página
    $path_to_file = 'sql/ajustes.sql';
    $path_to_new_file = 'sql/bd_ajustado.sql';

    $file_contents = file_get_contents($path_to_file);
    $file_contents = str_replace("{{{url_host}}}", $url_host, $file_contents);
    ///$file_contents = str_replace("{{{db_name}}}", $db_name, $file_contents); // linha sem função, pois o banco não está sendo criado aqui
    file_put_contents($path_to_new_file, $file_contents);

    $dbh = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);

    // Import the SQL file
    $res = importSqlFile($dbh, $path_to_new_file);
    if ($res === false) {
        die('ERROR');
    }

    // update wp-config
    $path_to_config = 'wp-config-sample.php';
    $path_to_new_config = 'wp-config.php';

    $file_contents_config = file_get_contents($path_to_config);
    $file_contents_config = str_replace("{{{db_name}}}", $db_name, $file_contents_config);
    $file_contents_config = str_replace("{{{db_user}}}", $db_user, $file_contents_config);
    $file_contents_config = str_replace("{{{db_pass}}}", $db_pass, $file_contents_config);
    $file_contents_config = str_replace("{{{db_host}}}", $db_host, $file_contents_config);

    file_put_contents($path_to_new_config, $file_contents_config);

    echo "SQL e wp-config atualizados <a href=\"replace_old.php\">Voltar</a><br>";
    echo "Acessa o sistema Inclua <a href=\"index.php\">Acessar</a>";
else:
?>
<form action="replace_old.php?acao=enviar" method="post">
    <span>Host bd:</span><input type="text" name="db_host" /> <br />
    <span>Nome bd:</span><input type="text" name="db_name" /> <br />
    <span>Usuario bd:</span><input type="text" name="db_user" /> <br />
    <span>Senha bd:</span><input type="text" name="db_pass" /> <br />
    <input type="submit" />
</form>
<?php
endif;
?>
</body>
</html>