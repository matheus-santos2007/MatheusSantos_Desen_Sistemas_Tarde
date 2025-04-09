//Executar mascaras
function mascara(o, f) {
    objeto = o;
    funcao = f;
    setTimeout("executaMascara()", 1);
}

function executaMascara() {
    objeto.value = funcao(objeto.value);
}

//Mascaras do telefone
function telefone(variavel) {
    //Remove tudo o que não é dígito
    variavel = variavel.replace(/\D/g, "");
    //A linha abaixo é responsável por adicionar parênteses em volta dos dois primeiros dígitos
    variavel = variavel.replace(/^(\d\d)(\d)/g, "($1) $2");
    //A linha abaixo é responsável por adicionar o hífen entre o quarto e o quinto dígito
    variavel = variavel.replace(/(\d{4})$/, "-$1");
    return variavel;
}

//Mascaras do RG e CPF
function RGeCPF(variavel) {
    variavel = variavel.replace(/\D/g, ""); //remove tudo o que não é número

    //coloca um ponto após o TERCEIRO dígito e o QUARTO dígito
    variavel = variavel.replace(/(\d{3})(\d)/, "$1.$2");

    //coloca um ponto após o SEXTO dígito e o SÉTIMO dígito
    variavel = variavel.replace(/(\d{3})(\d)/, "$1.$2");

    //Coloca o HÍFEN após o sétimo dígito e permite apenas 2 dígitos após o hífen
    variavel = variavel.replace(/(\d{3})(\d{1,2})$/,"$1-$2");

    return variavel;
}

//Mascara do CEP
function cep(variavel) {
    variavel = variavel.replace(/\D/g, ""); //remove tudo o que não é número

    variavel = variavel.replace(/(\d{2})(\d)/, "$1-$2");

    variavel = variavel.replace(/(\d{3})(\d{1,3})$/, "$1-$2");

    return variavel;
}

//Mascara Data
function data(variavel) {
    variavel = variavel.replace(/\D/g, ""); //remove tudo o que não é número

    //coloca uma barra após o segundo dígito e o terceiro dígito
    variavel = variavel.replace(/(\d{2})(\d)/, "$1/$2");

    //coloca uma barra após o quarto dígito e o quinto dígito
    variavel = variavel.replace(/(\d{2})(\d)/, "$1/$2");

    return variavel;
}

//Mascaras do Cartão SUS
function CartaoSus(variavel) {
    variavel = variavel.replace(/\D/g, ""); //remove tudo o que não é número

    return variavel;
}
