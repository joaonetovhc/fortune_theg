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
const reels = document.querySelectorAll('.reel img');

spinBtn.addEventListener('click', () => {
  fetch('../app/spin.php')
  .then(response => response.json())
  .then(data => {
    if (data.error || data.erro){
      resultElement.textContent = data.error || data.erro;
      return;
    }

    data.result.forEach((iconIndex, i) => {
      reels[i].src = imagens[iconIndex];
    });


    if(data.win > 0){
      resultElement.textContent = `Você ganhou! ${parseFloat(data.balance).toLocaleString('pt-BR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
      })}`;
      
    } else{
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
