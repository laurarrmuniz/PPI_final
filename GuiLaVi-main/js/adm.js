$(document).ready(function() {
    console.log("Document ready. Initializing DataTable...");
    $('#userTable').DataTable();
});

function closeModal() {
    $('#editarModal').modal('hide');
    $('#cadastrarModal').modal('hide');
}

function abrirModalCadastro() {
    $('#cadastrarModal').modal('show');
}

function exibirPopupCadastro(message) {
    alert(message);
}

function editarUsuario(botao) {
    console.log("Editing user...");
    var userId = $(botao).data('id');
    $.ajax({
        type: 'POST',
        url: '../php/buscar_usuario.php',
        data: { id: userId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#editNome').val(response.usuario.nome);
                $('#editSobrenome').val(response.usuario.sobrenome);
                $('#editCpf').val(response.usuario.cpf);
                $('#editEmail').val(response.usuario.email);
                $('#editSenha').val(response.usuario.senha);
                $('#editInteresse').val(response.usuario.interesse);
                $('#editDesc').val(response.usuario.descricao);
                $('#editTipo').val(response.usuario.tipo);

                $('#editarModal').modal('show');
            } else {
                console.error('Error obtaining user details:', response.error);
                alert('Erro ao obter os detalhes do usuário');
            }
        },
        error: function (error) {
            console.error('AJAX request error:', error);
            alert('Erro de requisição AJAX');
            alert('Erro de requisição AJAX');
        }
    });
}

function editarTurma(botao) {
    console.log("Editing user...");
    var userId = $(botao).data('id');
    $.ajax({
        type: 'POST',
        url: '../php/buscar_turma.php',
        data: { id: userId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#editNome').val(response.turma.nome_turma);
                $('#editDes').val(response.turma.descricao);
                $('#editUsu').val(response.turma.id_usuario);

                $('#editarModal').modal('show');
            } else {
                console.error('Error obtaining user details:', response.error);
                alert('Erro ao obter os detalhes do usuário');
            }
        },
        error: function (error) {
            console.error('AJAX request error:', error);
            alert('Erro de requisição AJAX');
            alert('Erro de requisição AJAX');
        }
    });
}

function salvarEdicaoUsuario() {
    var nome = $('#editNome').val();
    var sobrenome = $('#editSobrenome').val();
    var cpf = $('#editCpf').val();
    var email = $('#editEmail').val();
    var senha = $('#editSenha').val();
    var interesse = $('#editInteresse').val();
    var descricao = $('#editDesc').val();
    var tipo = $('#editTipo').val();

    $.ajax({
        url: '../php/salvar_edicao_usuario.php',
        method: 'POST',
        data: {
            nome: nome,
            sobrenome: sobrenome,
            cpf: cpf,
            email: email,
            senha: senha,
            interesse: interesse,
            descricao: descricao,
            tipo: tipo
        },
        success: function (response) {
            closeModal()
            alert('Usuário editado!!!');
        },
        error: function (error) {
            console.error('Save error:', error);
            alert('Usuário com erro para editar!!');
        }
    });
}

function salvarEdicaoTurma() {
    var nome_turma = $('#editNome').val();
    var descricao = $('#editDes').val();
    var id_usuario = $('#editUsu').val();

    $.ajax({
        url: '../php/salvar_edicao_turma.php',
        method: 'POST',
        data: {
            nome_turma: nome_turma,
            descricao: descricao,
            id_usuario: id_usuario
        },
        success: function (response) {
            closeModal()
            alert('Turma editada!!!');
        },
        error: function (error) {
            console.error('Save error:', error);
            alert('Turma com erro para editar!!');
        }
    });
}

