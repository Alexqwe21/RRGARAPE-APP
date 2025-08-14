function mascaraNome(e) {
    const input = e.target || e;
    input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚçÇãõÃÕ\s]/g, "");
}

// Máscara para chassi
function mascaraChassi(e) {
    let valor = e.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    valor = valor.replace(/[IOQ]/g, '');
    e.value = valor.slice(0, 17);
}

function mascaraTelefone(e) {
    const input = e.target || e;
    let valor = input.value.replace(/\D/g, "");
    if (valor.length > 11) valor = valor.slice(0, 11);

    if (valor.length <= 10) {
        input.value = valor.replace(/(\d{2})(\d{4})(\d{0,4})/, function (_, ddd, prefixo, sufixo) {
            return `(${ddd}) ${prefixo}${sufixo ? '-' + sufixo : ''}`;
        });
    } else {
        input.value = valor.replace(/(\d{2})(\d{5})(\d{0,4})/, function (_, ddd, prefixo, sufixo) {
            return `(${ddd}) ${prefixo}${sufixo ? '-' + sufixo : ''}`;
        });
    }
}

function mascaraCpfCnpj(input) {
    input.addEventListener('input', function (e) {
        let valor = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

        // Limita o tamanho máximo do input (11 para CPF, 14 para CNPJ)
        if (valor.length > 14) {
            valor = valor.substring(0, 14);
        }

        if (valor.length <= 11) {
            // Máscara CPF
            valor = valor
                .replace(/^(\d{3})(\d)/, '$1.$2')
                .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
                .replace(/\.(\d{3})(\d)/, '.$1-$2');
        } else {
            // Máscara CNPJ
            valor = valor
                .replace(/^(\d{2})(\d)/, '$1.$2')
                .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                .replace(/\.(\d{3})(\d)/, '.$1/$2')
                .replace(/(\d{4})(\d)/, '$1-$2');
        }

        e.target.value = valor;
    });
}

// Mascara para campo de placa do veículo
function mascaraPlaca(input) {
    let valor = input.value.toUpperCase().replace(/[^A-Z0-9]/g, ""); // Remove caracteres inválidos
    if (valor.length > 3) {
        if (valor.length === 7 && /[A-Z]{3}\d[A-Z]\d{2}/.test(valor)) { // Placa Mercosul (AAA0A00)
            input.value = valor;
        } else { // Placa antiga (AAA-0000)
            input.value = valor.substring(0, 3) + "-" + valor.substring(3, 7);
        }
    } else {
        input.value = valor;
    }
}