<main class="content">
    <?php
        renderTitle('Relatório Gerencial', 'Resumo das horas trabalhadas dos funcionários', 'icofont-chart-histogram');
    ?>
    
    <div class="summary-boxes">
        <div class="summary-box bg-primary">
            <i class="icon icofont-users"></i>
            <p class="title">Quantidade de funcionários</p>
            <h3 class="value"><?=$activeUsersCount?></h3>
        </div>

        <div class="summary-box bg-success">
            <i class="icon icofont-sand-clock"></i>
            <p class="title">Horas trabalhadas no mês</p>
            <h3 class="value"><?=$workedTimeInMonth?></h3>
        </div>

        <div class="summary-box bg-danger">
            <i class="icon icofont-patient-bed"></i>
            <p class="title">Qtd de funcionários ausêntes</p>
            <h3 class="value"><?=count($absentUsers)?></h3>
        </div>
    </div>

    <?php if(count($absentUsers) > 0 ): ?>
        <div class="card mt-4">
            <div class="card-header">
                <div class="card-title">Faltas do dia</div>
                <p class="card-category mb-0"> Relação dos funcionários que não bateram o ponto</p>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Funcionário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($absentUsers as $key => $nome): ?>
                            <tr>
                                <td><?= $nome ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</main>