<main class="content">
    <?php
        renderTitle('Relatório Mensal', 'Acompanhe seu saldo de horas', 'icofont-ui-calendar')
    ?>
    <div>
        <form class="mb-4" action="#" method="post">
            <div class="input-group">
                <?php if ($user->is_admin): ?>
                    <!-- <label for="user">Usuário</label> -->
                    <select id="user" name="user" class="form-control mr-2" placeholder="Selecione o Usuário...">
                        <option value="">Selecione um Usuário...</option>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?=$user->id?>" <?=($selectedUser === $user->id) ? 'selected' : ''?>><?= $user->name ?></option>
                        <?php endforeach?>
                    </select>
                <?php endif ?>
            
                <!-- <label for="period">Período</label> -->
                <select name="period" class="form-control" placeholder="Selecione o Período...">
                    <option value="">Selecione um Período...</option>
                    <?php foreach ($periods as $key => $month) : ?>
                        <option value="<?=$key?>" <?=($selectPeriod === $key) ? 'selected' : ''?>><?= $month ?></option>
                    <?php endforeach?>
                </select>
                <button class="btn btn-md btn-primary ml-2"> <i class="icofont-search"></i></button>
            </div>
        </form>

        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Dia</th>
                    <th scope="col">1° Entrada</th>
                    <th scope="col">1° Saída</th>
                    <th scope="col">2° Entrada</th>
                    <th scope="col">2° Saída</th>
                    <th scope="col">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($report as $key => $value): ?>
                    <tr>
                        <td><?= formatDateWithLocale($value->work_date, 'd/m/Y') ?></td>
                        <td><?= $value->time1 ?></td>
                        <td><?= $value->time2 ?></td>
                        <td><?= $value->time3 ?></td>
                        <td><?= $value->time4 ?></td>
                        <td><?= $value->getBalance() ?></td>
                    </tr>
                <?php endforeach ?>
                <tr class="bg-primary text-white">
                    <td>Horas Trabalhadas</td>
                    <td colspan="3"> <?=$sumOfWorkedTime?></td>
                    <td colspan="1"> Saldo Mensal</td>
                    <td colspan="1"> <?=$balance?></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>