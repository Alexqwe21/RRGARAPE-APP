<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="perfil_cliente app espaco-menu">

        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>index.php?url=home" class="voltar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <?php
        $imagemPadrao = BASE_FOTO . '/galeria/sem_foto.png';

        // Verifica se existe uma imagem cadastrada para o cliente
        $fotoCliente = !empty($cliente['foto_cliente']) ?
            BASE_FOTO . '/' . $cliente['foto_cliente'] :
            $imagemPadrao;
        ?>

        <div class="logo_wave">
            <img src="<?php echo BASE_URL_APP ?>assets/img/fundo_wave.svg" alt="fundo espadas">

            <div class="foto_cliente">
                <img src="<?= $fotoCliente ?>" alt="<?= $cliente['alt_cliente'] ?? 'foto cliente' ?>" id="imgCliente" style="cursor: pointer;">
            </div>
        </div>

        <div id="loading" class="spinner-overlay">
            <div class="spinner"></div>
            <p class="loading-text">Aguarde, processando...</p>
        </div>

        <div class="formulario">
            <h2 class="titulo">Perfil</h2>

            <form method="POST" enctype="multipart/form-data">
                <input type="file" id="inputFotoCliente" name="foto_cliente" accept="image/*" capture="camera" style="display: none;">
                <div class="input_grupo">

                    <!-- NOME -->
                    <label for="nome"> Nome Completo:
                        <input class="maiusculo" type="text" name="nome" id="nome" required value="<?= $cliente['nome_cliente'] ?? '' ?>">
                    </label>

                    <!-- EMAIL -->
                    <label for="email">Email:
                        <input type="email" name="email" id="email" required value="<?= $cliente['email_cliente'] ?? '' ?>" readonly>
                    </label>

                    <!-- TIPO PESSOA FISICA/JURIDICA -->
                    <label for="tipo_cliente">Tipo:</label>
                    <select name="tipo_cliente" id="tipo_cliente" required>
                        <option value="">Selecione...</option>
                        <option value="Pessoa Física" <?= $cliente['tipo_cliente'] == 'Pessoa Física' ? 'selected' : '' ?>>Pessoa Física</option>
                        <option value="Pessoa Jurídica" <?= $cliente['tipo_cliente'] == 'Pessoa Jurídica' ? 'selected' : '' ?>>Pessoa Jurídica</option>
                    </select>

                    <!-- CPF/CNPJ -->
                    <label for="cpf_cnpj">CPF/CNPJ:
                        <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="<?= $cliente['cpf_cnpj_cliente'] ?? '' ?>">
                    </label>

                    <!-- TELEFONE -->
                    <label for="telefone">Telefone:
                        <input type="tel" id="telefone" name="telefone" required value="<?= $cliente['telefone_cliente'] ?? '' ?>">
                    </label>

                    <!-- DATA DE NASCIMENTO -->
                    <label for="dataNascimento">Data de Nascimento:
                        <input type="date" max="<?= date('Y-m-d') ?>" min="1900-01-01" id="dataNascimento" name="dataNascimento" value="<?= $cliente['data_nasc_cliente'] ?? '' ?>">
                    </label>

                    <h2 class="titulo">Endereço</h2>

                    <!-- CEP -->
                    <div>
                        <label for="cep">CEP:
                            <input type="text" id="cep" name="cep" maxlength="8">
                        </label>
                        <button class="btn_app" type="button" id="btnBuscarCep">BUSCAR</button>
                    </div>

                    <?php
                    // Endereço e Número
                    $partes = explode(',', $cliente['endereco_cliente'] ?? '');
                    ?>

                    <!-- LOGRADOURO -->
                    <label for="logradouro">Logradouro:
                        <input type="text" id="logradouro" name="logradouro" value="<?= $partes[0] ?? '' ?>" readonly>
                    </label>

                    <!-- BAIRRO -->
                    <label for="bairro">Bairro:
                        <input type="text" id="bairro" name="bairro" value="<?= trim($cliente['bairro_cliente'] ?? '') ?>" readonly>
                    </label>

                    <!-- CIDADE -->
                    <label for="cidade">Cidade:
                        <input type="text" id="cidade" name="cidade" value="<?= trim($cliente['cidade_cliente'] ?? '') ?>" readonly>
                    </label>

                    <!-- UF -->
                    <label for="uf">UF:
                        <input type="text" id="uf" name="uf" value="<?= trim($cliente['sigla_uf'] ?? '') ?>" readonly>
                    </label>

                    <!-- NUMERO -->
                    <label for="numero">Número:
                        <input type="number" id="numero" name="numero" value="<?= trim($partes[1] ?? '')  ?>">
                    </label>

                    <p>Deseja alterar a senha? preencha os campos abaixo:</p>

                    <!-- SENHA ATUAL -->
                    <label for="senha">Senha atual:
                        <div class="input-wrapper">
                            <input type="password" name="senhaAtual" id="senha" placeholder="********">
                            <img src="<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg" alt="Ver senha" class="toggleSenha icone-senha">
                        </div>
                    </label>

                    <!-- NOVA SENHA -->
                    <label for="novaSenha">Nova senha:
                        <div class="input-wrapper">
                            <input type="password" name="novaSenha" id="novaSenha" placeholder="********">
                            <img src="<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg" alt="Ver novaSenha" class="toggleSenha icone-senha">
                        </div>
                    </label>

                    <!-- CONFIRMAR NOVA SENHA -->
                    <label for="confirmarNovaSenha">Confirmar nova senha:
                        <div class="input-wrapper">
                            <input type="password" name="confirmarNovaSenha" id="confirmarNovaSenha" placeholder="********">
                            <img src="<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg" alt="Ver confirmarNovaSenha" class="toggleSenha icone-senha">
                        </div>
                    </label>

                    <!-- ALERTA DE SENHA (VALIDAÇÃO) -->
                    <div id="alertaSenha" style="display:none; color: red; margin: 10px 0;"></div>

                    <!-- BOTÕES -->
                    <div>
                        <button class="btn_app" type="submit" id="btnSalvar">SALVAR ALTERAÇÕES</button>
                        <a href="<?= BASE_URL_APP ?>index.php?url=home" class="btn_app btn_cancelar">CANCELAR</a>
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

    <!-- // Máscaras -->
    <script>
        const nome = document.getElementById('nome');
        const telefone = document.getElementById('telefone');
        const cpfCnpj = document.getElementById('cpf_cnpj');

        nome.addEventListener('input', function() {
            mascaraNome(this);
        })

        telefone.addEventListener('input', function() {
            mascaraTelefone(this);
        })

        cpfCnpj.addEventListener('input', function() {
            mascaraCpfCnpj(this);
        })
    </script>

    <!-- CONTROLE DA SENHA VISUALIZAR/NÃO VISUALIZAR -->
    <script>
        const toggleSenha = document.querySelectorAll('.toggleSenha');

        toggleSenha.forEach((icone) => {
            icone.addEventListener('click', () => {
                const input = icone.previousElementSibling; // input está antes da imagem no DOM
                const estaVisivel = input.type === 'text';
                input.type = estaVisivel ? 'password' : 'text';

                // Troca o ícone do olho
                icone.src = estaVisivel ?
                    '<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg' :
                    '<?php echo BASE_URL_APP ?>assets/img/olho_aberto.svg';
            });
        });
    </script>

    <!-- API VIA CEP -->
    <script>
        document.getElementById('btnBuscarCep').addEventListener('click', function() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');

            if (cep.length !== 8) {
                alert('Por favor, insira um CEP válido com 8 números.');
                return;
            }

            // URL da API ViaCEP
            const url = `https://viacep.com.br/ws/${cep}/json/`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na requisição do CEP.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                        return;
                    }

                    // Preenche os campos do formulário com os dados do CEP
                    document.getElementById('logradouro').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('uf').value = data.uf || '';

                    document.getElementById('numero').value = '';

                    setTimeout(() => {
                        const numeroInput = document.getElementById('numero');

                        // Scrolla suavemente até o campo
                        numeroInput.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        // Dá o focus após um pequeno tempo (depois do scroll iniciar)
                        setTimeout(() => {
                            numeroInput.focus();
                        }, 500);
                    }, 300);

                })
                .catch(error => {
                    alert('Erro ao buscar o CEP: ' + error.message);
                });
        });
    </script>

    <!-- FOTO DO CLIENTE -->
    <script>
        const imgCliente = document.getElementById('imgCliente');
        const inputFoto = document.getElementById('inputFotoCliente');

        imgCliente.addEventListener('click', () => {
            inputFoto.click();
        });

        inputFoto.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgCliente.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <!-- VALIDAÇÃO DE SENHA -->
    <script>
        document.getElementById('btnSalvar').addEventListener('click', function(event) {
            const senhaAtual = document.getElementById('senha').value.trim();
            const novaSenha = document.getElementById('novaSenha').value.trim();
            const confirmarNovaSenha = document.getElementById('confirmarNovaSenha').value.trim();
            const alerta = document.getElementById('alertaSenha');

            alerta.style.display = "none"; // Esconde o alerta inicialmente

            // Verifica se algum dos campos foi preenchido
            const algumCampoPreenchido = senhaAtual || novaSenha || confirmarNovaSenha;

            if (algumCampoPreenchido) {
                // Todos os campos devem ser preenchidos
                if (!senhaAtual || !novaSenha || !confirmarNovaSenha) {
                    alerta.innerText = "Se deseja alterar a senha, preencha todos os campos.";
                    alerta.style.display = "block";
                    event.preventDefault();
                    return;
                }

                if (novaSenha.length < 6) {
                    alerta.innerText = "A nova senha deve ter no mínimo 6 caracteres.";
                    alerta.style.display = "block";
                    event.preventDefault();
                    return;
                }

                if (novaSenha !== confirmarNovaSenha) {
                    alerta.innerText = "As senhas não coincidem.";
                    alerta.style.display = "block";
                    event.preventDefault();
                    return;
                }
            }

            // Se nenhum campo for preenchido, permite o envio sem validação de senha
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const msgResposta = document.getElementById("msg-resposta");
            const loading = document.getElementById("loading");

            form.addEventListener("submit", function(event) {
                let formValido = true;
                let primeiroErro = null;
                let mensagemErro = "";

                const campos = this.querySelectorAll("input, select");
                campos.forEach(el => el.style.border = "");

                msgResposta.innerHTML = "";
                msgResposta.classList.remove("show-erro", "show-sucesso");

                const tipo = document.getElementById("tipo_cliente")?.value;
                const cpfCnpj = document.getElementById("cpf_cnpj")?.value.trim();
                const telefone = document.getElementById("telefone")?.value.trim();

                const formatoCPF = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
                const formatoCNPJ = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;

                const camposObrigatorios = [{
                        id: "nome",
                        nome: "Nome"
                    },
                    {
                        id: "email",
                        nome: "Email"
                    },
                    {
                        id: "tipo_cliente",
                        nome: "Tipo"
                    },
                    {
                        id: "cpf_cnpj",
                        nome: "CPF/CNPJ",
                        customValidation: function(el) {
                            if (tipo === "Pessoa Física" && !formatoCPF.test(el.value.trim())) {
                                return "CPF inválido. Use o formato: 000.000.000-00";
                            }
                            if (tipo === "Pessoa Jurídica" && !formatoCNPJ.test(el.value.trim())) {
                                return "CNPJ inválido. Use o formato: 00.000.000/0000-00";
                            }
                            return null;
                        }
                    },
                    {
                        id: "telefone",
                        nome: "Telefone",
                        customValidation: function(el) {
                            return el.value.trim().length < 14 ? "Telefone inválido. Verifique se está no formato correto com DDD." : null;
                        }
                    },
                    {
                        id: "dataNascimento",
                        nome: "Data de nascimento"
                    },
                    {
                        id: "logradouro",
                        nome: "Logradouro"
                    },
                    {
                        id: "bairro",
                        nome: "Bairro"
                    },
                    {
                        id: "cidade",
                        nome: "Cidade"
                    },
                    {
                        id: "uf",
                        nome: "UF"
                    },
                    {
                        id: "numero",
                        nome: "Número"
                    }
                ];

                camposObrigatorios.forEach(campo => {
                    const el = document.getElementById(campo.id);
                    const valor = el?.value.trim();

                    if (!el || valor === "") {
                        el.style.border = "2px solid red";
                        if (!primeiroErro) {
                            primeiroErro = el;
                            mensagemErro = `O campo <strong>${campo.nome}</strong> é obrigatório.`;
                        }
                        formValido = false;
                    } else if (campo.customValidation) {
                        const erroCustom = campo.customValidation(el);
                        if (erroCustom) {
                            el.style.border = "2px solid red";
                            if (!primeiroErro) {
                                primeiroErro = el;
                                mensagemErro = erroCustom;
                            }
                            formValido = false;
                        }
                    }
                });

                if (!formValido) {
                    event.preventDefault();
                    if (primeiroErro) primeiroErro.focus();
                    msgResposta.classList.add("show-erro");
                    msgResposta.innerHTML = `<p class="msg-erro">${mensagemErro}</p>`;

                    setTimeout(() => {
                        msgResposta.innerHTML = "";
                        msgResposta.classList.remove("show-erro");
                    }, 5000);
                } else {
                    if (loading) loading.style.display = "flex";
                }
            });

            // Exibe mensagens da API, se existirem
            const isSucesso = msgResposta?.querySelector(".msg-sucesso");
            const isErro = msgResposta?.querySelector(".msg-erro");

            if (isSucesso || isErro) {
                msgResposta.classList.add(isSucesso ? "show-sucesso" : "show-erro");

                setTimeout(() => {
                    msgResposta.classList.remove("show-sucesso", "show-erro");
                    msgResposta.innerHTML = "";
                    if (loading) loading.style.display = "none";
                }, 5000);
            } else {
                if (loading) loading.style.display = "none";
            }
        });
    </script>

</body>

</html>