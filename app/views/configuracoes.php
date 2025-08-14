<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="configuracoes app fundo_circulo_invertido espaco-menu">

        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>index.php?url=home" class="voltar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <div class="lista bg-none">

            <div class="opcoes">
                <div class="circulo_opcoes">
                    <a href="<?php echo BASE_URL_APP ?>index.php?url=perfil">
                        <img src="<?php echo BASE_URL_APP ?>assets/img/perfil.svg" alt="perfil">Perfil
                    </a>
                </div>

                <div class="circulo_opcoes">
                    <a href="<?php echo BASE_URL_APP ?>index.php?url=contato">
                        <img src="<?php echo BASE_URL_APP ?>assets/img/contato.svg" alt="contato">Contato
                    </a>
                </div>
                
                <div class="circulo_opcoes">
                    <a href="<?php echo BASE_URL_APP ?>index.php?url=minhasOrdens">
                        <img src="<?php echo BASE_URL_APP ?>assets/img/iconeOrdem.svg" alt="Ordens de Serviço">Ordens de Serviço
                    </a>
                </div>

                <div class="circulo_opcoes">
                    <a href="<?php echo BASE_URL_APP; ?>index.php?url=login/sair">
                        <img src="<?php echo BASE_URL_APP ?>assets/img/sair.svg" alt="Sair">Sair
                    </a>
                </div>

            </div>

        </div>

    </section>

    <?php require_once("templates/menuNav.php") ?>

</body>



</html>