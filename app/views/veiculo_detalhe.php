<!DOCTYPE html>

<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="cadastro_veiculo app fundo_circulo espaco-menu">

        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>index.php?url=veiculos" class="voltar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <div class="logo_wave">
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_wave.svg" alt="logo_wave">
        </div>

        <div id="loading" class="spinner-overlay">
            <div class="spinner"></div>
            <p class="loading-text">Aguarde, processando...</p>
        </div>

        <div class="formulario bg-none">

            <form id="formVeiculo" action="<?= BASE_URL_APP ?>index.php?url=veiculos/atualizarVeiculo/<?= $veiculo['id_veiculo'] ?>" method="POST">

                <div class="input_grupo">
                    <h2>Detalhes do Veículo</h2>

                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria" required>
                        <option value="" disabled <?= empty($veiculo['categoria_veiculo']) ? 'selected' : '' ?>>Selecione</option>
                        <option value="Carro" <?= ($veiculo['categoria_veiculo'] == 'Carro') ? 'selected' : '' ?>>Carro</option>
                        <option value="Moto" <?= ($veiculo['categoria_veiculo'] == 'Moto') ? 'selected' : '' ?>>Moto</option>
                        <option value="Caminhão" <?= ($veiculo['categoria_veiculo'] == 'Caminhão') ? 'selected' : '' ?>>Caminhão</option>
                    </select>

                    <label for="marca">Marca:</label>
                    <input class="maiusculo" type="text" id="marca" name="marca" value="<?= $veiculo['marca_veiculo'] ?>" required>

                    <label for="modelo">Modelo:</label>
                    <input class="maiusculo" type="text" id="modelo" name="modelo" value="<?= $veiculo['modelo_veiculo'] ?>" required>

                    <label for="ano">Ano:</label>
                    <input type="text" id="ano" name="ano" value="<?= $veiculo['ano_veiculo'] ?>" required>

                    <label for="placa">Placa:</label>
                    <input class="maiusculo" type="text" id="placa" name="placa" value="<?= $veiculo['placa_veiculo'] ?>" required>

                    <label for="chassi">Chassi:</label>
                    <input class="maiusculo" type="text" id="chassi" name="chassi" value="<?= $veiculo['chassi_veiculo'] ?>" required>

                    <label for="cor">Cor:</label>
                    <input class="maiusculo" type="text" id="cor" name="cor" value="<?= $veiculo['cor_veiculo'] ?>" required>

                    <div class="button_senha">
                        <button class="btn_app" type="submit" style="text-transform: uppercase;">Editar Veículo</button>
                    </div>
                </div>
            </form>

            <div id="msg-resposta" class="msg-resposta">
                <?php
                if (isset($_SESSION['msg-sucesso'])) {
                    echo '<p class="msg-sucesso">' . $_SESSION['msg-sucesso'] . '</p>';
                    unset($_SESSION['msg-sucesso']);
                }

                if (isset($_SESSION['msg-erro'])) {
                    echo '<p class="msg-erro">' . $_SESSION['msg-erro'] . '</p>';
                    unset($_SESSION['msg-erro']);
                }
                ?>
            </div>

        </div>

    </section>

    <?php require_once("templates/menuNav.php") ?>

    <script src="<?= BASE_URL_APP ?>assets/js/mascaras.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ano = document.getElementById('ano');
            const placa = document.getElementById('placa');
            const cor = document.getElementById('cor');
            const chassi = document.getElementById('chassi');
            const form = document.getElementById('formVeiculo');
            const msgResposta = document.getElementById('msg-resposta');
            const loading = document.getElementById('loading');

            // MÁSCARAS
            ano.addEventListener('input', () => {
                if (ano.value.length > 4) ano.value = ano.value.slice(0, 4);
            });

            placa.addEventListener('input', () => mascaraPlaca(placa));
            cor.addEventListener('input', () => mascaraNome(cor));
            chassi.addEventListener('input', () => mascaraChassi(chassi));

            // VALIDAÇÃO DO FORMULÁRIO
            form.addEventListener('submit', function(event) {
                let valido = true;
                let primeiroErro = null;
                let mensagemErro = "";

                const camposValidar = [{
                        id: 'categoria',
                        nome: 'Categoria'
                    },
                    {
                        id: 'marca',
                        nome: 'Marca'
                    },
                    {
                        id: 'modelo',
                        nome: 'Modelo'
                    },
                    {
                        id: 'ano',
                        nome: 'Ano',
                        custom: el => {
                            const v = el.value.trim();
                            return v.length === 0 || v.length === 4 ? null : "O campo <strong>Ano</strong> deve ter 4 dígitos.";
                        }
                    },
                    {
                        id: 'placa',
                        nome: 'Placa',
                        custom: el => {
                            const v = el.value.trim();
                            return v.length === 0 || v.length >= 8 ? null : "O campo <strong>Placa</strong> deve conter no mínimo 8 caracteres.";
                        }
                    },
                    {
                        id: 'chassi',
                        nome: 'Chassi',
                        custom: el => {
                            const v = el.value.trim();
                            return v.length === 0 || v.length === 17 ? null : "O campo <strong>Chassi</strong> deve conter 17 caracteres.";
                        }
                    },
                    {
                        id: 'cor',
                        nome: 'Cor'
                    }
                ];

                camposValidar.forEach(item => {
                    const el = document.getElementById(item.id);
                    const valor = el?.value.trim();

                    // Limpa estilos anteriores
                    el.style.border = '';

                    // Verifica se está vazio
                    if (!valor) {
                        el.style.border = '2px solid red';
                        if (!primeiroErro) {
                            primeiroErro = el;
                            mensagemErro = `O campo <strong>${item.nome}</strong> é obrigatório.`;
                        }
                        valido = false;
                    }

                    // Validações personalizadas
                    else if (item.custom) {
                        const erro = item.custom(el);
                        if (erro) {
                            el.style.border = '2px solid red';
                            if (!primeiroErro) {
                                primeiroErro = el;
                                mensagemErro = erro;
                            }
                            valido = false;
                        }
                    }
                });

                if (!valido) {
                    event.preventDefault();
                    if (primeiroErro) primeiroErro.focus();
                    msgResposta.classList.add('show-erro');
                    msgResposta.innerHTML = `<p class="msg-erro">${mensagemErro}</p>`;
                    setTimeout(() => {
                        msgResposta.innerHTML = "";
                        msgResposta.classList.remove('show-erro');
                    }, 5000);
                } else {
                    // Exibe loading
                    if (loading) loading.style.display = 'flex';
                }
            });

            // MENSAGEM DE RESPOSTA DA API
            if (msgResposta && msgResposta.innerHTML.trim() !== "") {
                const isSucesso = msgResposta.querySelector('.msg-sucesso');
                const isErro = msgResposta.querySelector('.msg-erro');

                msgResposta.classList.add(isSucesso ? 'show-sucesso' : 'show-erro');

                setTimeout(() => {
                    msgResposta.classList.remove('show-sucesso', 'show-erro');
                    msgResposta.innerHTML = "";
                    if (loading) loading.style.display = 'none';
                }, 5000);
            } else {
                if (loading) loading.style.display = 'none';
            }
        });
    </script>

</body>

</html>