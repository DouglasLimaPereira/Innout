<main class="content">
    <?php
        renderTitle('Registrar Ponto', 'Matenha seu ponto consistente!','icofont-check-alt');
        include(TEMPLATE_PATH . '/messages.php');
    ?>
    <div class="card">
        <div class="card-header">
            <h3> <?=$today?> </h3>
            <p class="mb-0">Os batimentos efetuados hoje</p>
        </div>
        <div class="card-body ml-0">
            <div class="d-flex m-3 justify-content-around">
                <span class="record">Entrada 1: 
                    <?php 
                        if($records->time1){
                            echo $records->time1;
                        }else {
                            echo '';
                        }
                    ?>
                </span>
                <span class="record">Saída 1: 
                    <?php 
                        if($records->time2){
                            echo $records->time2;
                        }else {
                            echo '';
                        }
                    ?>
                </span>
            </div>
            <div class="d-flex m-3 justify-content-around">
                <span class="record">Entrada 2: 
                    <?php 
                        if($records->time3){
                            echo $records->time3;
                        }else {
                            echo '';
                        }
                    ?>
                </span>
                <span class="record">Saída 2: 
                    <?php 
                        if($records->time4){
                            echo $records->time4;
                        }else {
                            echo '';
                        }
                    ?>
                </span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="innout.php" class="btn btn-success"> <i class="icofont-check mr-1"></i> Bater Ponto</a>
        </div>
    </div>
    <?php if ($user->is_admin) :?>
    <form class="mt-5" action="innout.php" method="post">
        <label for="simular_ponto">Simular Ponto</label>
        <div class="input-group no-border">
            <input id="simular_ponto" class="form-control" type="text" name="forcedTime" placeholder="Informe a hora para simular o batimento do ponto">
            <button class="btn btn-danger ml-3">Simular Ponto</button>
        </div>
    </form>
    <?php endif ?>
</main>