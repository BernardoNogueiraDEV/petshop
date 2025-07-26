const texto = document.getElementById('h1Escrever'); // Reference to the correct ID
let conteudo = `No PetShop Amigo Fiel, nosso compromisso é cuidar com carinho e dedicação dos melhores amigos da sua família. Desde 1998, oferecemos produtos de qualidade, serviços especializados e um atendimento que valoriza o bem-estar dos pets e a tranquilidade dos tutores.
                Acreditamos que cada animal merece amor, cuidado e atenção, por isso contamos com uma equipe apaixonada e experiente, pronta para atender as necessidades do seu bichinho. Aqui, você encontra tudo o que ele precisa: desde rações premium e acessórios até serviços de banho, tosa e consultas veterinárias.
                Somos mais do que um petshop, somos parceiros no cuidado e na felicidade do seu amigo de quatro patas. Venha nos conhecer e faça parte da nossa família! 🐶🐱💚`
let index = 0;
const h1 = document.getElementById('h1Escrever');

function escrever(){
    if (h1) { 
        if(index <= conteudo.length){
            h1.textContent = conteudo.slice(0, index);
            index++;
            setTimeout(escrever, 50);
        }
    } else {
        console.error("Element with ID 'h1Escrever' not found.");
    }
}
document.addEventListener('DOMContentLoaded', escrever);

let index2 = 0
let conteudo2 = `Cuidar da higiene do seu pet é essencial para a saúde e bem-estar dele. No serviço de banho e tosa, oferecemos um cuidado completo: limpeza profunda com produtos de alta qualidade, secagem cuidadosa e tosa personalizada para deixar seu amigo de quatro patas confortável e ainda mais lindo. Nossa equipe é treinada para garantir uma experiência tranquila e segura, respeitando as necessidades de cada animal. Afinal, um pet limpo e bem cuidado é um pet mais feliz!`;
const h1_2 = document.getElementById('textoBanhoTosa');
function escrever2(){
    if (h1_2) {
        if(index2 <= conteudo2.length){
            h1_2.textContent = conteudo2.slice(0, index2);
            index2++;
            setTimeout(escrever2, 50);
        }
    } else{
        console.error("Element with ID 'textoBanhoTosa' not found.");
    }
}
document.addEventListener('DOMContentLoaded', escrever2);



// Função para aplicar efeito de scale em um par de caixas (azul e vermelha)
function criarEfeito(idAzul, idVermelho) {
    const caixaAzul = document.getElementById(idAzul);
    const caixaVermelha = document.getElementById(idVermelho);

    // Adiciona efeito quando o mouse passa sobre a caixa azul
    caixaAzul.addEventListener('mouseenter', () => {
        caixaVermelha.classList.add('scale');
    });

    // Remove efeito quando o mouse sai da caixa azul
    caixaAzul.addEventListener('mouseleave', () => {
        caixaVermelha.classList.remove('scale');
    });
}

// Criando os efeitos para cada par
criarEfeito('banhoTosa', 'banhoTosa2');
criarEfeito('consulta', 'consulta2');
criarEfeito('vacinacao', 'vacinacao2');
criarEfeito('hotelPet', 'hotelPet2');

function banhoTosa(){
    window.location.href = '#pag4'
}
function consulta(){
    window.location.href = '#pag5'
}
function vacinacao(){
    window.location.href = '#pag6'
}
function hotelPet(){
    window.location.href = '#pag7'
}
function registrar(){
    window.location.href = './registrarLogin.php'
}
function racaoEpetisco(){
    window.location.href = './loja/racaoEpetisco.php';
}
function brinquedos(){
    window.location.href = './loja/brinquedos.php';
}
function acessorios(){
    window.location.href = './loja/acessorios.php';
}
function higiene(){
    window.location.href = './loja/higiene.php';
}
function medicamentoEsuplemento(){
    window.location.href = './loja/medicamentoEsuplementos.php';
}
function aquarismo(){
    window.location.href = './loja/aquarismo.php';
}
function roedores(){
    window.location.href = './loja/roedores.php';
}
function cuidadoEbeleza(){
    window.location.href = './loja/cuidadoEbeleza.php';
}