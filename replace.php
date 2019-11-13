<html>
    <head>
        <meta charset="UTF-8" />
        <title>Instalador</title>
        <link href="bootstrap-4.1.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="fontawesome-5.11.2/css/all.css" rel="stylesheet" type="text/css"/>
        <link href="replace.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
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

        $acao = @$_REQUEST['acao'];
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
            file_put_contents($path_to_new_file, $file_contents);

            try {
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

                echo '<div class="pt-5 text-center">       
                        <h1 class="form-signin-heading" style="color: #cc3366">Sistema Inclua</h1>
                        <h3 style="color: #777">Instalador</h3>
                    </div>
                    <div class="container wrapper d-flex justify-content-center">
                            <div class="card w-75 text-center">
                                <div class="card-body">

                                    <h5 class="card-title" style="color: #373278">Sistema Inclua instalado com sucesso.</h5><br>
                                    <span class="pr-2">
                                        <a href="replace.php" class="btn btn-secondary">Voltar</a>
                                    </span>
                                    <a href="index.php" class="btn btn-primary" style="background: #3ba1da">Acessar o Inclua</a><br><br>

                                    <h5 class="card-title" style="color: #373278">Acesso à área administrativa:</h5>
                                    <div class="d-flex justify-content-center pb-2"><div class="border w-25">Nome de usuário: <i>admin</i> <br> Senha: <i>admin</i></div></div>
                                    <p>Ao entrar, favor <b>alterar</b> a senha</p>
                                    <a href="../inclua_v2/?page_id=339" class="btn btn-primary" style="background: #3ba1da">Entrar como administrador</a>  

                                </div>
                            </div>
                    </div>';
            } catch (\PDOException $e) {
                echo '<div class="pt-5 text-center">       
                        <h1 class="form-signin-heading" style="color: #cc3366">Sistema Inclua</h1>
                        <h3 style="color: #777">Instalador</h3>
                    </div>
                    <div class="container wrapper d-flex justify-content-center">
                            <div class="card w-75 text-center">
                                <div class="card-body">

                                    <h5 class="card-title" style="color: #373278">Infelizmente não foi possível instalar o sistema Inclua.<br>
                                    Por favor, tente novamente.</h5>
                                    <span class="pr-2">
                                        <a href="replace.php" class="btn btn-secondary">Voltar</a>
                                    </span> 

                                </div>
                            </div>
                    </div>';
            }
            
        else:
        ?>
        <div class="pt-5 text-center">       
            <h1 class="form-signin-heading" style="color: #cc3366">Sistema Inclua</h1>
            <h3 style="color: #777">Instalador</h3>
        </div>

        <div class="wrapper">
            <form class="form-signin form-inline justify-content-center" action="replace.php?acao=enviar" method="post">

                <div class="p-3">
                    <h4 style="color: #373278">Dados do banco:</h4>
                </div>
                
                <input type="text" class="form-control" name="db_host" placeholder="Host" required autofocus />
                <span title="Endereço de hospedagem do banco">
                    &nbsp&nbsp<i class="fas fa-question-circle" style="color: #373278"></i>
                </span>
                            
                <input type="text" class="form-control" name="db_name" placeholder="Nome" required />
                <span title="Nome do banco de dados ( já criado e hospedado )">
                    &nbsp&nbsp<i class="fas fa-question-circle" style="color: #373278"></i>
                </span>
            
                <input type="text" class="form-control" name="db_user" placeholder="Usuário" required />
                <span title="Nome do usuário que tem acesso ao banco">
                    &nbsp&nbsp<i class="fas fa-question-circle" style="color: #373278"></i>
                </span>
            
                <input type="password" class="form-control" name="db_pass" placeholder="Senha" required />
                <span title="Senha do usuário que tem acesso ao banco">
                    &nbsp&nbsp<i class="fas fa-question-circle" style="color: #373278"></i>
                </span>

                <div class="pt-4">
                    <button class="btn btn-lg btn-primary" type="submit" style="background: #3ba1da">Instalar</button>
                </div>
            </form>
        </div>
        
        <?php
        endif;
        ?>

        <script src="jquery/jquery-3.4.1.js" type="text/javascript"></script>
        <script src="bootstrap-4.1.3/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="bootstrap-4.1.3/site/docs/4.1/assets/js/vendor/popper.min.js" type="text/javascript"></script>
    </body>
</html>