    <nav>
        <a href="<?php echo $this->route("") ?>" class="logo"><img src="http://<?php echo APP_HOST ?>/resources/assets/img/logo.png" /> PETMonitor</a>
<?php if($acesso::estaLogado()): ?>
        <div id="menu-toggle" style="">
            <button class="btn-sem-borda" onclick="$('#menu').toggle()"><i class="fas fa-bars fa-2x"></i></button>
        </div>
        <ul id="menu">
            <li><a href="<?php echo $this->route("pets") ?>"><i class="fas fa-paw"></i> PETs</a></li>
            <li><a href="<?php echo $this->route("rastreadores") ?>"><i class="fas fa-crosshairs"></i> Rastreadores</a></li>
            <li><a href="javascript:void(0);"><i class="fas fa-user-circle"></i> <?php echo $usuario ?></a> <ul>
                <li><a href="<?php echo $this->route("conta") ?>"><i class="fas fa-user fa-sm" style="position:relative;top:-2px;"></i> Conta</a></li>
                <li><a href="<?php echo $this->route("index/sair") ?>"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
            </ul></li>
        </ul>

<?php endif; ?>

    </nav>
    
    <main>

<?php if ($mensagem::temMensagem("geral")) : ?>
    <div id="alerta-geral" class="alert-box alert-box-<?= $mensagem::obterMensagem("geral")["tipo"] ?> alert-<?= $mensagem::obterMensagem("geral")["tipo"] ?>">
        <i class="fas fa-<?= $mensagem::obterMensagem("geral")["tipo"] == "erro" ? "times" :"check-circle" ?>"></i>
        <?= $mensagem::obterMensagem("geral")["msg"] ?>
        <a onclick="javascript:fechar('div#alerta-geral');" style="float:right;"><i class="fas fa-times fa-lg"></i></a>
    </div>
<?php endif; ?>
