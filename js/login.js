// Seleciona os elementos necessários
const showRegister = document.getElementById("showRegister");
const showLogin = document.getElementById("showLogin");
const loginFormContainer = document.querySelector(".login-form-container");
const registerFormContainer = document.querySelector(".registrar-form-container");

// Função para mostrar o formulário de cadastro
showRegister.addEventListener("click", (event) => {
    event.preventDefault(); // Evita o comportamento padrão do link
    loginFormContainer.style.transform = "translateX(-100%)";
    registerFormContainer.style.transform = "translateX(0)";
    
    // Aguarda a transição terminar antes de ocultar o formulário de login
    setTimeout(() => {
        loginFormContainer.style.display = "none";
        registerFormContainer.style.display = "flex";
    }, 75); // Tempo deve coincidir com o tempo da transição no CSS
});

// Função para mostrar o formulário de login
showLogin.addEventListener("click", (event) => {
    event.preventDefault(); // Evita o comportamento padrão do link
    loginFormContainer.style.transform = "translateX(0)";
    registerFormContainer.style.transform = "translateX(100%)";
    
    // Aguarda a transição terminar antes de ocultar o formulário de cadastro
    setTimeout(() => {
        registerFormContainer.style.display = "none";
        loginFormContainer.style.display = "flex";
    }, 75); // Tempo deve coincidir com o tempo da transição no CSS
});

// Configuração inicial dos displays
loginFormContainer.style.display = "flex";
registerFormContainer.style.display = "none";

// validar cep
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');

    cepInput.addEventListener('blur', function() {
        const cep = cepInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao buscar o CEP');
                    return response.json();
                })
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                        cepInput.style.borderColor = 'red'; // Indica erro
                        return;
                    }
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                    cepInput.style.borderColor = 'green'; // Indica sucesso
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    alert('Erro ao buscar o CEP. Tente novamente.');
                    cepInput.style.borderColor = 'red'; // Indica erro
                });
        } else if (cep) {
            alert('Digite um CEP válido com 8 dígitos.');
            cepInput.style.borderColor = 'red'; // Indica erro
        }
    });
});
  // Função para validar CPF
  function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ""); // Remove caracteres não numéricos
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

    let soma, resto;
    soma = 0;

    for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;
    for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
  }

  // Função para validar email
  function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }

  // Evento de submissão do formulário
  document.getElementById("registerForm").addEventListener("submit", function (e) {
    const emailInput = document.querySelector("input[name='email']");
    const cpfInput = document.querySelector("input[name='cpf']");

    const email = emailInput.value.trim();
    const cpf = cpfInput.value.trim();

    if (!validarEmail(email)) {
      alert("Por favor, insira um email válido.");
      e.preventDefault();
      return;
    }

    if (!validarCPF(cpf)) {
      alert("Por favor, insira um CPF válido.");
      e.preventDefault();
      return;
    }

    alert("Formulário enviado com sucesso!");
  });