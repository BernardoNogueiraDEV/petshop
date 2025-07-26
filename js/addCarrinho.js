function addCart(produto, preco) {
    $.ajax({
        url: '/petshop/php/adicionar_carrinho.php',
        method: 'POST',
        data: {
            produto: produto,
            preco: preco
        },
        xhrFields: {
            withCredentials: true
        },
        success: function () {
            mostrarMensagem("✅ Produto adicionado ao carrinho!", "#4CAF50"); // Verde
            // location.reload(); // Descomente se quiser recarregar a página
        },
        error: function (xhr) {
            mostrarMensagem("❌ Erro ao adicionar produto: " + xhr.status, "#f44336"); // Vermelho
        }
    });
}

function mostrarMensagem(texto, corFundo) {
    var messageDiv = document.getElementById('customMessage');

    if (!messageDiv) {
        messageDiv = document.createElement('div');
        messageDiv.id = 'customMessage';
        document.body.appendChild(messageDiv);
    }

    messageDiv.innerText = texto;
    messageDiv.style.backgroundColor = corFundo || '#4CAF50';
    messageDiv.style.color = 'white';
    messageDiv.style.padding = '15px 25px';
    messageDiv.style.borderRadius = '5px';
    messageDiv.style.position = 'fixed';
    messageDiv.style.bottom = '20px';
    messageDiv.style.right = '20px';
    messageDiv.style.zIndex = '1000';
    messageDiv.style.fontSize = '16px';
    messageDiv.style.fontWeight = 'bold';
    messageDiv.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
    messageDiv.style.display = 'block';
    messageDiv.style.animation = 'fadein 0.5s, fadeout 0.5s 2.5s';

    setTimeout(function () {
        messageDiv.style.display = 'none';
    }, 3000);
}

// Animações CSS se ainda não estiverem no seu CSS
const style = document.createElement('style');
style.textContent = `
@keyframes fadein {
    from {opacity: 0;}
    to {opacity: 1;}
}
@keyframes fadeout {
    from {opacity: 1;}
    to {opacity: 0;}
}
`;
document.head.appendChild(style);
