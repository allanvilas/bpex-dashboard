<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>
<div class="container">
    
    <!-- Modal de Alteração de Senha -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Alterar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" method="POST" action="/pages/usuarios/updatePassword">
                        <input type="hidden" name="id" id="userId">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                        </div>
                        <div id="passwordError" class="text-danger"></div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <h3>Cadastrar de Usuários</h3>
            <form id="registerForm" method="POST" action="/pages/usuarios/create" hx-post="/pages/usuarios/create" hx-target="#message" hx-swap="innerHTML">
                <div class="row g-3">
                    <!-- Nome e Sobrenome -->
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                        <div id="nomeError" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="sobrenome" class="form-label">Sobrenome:</label>
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
                        <div id="sobrenomeError" class="text-danger"></div>
                    </div>
            
                    <!-- Acesso e Senha -->
                    <!-- <div class="col-md-6" style="display=none;">
                        <label for="username" class="form-label">Acesso:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div> -->
        
                    <div class="col-md-6">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="userPassword" name="password" required>
                        <div id="passwordError" class="text-danger"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="confirmPassword" class="form-label">Confirmar Senha:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        <div id="confirmPasswordError" class="text-danger"></div>
                    </div>
            
                    <!-- Email e Role -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div id="emailError" class="text-danger"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role:</label>
                        <!-- <input type="text" class="form-control" id="role" name="role"> -->
                        <select class="form-select" aria-label="Default select example" name="role" id="role">
                        <?php foreach (json_decode($roles,true) as $allRoles): ?>
                            <?php foreach ($allRoles as $role): ?>
                                <option value="<?= esc($role['role']) ?>"><?= esc($role['role']) ?></option>
                            <?php endforeach; ?>
                        <?php endforeach; ?>                
                        </select>
                    </div>
                </div>
            
                <!-- Botão -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Criar Usuário</button>
                    <div id="message"></div>
                    <?php if (session()->has('errors')): ?>
                        <div>
                            <ul>
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>        
                </div>
            </form>
        </div>
    </div>

    <hr class="m-8">

    <div class="row">
        <div class="col-12">
            <h3>Lista de Usuários</h3>
            <!-- Tabela de Usuários -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (json_decode($users,true) as $allUser): ?>
                        <?php foreach ($allUser as $user): ?>
                            <tr>
                                <td><?= esc($user['id']) ?></td>
                                <td><?= esc($user['nome']) ?></td>
                                <td><?= esc($user['sobrenome']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['role']) ?></td>
                                <td>
                                    <!-- Botão para deletar o usuário -->
                                    <form method="POST" action="/pages/usuarios/delete/<?= esc($user['id']) ?>" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                                    </form>
                                    
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal" data-id="<?= esc($user['id']) ?>"">
                                        Alterar Senha
                                    </button>                                   
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
    const nome = document.getElementById('nome');
    const sobrenome = document.getElementById('sobrenome');
    const email = document.getElementById('email');
    const password = document.getElementById('userPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    // Função de validação do nome
    nome.addEventListener('input', function () {
        if (nome.value.trim() === '') {
            document.getElementById('nomeError').textContent = 'O nome é obrigatório.';
        } else {
            document.getElementById('nomeError').textContent = '';
        }
    });

    // Função de validação do sobrenome
    sobrenome.addEventListener('input', function () {
        if (sobrenome.value.trim() === '') {
            document.getElementById('sobrenomeError').textContent = 'O sobrenome é obrigatório.';
        } else {
            document.getElementById('sobrenomeError').textContent = '';
        }
    });

    // Função de validação do email
    email.addEventListener('input', function () {
        const emailValue = email.value;
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(emailValue)) {
            document.getElementById('emailError').textContent = 'Por favor, insira um e-mail válido.';
        } else {
            document.getElementById('emailError').textContent = '';
        }
    });

    // Função de validação da senha
    password.addEventListener('input', function () {
        const passwordValue = password.value;
        if (passwordValue.length < 6) {
            document.getElementById('passwordError').textContent = 'A senha deve ter pelo menos 6 caracteres.';
        } else {
            document.getElementById('passwordError').textContent = '';
        }
    });

    // Função de validação de confirmação de senha
    confirmPassword.addEventListener('input', function () {
        if (confirmPassword.value !== password.value) {
            document.getElementById('confirmPasswordError').textContent = 'As senhas não coincidem.';
        } else {
            document.getElementById('confirmPasswordError').textContent = '';
        }
    });

    // Submissão do formulário (validação final)
    form.addEventListener('submit', function (event) {
        // Verifica se algum campo obrigatório não foi preenchido
        if (nome.value.trim() === '' || sobrenome.value.trim() === '' || email.value.trim() === '' || password.value.trim() === '' || confirmPassword.value.trim() === '') {
            event.preventDefault(); // Impede o envio do formulário
            alert('Todos os campos são obrigatórios.');
        }

        // Verifica se houve erro de confirmação de senha
        if (confirmPassword.value !== password.value) {
            event.preventDefault(); // Impede o envio do formulário
            alert('As senhas não coincidem.');
        }
    });
});
</script>
<?= $this->endSection() ?>