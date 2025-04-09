function mascara(campo, funcao) {
    campo.value = funcao(campo.value);
}



function mascaraData(event, campo, limite) {
    let tecla = event.key;
  
    // Impede qualquer caractere que não seja número
    if (!/\d/.test(tecla)) {
      event.preventDefault();
      return false;
    }
  
    // Impede digitação além do limite
    if (campo.value.length >= limite) {
      event.preventDefault();
      return false;
    }
  
    return true;
  }
  
  
  
  


function mascaraCPF(input) {
    input.value = input.value
    .replace(/\D/g, '')
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }
    
    // Máscara para RG
    function mascaraRG(input) {
    input.value = input.value
    .replace(/\D/g, '')
    .replace(/(\d{2})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d{1})$/, '$1-$2');
    }
    
    // Máscara para CEP
    function mascaraCEP(input) {
    input.value = input.value
    .replace(/\D/g, '')
    .replace(/^(\d{5})(\d{1,3})/, '$1-$2');
    }
    
    // Máscara para número
    function apenasNumeros(input) {
    input.value = input.value.replace(/\D/g, '');
    }
    
    // Permitir somente letras
    function apenasLetras(input) {
    input.value = input.value.replace(/[^a-zA-Z áÁéÉíÍóÓúÚçÇ]/g, '');
    }
    
    // Validação de e-mail simples
    function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
    }
    



    function validarFormulario(e) {
    const form = document.forms[0];
    const email = form["email"].value;
    const cpf = form["cpf"].value;
    const rg = form["rg"].value;
    const cep = form["cep"].value;



    if (rg.length < 12) {
        alert("RG incompleto!");
        form["rg"].focus();
        e.preventDefault();
        return false;
        }

      if (cpf.length < 14) {
    alert("CPF incompleto!");
    form["cpf"].focus();
    e.preventDefault();
    return false;
    }
    
    if (!validarEmail(email)) {
    alert("Email inválido!");
    form["email"].focus();
    e.preventDefault();
    return false;
    }
    
  
    
    if (cep.length < 9) {
    alert("CEP incompleto!");
    form["cep"].focus();
    e.preventDefault();
    return false;
    }
    
    return true;
    }
    
    // Aplica eventos de máscara ao carregar
    window.onload = function () {
    const form = document.forms[0];
    
    // Letras apenas
    ["nome", "sobrenome", "bairro", "cidade", "rua"].forEach(nome => {
    form[nome].addEventListener("input", () => apenasLetras(form[nome]));
    });
    
    // Números com máscara
    form["cpf"].addEventListener("input", () => mascaraCPF(form["cpf"]));
    form["rg"].addEventListener("input", () => mascaraRG(form["rg"]));
    form["cep"].addEventListener("input", () => mascaraCEP(form["cep"]));
    form["numero"].addEventListener("input", () => apenasNumeros(form["numero"]));
    
    // Validação final ao enviar
    form.addEventListener("submit", validarFormulario);
    };