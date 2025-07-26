// Function para abrir a imagem em tela cheia
function openImageFullscreen(src) {
    const overlay = document.getElementById('imageOverlay');
    const overlayImg = document.getElementById('overlayImage');
    overlayImg.src = src;
    overlay.style.display = 'flex';
}

// fechar o overlay ao clicar no botão de fechar
document.getElementById('closeOverlay').addEventListener('click', function () {
    const overlay = document.getElementById('imageOverlay');
    const overlayImg = document.getElementById('overlayImage');
    overlay.style.display = 'none';
    overlayImg.src = '';
});

// adicionar evento de clique nas imagens
document.querySelectorAll('.card-img img').forEach(img => {
    img.style.cursor = 'pointer';
    img.addEventListener('click', function () {
        openImageFullscreen(this.src);
    });
});