function salvarEdicaoAdm() {
    var nome = $('#editNome').val();
    var sobrenome = $('#editSobrenome').val();
    var cpf = $('#editCpf').val();
    var email = $('#editEmail').val();
    var senha = $('#editSenha').val();

    if (!nome || !sobrenome || !cpf || !email || !senha) {
        alert('Preencha todos os campos antes de salvar.');
        return;
    }

    $.ajax({
        url: '../php/salvar_edicao_adm.php',
        method: 'POST',
        data: {
            nome: nome,
            sobrenome: sobrenome,
            cpf: cpf,
            email: email,
            senha: senha
        },
        success: function (response) {
            closeModal();
            alert('Adm editado!!!');
        },
        error: function (error) {
            console.error('Save error:', error);
            alert('Adm com erro para editar!!');
        }
    });
}


function excluirUsuario(cpf) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        $.ajax({
            type: 'POST',
            url: '../php/excluir_usuario.php',
            data: { cpf: cpf },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert('Usuário excluído com sucesso!');
                } else {
                    alert('Erro ao excluir o usuário');
                }
            },
            error: function () {
                alert('Erro de requisição AJAX');
            }
        });
    }
}
function abrirModalCadastro() {
    $('#cadastrarModal').modal('show');
}

function fecharModalCadastro() {
    $('#cadastrarModal').modal('hide');
}

function cadastroUsuario() {
    var nome = $('#cadNome').val();
    var sobrenome = $('#cadSobrenome').val();
    var cpf = $('#cadCpf').val();
    var email = $('#cadEmail').val();
    var senha = $('#cadSenha').val();
    var interesse = $('#cadInteresse').val();
    var descricao = $('#cadDesc').val();
    var tipo = $('#cadTipo').val();

    $.ajax({
        url: '../php/cadastroUsuarioAdm.php',
        method: 'POST',
        data: {
            nome: nome,
            sobrenome: sobrenome,
            cpf: cpf,
            email: email,
            senha: senha,
            interesse: interesse,
            descricao: descricao,
            tipo: tipo
        },
        dataType: 'json',
        success: function (response) {
            console.log('Resposta do servidor:', response);

            if (response.success) {
                closeModal();
                alert('Usuário cadastrado com sucesso!!!');
            } else {
                console.error('Erro ao cadastrar usuário:', response.error);
                alert('Erro ao cadastrar usuário: ' + response.error);
            }
        },
        error: function (error) {
            console.error('Erro de requisição AJAX:', error);
            alert('Erro de requisição AJAX');
        }
    });
}

function cadastroTurma() {
    var nome_turma = $('#cadNome').val();
    var descricao = $('#cadDesc').val();
    var id_usuario = $('#cadUsu').val();

    $.ajax({
        url: '../php/cadastroUsuarioTurma.php',
        method: 'POST',
        data: {
            nome_turma: nome_turma,
            descricao: descricao,
            id_usuario: id_usuario
        },
        dataType: 'json',
        success: function (response) {
            console.log('Resposta do servidor:', response);

            if (response && response.success) {
                closeModal();
                alert('Usuário cadastrado na turma com sucesso!!!');
            } else {
                handleAjaxError(response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro de requisição AJAX:', xhr.responseText, status, error);
            handleAjaxError(xhr.responseText);
        },
        always: function (response) {
            console.log('Sempre:', response);
        }
    });
}

function handleAjaxError(response) {
    if (response) {
        try {
            // Tentar analisar a resposta como JSON
            var jsonResponse = JSON.parse(response);
            if (jsonResponse && jsonResponse.error) {
                console.error('Erro ao cadastrar usuário na turma:', jsonResponse.error);
                alert('Erro ao cadastrar usuário na turma: ' + jsonResponse.error);
            } else {
                console.error('Resposta do servidor não contém "success" ou "error":', jsonResponse);
                alert('Erro desconhecido ao cadastrar usuário na turma.');
            }
        } catch (e) {
            // Se a resposta não puder ser analisada como JSON
            console.error('Erro ao analisar resposta JSON:', e);
            alert('Erro ao analisar resposta do servidor.');
        }
    } else {
        console.error('Resposta vazia do servidor');
        alert('Erro desconhecido ao cadastrar usuário na turma.');
    }
}


