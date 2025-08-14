document.addEventListener("DOMContentLoaded", function () {
    const chatContainer = document.getElementById("chat");
    const userInput = document.getElementById("userInput");
    const inputUserContainer = document.getElementById("inputUserContainer");
    const agendamentoSection = document.getElementById("agendamentoSection");
    const formAgendamento = document.getElementById("formAgendamento");

    const respostas = {
        nome: "",
        email: "",
        telefone: "",
        dataHora: ""
    };

    const perguntas = [
        "🙋‍♂️ Qual é o seu nome?",
        "📧 Qual é o seu e-mail?",
        "📱 Qual é o seu número de telefone com DDD?"
    ];

    function adicionarMensagemBot(texto) {
        const div = document.createElement("div");
        div.classList.add("bot");
        div.innerText = texto;
        chatContainer.appendChild(div);
    }

    function adicionarMensagemErro(texto) {
        const div = document.createElement("div");
        div.classList.add("botErro");
        div.innerText = texto;
        chatContainer.appendChild(div);

        setTimeout(() => {
            const ultimasMensagensBot = chatContainer.querySelectorAll('.botErro');
            const ultimaMensagemBot = ultimasMensagensBot[ultimasMensagensBot.length - 1];

            if (ultimaMensagemBot) {
                ultimaMensagemBot.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        }, 300);
    }

    function adicionarMensagemUsuario(texto) {
        const div = document.createElement("div");
        div.classList.add("user");
        div.innerText = texto;
        chatContainer.appendChild(div);
        // Rola a página inteira até o final
        setTimeout(() => {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: "smooth"
            });
        }, 300);
    }

    const temPerguntas = document.getElementById("inputUserContainer") !== null;
    if (temPerguntas) {
        iniciarPerguntas();
    } else {
        adicionarMensagemBot("🕒​ Selecione o dia e horário para seu agendamento. 📅");
        agendamentoSection.style.display = "block";
        inicializarAgendamento();
    }


    function iniciarPerguntas() {
        let indicePergunta = 0;
        aplicarMascaraParaPergunta(indicePergunta);
        adicionarMensagemBot(perguntas[indicePergunta]);

        userInput.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                processarResposta();
            }
        });

        inputUserContainer.querySelector("#btnEnviar").addEventListener("click", function (e) {
            e.preventDefault();
            processarResposta();
        });

        function processarResposta() {
            const resposta = userInput.value.trim();
            if (resposta === "") return;

            if (indicePergunta === 0 && resposta.replace(/[^a-zA-ZáéíóúÁÉÍÓÚçÇãõÃÕ\s]/g, "").trim() === "") {
                adicionarMensagemErro('🤔​ Por favor, insira um nome válido (somente letras).')
                return;
            }

            if (indicePergunta === 1 && !/\S+@\S+\.\S+/.test(resposta)) {
                adicionarMensagemErro('📧 Opa! Parece que o e-mail informado não é válido. Por favor, confira e tente novamente. 😊')
                return;
            }

            if (indicePergunta === 2 && resposta.replace(/\D/g, "").length < 10) {
                adicionarMensagemErro('☎️​ Opa! Verifique se o número de telefone está completo, incluindo o DDD. Ex: (11) 91234-5678. 🤗​')
                return;
            }

            adicionarMensagemUsuario(resposta);

            //Resgata as respostas do usuário
            if (indicePergunta === 0) respostas.nome = resposta;
            else if (indicePergunta === 1) respostas.email = resposta;
            else if (indicePergunta === 2) respostas.telefone = resposta;

            userInput.value = "";
            indicePergunta++;

            if (indicePergunta < perguntas.length) {
                aplicarMascaraParaPergunta(indicePergunta);
                setTimeout(() => {
                    adicionarMensagemBot(perguntas[indicePergunta]);
                    userInput.focus();
                }, 500);
            } else {
                inputUserContainer.style.display = "none";
                setTimeout(() => {
                    adicionarMensagemBot("🕒​ Agora selecione o dia e horário para seu agendamento. 📅");
                    agendamentoSection.style.display = "block";
                    inicializarAgendamento();
                    setTimeout(() => {
                        agendamentoSection.scrollIntoView({ behavior: "smooth", block: "start" });
                    }, 300);
                }, 500);
            }
        }

        function aplicarMascaraParaPergunta(indice) {
            userInput.removeEventListener("input", mascaraNome);
            userInput.removeEventListener("input", mascaraTelefone);
            if (indice === 0) {
                userInput.type = "text";
                userInput.maxLength = 50;
                userInput.addEventListener("input", mascaraNome);
            } else if (indice === 1) {
                userInput.type = "email";
            } else if (indice === 2) {
                userInput.type = "text";
                userInput.addEventListener("input", mascaraTelefone);
            }
        }
    }

    async function inicializarAgendamento() {
        const diasSemana = ['DOM', 'SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SAB'];
        const diasContainer = document.getElementById('diasContainer');
        const horariosContainer = document.getElementById('horariosContainer');
        const hoje = new Date();
        const dias = [];

        diasContainer.innerHTML = '';
        horariosContainer.innerHTML = '';

        // Buscar datas bloqueadas
        let datasBloqueadas = [];
        try {
            const res = await fetch('https://rrgarage.webdevsolutions.com.br/api/buscarDatasBloqueadas/');
            const json = await res.json();
            if (json.sucesso && Array.isArray(json.datas_bloqueadas)) {
                datasBloqueadas = json.datas_bloqueadas.map(item => item.data_bloqueada);
            }
        } catch (e) {
            console.error('Erro ao buscar datas bloqueadas:', e);
        }

        // Função para formatar a data no fuso local
        const formatarData = (data) => {
            return `${data.getFullYear()}-${(data.getMonth() + 1).toString().padStart(2, '0')}-${data.getDate().toString().padStart(2, '0')}`;
        };

        let diaInicialIndex = 0;
        for (let i = 0; i < 14; i++) {
            const data = new Date();
            data.setDate(hoje.getDate() + i);
            const diaSemana = data.getDay();
            const dataFormatada = formatarData(data);
            const isWeekend = diaSemana === 0 || diaSemana === 6;
            const isBloqueada = datasBloqueadas.includes(dataFormatada);

            if (!isWeekend && !isBloqueada) {
                diaInicialIndex = i;
                break;
            }
        }

        for (let i = 0; i < 14; i++) {
            const data = new Date();
            data.setDate(hoje.getDate() + i);
            const diaSemanaStr = diasSemana[data.getDay()];
            const dia = data.getDate().toString().padStart(2, '0');
            const mes = data.toLocaleString('default', { month: 'short' }).toUpperCase();
            const dataFormatada = formatarData(data);
            const inputId = `dia_${i}`;
            const isWeekend = data.getDay() === 0 || data.getDay() === 6;
            const isBloqueada = datasBloqueadas.includes(dataFormatada);

            dias.push({
                index: i,
                value: dataFormatada,
                isWeekend: isWeekend || isBloqueada
            });

            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'dia';
            input.value = dataFormatada;
            input.id = inputId;
            if (i === diaInicialIndex) input.checked = true;
            input.disabled = isWeekend || isBloqueada;

            const label = document.createElement('label');
            label.htmlFor = inputId;
            label.className = 'data';
            if (isWeekend || isBloqueada) label.classList.add('disabled');
            label.innerHTML = `
            <p>${diaSemanaStr}</p>
            <hr>
            <p>${data.toDateString() === hoje.toDateString() ? 'HOJE' : dia}</p>
            <p>${mes}</p>
        `;

            diasContainer.appendChild(input);
            diasContainer.appendChild(label);
        }

        function gerarHorarios(diaIndex) {
            horariosContainer.innerHTML = '';
            if (dias[diaIndex].isWeekend) return;

            const dataSelecionada = dias[diaIndex].value;

            fetch('https://rrgarage.webdevsolutions.com.br/api/buscarHorarios/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ data: dataSelecionada })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.sucesso || !data.dados) {
                        horariosContainer.innerHTML = `<p class="erro">${data.mensagem}</p>`;
                        return;
                    }

                    data.dados.forEach(horario => {
                        const hora = horario.horario.slice(0, 5);
                        const id = `horario_${dias[diaIndex].index}_${hora.replace(':', '')}`;

                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = 'horario';
                        input.value = hora;
                        input.id = id;

                        const label = document.createElement('label');
                        label.htmlFor = id;
                        label.textContent = hora;

                        horariosContainer.appendChild(input);
                        horariosContainer.appendChild(label);
                    });
                })
                .catch(err => {
                    console.error('Erro ao buscar horários:', err);
                    horariosContainer.innerHTML = `<p class="erro">Erro ao carregar horários.</p>`;
                });
        }

        diasContainer.addEventListener('change', (e) => {
            const selectedIndex = dias.findIndex(d => d.value === e.target.value);
            console.log(e.target);
            gerarHorarios(selectedIndex);
            setTimeout(() => {
                horariosContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        });

        gerarHorarios(diaInicialIndex);

        formAgendamento.addEventListener('submit', async function (e) {
            e.preventDefault();

            const diaSelecionado = this.elements['dia'].value;
            const horarioSelecionado = this.elements['horario'].value;

            if (!horarioSelecionado) {
                adicionarMensagemErro('🕒 Quase lá! Falta apenas selecionar um horário para finalizar seu agendamento. 😊✅​');
                setTimeout(() => {
                    const ultimasMensagensBot = chatContainer.querySelectorAll('.botErro');
                    const ultimaMensagemBot = ultimasMensagensBot[ultimasMensagensBot.length - 1];
                    if (ultimaMensagemBot) {
                        ultimaMensagemBot.scrollIntoView({
                            behavior: "smooth",
                            block: "start"
                        });
                    }
                }, 300);
                return;
            }

            const [ano, mes, dia] = diaSelecionado.split('-');
            const dataFormatada = `${dia}/${mes}/${ano}`;
            const dataHora = `${diaSelecionado} ${horarioSelecionado}`;

            adicionarMensagemUsuario(`Dia: ${dataFormatada}, Horário: ${horarioSelecionado}`);

            const url = idCliente
                ? `https://rrgarage.webdevsolutions.com.br/api/cadastrarAgendamento/${idCliente}`
                : 'https://rrgarage.webdevsolutions.com.br/api/cadastrarAgendamento';

            const dados = {
                data_agendamento: dataHora
            };

            // Se for novo cliente, adiciona os dados obrigatórios
            if (!idCliente) {
                dados.nome_cliente = respostas.nome;
                dados.email_cliente = respostas.email;
                dados.telefone_cliente = respostas.telefone;
            }

            // Para mostrar o spinner
            document.getElementById('loading').style.display = 'flex';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify(dados)
                });

                const resultado = await response.json();

                document.getElementById('loading').style.display = 'none';

                if (response.ok) {
                    adicionarMensagemBot(resultado.mensagem || '✅ Agendamento realizado com sucesso!');
                    agendamentoSection.remove();

                } else {
                    const erro = resultado.erro || '❌ Ocorreu um erro ao processar seu agendamento.';
                    adicionarMensagemErro(erro);
                    console.error(resultado.detalhe || erro);

                    // Se a data estiver bloqueada, reinicia o processo
                    if (resultado.bloqueio) {
                        setTimeout(() => {
                            adicionarMensagemBot('😕 Parece que a data que você escolheu foi bloqueada. Vamos tentar de novo?');
                        }, 1000);
                    }
                }


            } catch (error) {
                // Para ocultar o spinner
                document.getElementById('loading').style.display = 'none';
                adicionarMensagemErro('⚠️ Erro de conexão com o servidor. Tente novamente mais tarde.');
                console.error(error);
            }
        });
    }
});