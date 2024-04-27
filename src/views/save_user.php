<main class="content">
    <?php
        renderTitle('Cadastro de Usuários', 'Incluir Usuário', 'icofont-user');
        include(TEMPLATE_PATH . '/messages.php');
    ?>
    <form action='#' method='post'>
        <input type="hidden" name="id" value="<?= isset($id)?>">
        <div class='form-row needs-validation' novalidate>
            <div class='form-group col-md-6'>
                <label for='name'>Nome</label>
                <input class='form-control <?= isset($errors['name']) ? 'is-invalid' : ''?>' type='text' name='name' id='name' placeholder='Informe o nome'
                value='<?=isset($name) ? $name : ''?>'>
                <div class='invalid-feedback'>
                    <?=$errors['name']?>
                </div>
            </div>
            <div class='form-group col-md-6'>
                <label for='email'>E-mail</label>
                <input class='form-control <?= isset($errors['email']) ? 'is-invalid' : ''?>' type='email' name='email' id='email' placeholder='Informe seu E-mail'
                value='<?=isset($email) ? $email : ''?>'>
                <div class='invalid-feedback'>
                    <?=$errors['email']?>
                </div>
            </div>
        </div>
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='password'>Senha</label>
                <input class='form-control <?= isset($errors['password']) ? 'is-invalid' : ''?>' type='password' name='password' id='password' placeholder='Informe a Senha'>
                <div class='invalid-feedback'>
                    <?=$errors['password']?>
                </div>
            </div>
            <div class='form-group col-md-6'>
                <label for='confirm_password'>Confirmar a Senha</label>
                <input class='form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : ''?>' type='password' name='confirm_password' id='confirm_password' placeholder='Confirme a senha'>
                <div class='invalid-feedback'>
                    <?=$errors['confirm_password']?>
                </div>
            </div>
        </div>
        <div class='form-row'>
            <div class='form-group col-md-6'>
                <label for='start_date'>Data de Admissão</label>
                <input class='form-control <?= isset($errors['start_date']) ? 'is-invalid' : ''?>' type='date' name='start_date' id='start_date'
                value='<?=$start_date ? $start_date : ''?>'>
                <div class='invalid-feedback'>
                    <?=$errors['start_date']?>
                </div>
            </div>
            <div class='form-group col-md-6'>
            <label for='end_date'>Data de Desligamento</label>
                <input class='form-control <?= isset($errors['end_date']) ? 'is-invalid' : ''?>' type='date' name='end_date' id='end_date'
                value='<?=$end_date ? $end_date : ''?>'>
                <div class='invalid-feedback'>
                    <?=$errors['end_date']?>
                </div>
            </div>
        </div>
        <div class='form-check'>
            <input class='form-check-input <?= isset($errors['is_admin']) ? 'is-invalid' : ''?>' type='checkbox' name='is_admin' id='is_admin' 
            <?=isset($is_admin) ? 'checked' : ''?>>
            <label class='form-check-label' for='is_admin'>
                Administrador ?
            </label>
            <div class='invalid-feedback'>
                <?=$errors['is_admin']?>
            </div>
        </div>
        <div class='text-right'>
            <button class='btn btn-success'> 
                <i class='icofont-check'></i> Salvar
            </button>

            <a href='/users.php' class='btn btn-danger'> <i class='icofont-error'></i> Cancelar</a>
        </div>
    </form>
</main>