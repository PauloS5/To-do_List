<pre>
<?php
    require_once "../includes/connection.php";
    require_once "../classes/Task.php";

    // Estabelecendo conexão com o servidor
    Task::setConnection($dbh);

    // Instânciando Tarefas
    $tarefas = [];
    
    $tarefas[] = new Task;
    $tarefas[0]->title = "COMPRAR PAO";
    $tarefas[0]->description = "Comprar pao frances";
    
    $tarefas[] = new Task;
    $tarefas[1]->title = "COMPRAR ARROZ";
    $tarefas[1]->description = "Comprar arroz branco";
    
    $tarefas[] = new Task;
    $tarefas[2]->title = "COMPRAR CAFE";
    $tarefas[2]->description = "Comprar cafe sem cafeina";
    
    $tarefas[] = new Task;
    $tarefas[3]->title = "COMPRAR MACARRAO";
    $tarefas[3]->description = "Comprar macarrao vegano";
    
    $tarefas[] = new Task;
    $tarefas[4]->title = "COMPRAR LEITE";
    $tarefas[4]->description = "Comprar leite desnatado";
    
    $tarefas[] = new Task;
    $tarefas[5]->title = "COMPRAR ACUCAR";
    $tarefas[5]->description = "Comprar acucar mascavo";
    
    $tarefas[] = new Task;
    $tarefas[6]->title = "COMPRAR FARINHA";
    $tarefas[6]->description = "Comprar farinha de trigo";
    
    $tarefas[] = new Task;
    $tarefas[7]->title = "COMPRAR OLEO";
    $tarefas[7]->description = "Comprar oleo de girassol";
    
    $tarefas[] = new Task;
    $tarefas[8]->title = "COMPRAR MANTEIGA";
    $tarefas[8]->description = "Comprar manteiga sem sal";
    
    $tarefas[] = new Task;
    $tarefas[9]->title = "COMPRAR QUEIJO";
    $tarefas[9]->description = "Comprar queijo mussarela";
    
    $tarefas[] = new Task;
    $tarefas[10]->title = "COMPRAR PRESUNTO";
    $tarefas[10]->description = "Comprar presunto magro";
    
    $tarefas[] = new Task;
    $tarefas[11]->title = "COMPRAR TOMATE";
    $tarefas[11]->description = "Comprar tomate italiano";
    
    $tarefas[] = new Task;
    $tarefas[12]->title = "COMPRAR CEBOLA";
    $tarefas[12]->description = "Comprar cebola roxa";
    
    $tarefas[] = new Task;
    $tarefas[13]->title = "COMPRAR ALFACE";
    $tarefas[13]->description = "Comprar alface crespa";
    
    $tarefas[] = new Task;
    $tarefas[14]->title = "COMPRAR MACA";
    $tarefas[14]->description = "Comprar maca fuji";
    
    $tarefas[] = new Task;
    $tarefas[15]->title = "COMPRAR BANANA";
    $tarefas[15]->description = "Comprar banana nanica";
    
    $tarefas[] = new Task;
    $tarefas[16]->title = "COMPRAR LARANJA";
    $tarefas[16]->description = "Comprar laranja pera";
    
    $tarefas[] = new Task;
    $tarefas[17]->title = "COMPRAR PEIXE";
    $tarefas[17]->description = "Comprar file de tilapia";
    
    $tarefas[] = new Task;
    $tarefas[18]->title = "COMPRAR CARNE";
    $tarefas[18]->description = "Comprar carne moida";
    
    $tarefas[] = new Task;
    $tarefas[19]->title = "COMPRAR OVOS";
    $tarefas[19]->description = "Comprar ovos caipiras";
    
    
    
    // Cadastrando tarefas
    foreach ($tarefas as $tarefa) {
        $tarefa->register();
        echo "Tarefa Cadastrada!<br>";
        echo "id: " . $tarefa->id . "<br><br>";
    }