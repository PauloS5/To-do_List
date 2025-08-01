<?php
    require_once '../includes/connection.php';
    require_once '../classes/Task.php';

    // Estabelecendo a conexão com o banco de dados
    Task::setConnection($dbh);
    $task = new Task();

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            // Definindo o cabeçalho
            header("Content-Type: application/xml; charset=utf-8");

            // Instânciando um objeto XML
            $sxe = new SimpleXMLElement("<tasks></tasks>");

            // Verificando se o id foi passado
            // Caso sim: buscando um item específico na tabela
            // Caso não: buscando todos os itens da tabela
            if (isset($_GET["id"])) {
                // Extraindo dados da URL
                $task->id = $_GET["id"];

                // Realizando a busca
                $result = $task->find();

                // Verificando se há algum item com o id informado
                if ($result != null) {
                    // Extraindo resultado da busca
                    $xmlTask = $sxe->addChild('task');
                    $xmlTask->addAttribute('id', $result["id"]);
                    $xmlTask->addAttribute('title', $result["title"]);
                    $xmlTask->addAttribute('description', $result["description"]);
                    $xmlTask->addAttribute('status', $result["status"]);
                } else {
                    http_response_code(404);
                    die();
                }

            } else {
                // Realizando a busca
                $result = Task::findAll();

                // Extraindo o resultado da busca
                foreach ($result as $task) {
                    $xmlTask = $sxe->addChild('task');
                    $xmlTask->addAttribute('id', $task["id"]);
                    $xmlTask->addAttribute('title', $task["title"]);
                    $xmlTask->addAttribute('description', $task["description"]);
                    $xmlTask->addAttribute('status', $task["status"]);
                }
            }

            // Exibindo resultado
            echo $sxe->asXML();
            http_response_code(200);
            break;

        case "POST":
            // Verificando os parâmetros do corpo da requisição
            if (
                !(isset($_POST["title"]) &&
                    isset($_POST["description"]))
            ) {
                http_response_code(400);
                die();
            }

            // Extraindo dados da super global $_POST
            $task->title =  $_POST['title'];
            $task->description = $_POST['description'];

            // Registrando
            $task->register();
            http_response_code(201);
            break;

        case "PUT":
            // Extraindo dados do corpo da requisição e os pondo em um array
            parse_str(file_get_contents("php://input"), $put_vars);

            // Verificando os parâmetros do corpo da requisição
            if (
                !(isset($put_vars['id']) &&
                    isset($put_vars['title']) &&
                    isset($put_vars['description']) &&
                    isset($put_vars['status']))
            ) {
                http_response_code(400);
                exit();
            }

            // Extraindo dados do array
            $task->id = $put_vars['id'];
            $task->title =  $put_vars['title'];
            $task->description = $put_vars['description'];
            $task->status = $put_vars['status'];

            // Verificando se o elemento existe
            if ($task->find() == null) {
                http_response_code(404);
                die();
            }

            // Atualizando
            $task->update();
            http_response_code(202);
            break;

        case "DELETE":
            // Extraindo dados do corpo da requisição e pondo em um array
            parse_str(file_get_contents("php://input"), $delete_vars);

            // Verificando os parâmetros do corpo da requisição
            if (!isset($delete_vars['id'])) {
                http_response_code(400);
                die();
            }

            // Extraindo os valores para manipulação
            $task->id = $delete_vars["id"];

            // Apagando registro do banco de dados
            $task->delete();

            // Verificando se o registro foi apagado
            if($task->find() == null) {
                http_response_code(204);
            } else {
                http_response_code(500);
            }
            break;

        default:
            http_response_code(405);
            die();
    }