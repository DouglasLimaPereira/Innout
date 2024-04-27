<main class="content">
    <?php
        renderTitle('Registro de Usuários', 'Informações dos Usuários', 'icofont-users');
        include(TEMPLATE_PATH . '/messages.php');
    ?>
    <div>
        <!-- <form class="mb-4" action="#" method="post">
            <div class="input-group">
                <?php if ($user->is_admin): ?>
                    <!- - <label for="user">Usuário</label> - ->
                    <select id="user" name="user" class="form-control mr-2" placeholder="Selecione o Usuário...">
                        <option value="">Selecione um Usuário...</option>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?=$user->id?>" <?=($selectedUser === $user->id) ? 'selected' : ''?>><?= $user->name ?></option>
                        <?php endforeach?>
                    </select>
                <?php endif ?>
            
                <!- - <label for="period">Período</label> - ->
                <select name="period" class="form-control" placeholder="Selecione o Período...">
                    <option value="">Selecione um Período...</option>
                    <?php foreach ($periods as $key => $month) : ?>
                        <option value="<?=$key?>" <?=($selectPeriod === $key) ? 'selected' : ''?>><?= $month ?></option>
                    <?php endforeach?>
                </select>
                <button class="btn btn-md btn-primary ml-2"> <i class="icofont-search"></i></button>
            </div>
        </form> -->
        <div class="text-right">
            <a href="save_user.php" class="btn btn-primary"><i class="icofont-ui-add"></i> Novo Usuário</a>
        </div>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Data de início</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $key => $row): ?>
                    <tr>
                        <td><?= $row->id ?></td>
                        <td><?= $row->name ?></td>
                        <td><?= $row->email ?></td>
                        <td><?= formatDateWithLocale($row->start_date, 'd/m/Y') ?></td>
                        <td>
                            <a href="save_user.php?update=<?=$row->id?>"
                                class="btn btn-success rounded-circle mr-2">
                                <i class="icofont-edit"></i>
                            </a>
                            <a href="?delete=<?=$row->id?>" 
                                class="btn btn-danger rounded-circle">
                                <i class="icofont-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>