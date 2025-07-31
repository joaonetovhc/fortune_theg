const imagens = [
  "../assets/img/bros.png",
  "../assets/img/bros17.png",
  "../assets/img/bros150.png",
  "../assets/img/titan160.png",
  "../assets/img/xre190.png",
  "../assets/img/xre300.png"
];

const balanceElement = document.getElementById('balance');
const resultElement = document.getElementById('result');
const spinBtn = document.getElementById('spinBtn');
const slots = document.querySelectorAll('.slot-icon img');
const reelRows = document.querySelectorAll('.reel-row');

spinBtn.addEventListener('click', () => {
  fetch('../app/spin.php')
    .then(response => response.json())
    .then(data => {
      if (data.error || data.erro) {
        resultElement.textContent = data.error || data.erro;
        return;
      }

      // Atualiza os 9 ícones (3 colunas x 3 linhas)
      data.result.forEach((iconIndex, i) => {
        if (slots[i]) {
          slots[i].src = imagens[iconIndex];
        }
      });
      
      if (data.win > 0) {
        resultElement.textContent = `Você ganhou! R$ ${parseFloat(data.win).toLocaleString('pt-BR', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })}`;

        // Destaca linha do meio
        reelRows[1].classList.add('win-row');

      } else {
        resultElement.textContent = "Tente novamente!";
      }

      balanceElement.textContent = `R$ ${parseFloat(data.balance).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      })}`;
    })
    .catch(error => {
      console.error("erro na requisição:", error);
      resultElement.textContent = "Erro ao conectar com o servidor.";
    });
});
