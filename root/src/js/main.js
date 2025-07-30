function main() {
    loadList(findAllTasks());

    // Botões
    // Atualizar
    $("#reload").click(function() {
        loadList(findAllTasks());
    });
    // Nova Task
    $("#newTask").on({
        click: function() {
            let title = $("#in-title").val();
            let desc = $("#in-description").val();

            if(title === "" || title === null) {
                alert("Campo 'Título' vazio");
            } else {
                let modalElement = document.getElementById('modalRegister');
                let modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modalElement);
                }

                addTask(title, desc);
                loadList(findAllTasks());
                modalInstance.hide()
            }
        }
    });
    // TODO Editar valores
    $("#updateTask").on({
        click: function() {

        }
    });
    // Finalizar tarefa (Usando delegação de eventos)
    $("#taskList").on("click", ".finish-task", function() {
        let id = $(this).val()
        let data = findAllTasks()

        modifyTask(id, data[id]["title"], data[id]["description"], "finished");
        loadList(findAllTasks());
    });
    // TODO Excluir tarefa
}
$(document).ready(function() {
    main();
})

function loadList(tasks) {
    // Selecionando elementos
    let taskList = $("#taskList");

    // Limpando o elemento
    taskList.html("");

    for (let i in tasks) {
        let el = tasks[i];
        taskList.append(
            `<!-- AFAZER ${i} -->\n` +
            `<div id=\"item${i}\" class=\"py-2\">\n` +
            `    <!-- CABEÇALHO -->\n` +
            `    <div class=\"d-flex justify-content-between px-4\">\n` +
            `        <!-- DIVISÃO À ESQUERDA -->\n` +
            `        <div class=\"d-flex flex-row gap-3\">\n` +
            `            <!-- BOTÃO PARA FINALIZAR TAREFA -->\n` +
            ((el["status"] !== "finished") ? (`<button class=\"btn btn-outline-success fw-semibold bi bi-check-lg px-3 finish-task\" value=\"${i}\"></button>\n`) : (`<button class=\"btn btn-success fw-semibold bi bi-check-lg px-3\" value="${i}" disabled></button>\n`)) +
            `            <!-- TÍTULO -->\n` +
            `            <h2 id=\"task-${i}\" class=\"fs-2 fw-semibold\">\n` +
            `                ${el["title"]}\n` +
            `            </h2>\n` +
            `        </div>\n` +
            `\n` +
            `         <!-- BOTÕES -->\n` +
            `         <div>\n` +
            `             ` +
            ((el["status"] !== "finished") ? (`<button class="btn btn-warning bi bi-pencil-square text-light"> Editar</button>`) : (``)) +
            `             <button class=\"btn btn-danger bi bi-trash3-fill\"> Apagar</button>\n` +
            `             <button class=\"btn btn-primary\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#desc${i}\" aria-expanded=\"false\" aria-controls=\"desc${i}\">Descrição <i class=\"bi bi-caret-down-fill\"></i></button>\n` +
            `         </div>\n` +
            `     </div>\n` +
            `     <!-- DESCRIÇÃO -->\n` +
            `     <div class=\"collapse\" id=\"desc${i}\">\n` +
            `         <div class=\"d-flex text-start fs-5 px-4\">\n` +
            `             ${el["description"]}\n` +
            `         </div>\n` +
            `     </div>\n` +
            ` </div>`
        );
    }
}

function addTask(title, description) {
    $.ajax({
        url: "https://localhost/projects/todo_list/root/php/actions/TaskAPI.php",
        type: "POST",
        data: {
            "title": title,
            "description": description
        },
        success: function () {
            alert("Nova tarefa cadastrada com sucesso!");
        },
        error: function () {
            alert("Falha ao cadastrar uma nova tarefa");
        },
    })
}
function findAllTasks() {
    let data = {};

    // Realizando a requisição
    $.ajax({
            url: "https://localhost/projects/todo_list/root/php/actions/TaskAPI.php",
            type: "GET",
            dataType: "xml",
            async: false,
            success: function (resultXML) {
                // Convertendo o resultado da API em um array de elementos DOM
                let result = $(resultXML).find('task');

                // Convertendo o resultado em um array associativo
                result.each(function (i, el) {
                    data[$(el).attr('id')] = {
                        "title": ($(el).attr('title')),
                        "description": ($(el).attr('description')),
                        "status": ($(el).attr('status'))
                    };
                });
            },
            error: function () {
                alert("ERRO");
            }
        }
    )

    return data;
}
function modifyTask(id, title, description, status) {
    $.ajax({
        url: "https://localhost/projects/todo_list/root/php/actions/TaskAPI.php",
        type: "PUT",
        data: {
            "id": id,
            "title": title,
            "description": description,
            "status": status
        },
        success: function () {
            alert("Tarefa modificada com sucesso!");
        },
        error: function () {
            alert("Falha ao modificar uma tarefa");
        }
    })
}
function deleteTask(id) {
    $.ajax({
        url: "https://localhost/projects/todo_list/root/php/actions/TaskAPI.php",
        type: "DELETE",
        data: {
            "id": id
        },
        success: function () {
            alert("Tarefa excluída com sucesso!");
        },
        error: function () {
            alert("Falha ao cadastrar uma nova tarefa");
        }
    })
}