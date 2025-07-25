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
  if (balance < 1) {
    resultElement.textContent = "Saldo insuficiente!";
    return;
  }

  balance -= 1;
  let selected = [];

  reels.forEach((reel, i) => {
    const randomIndex = Math.floor(Math.random() * imagens.length);
    reel.src = imagens[randomIndex];
    selected.push(imagens[randomIndex]);
  });

  // Verifica se todos os ícones são iguais
  const isWin = selected.every(val => val === selected[0]);
  if (isWin) {
    resultElement.textContent = "Você ganhou! 🏆 +R$5";
    balance += 5;
  } else {
    resultElement.textContent = "Tente novamente!";
  }

  balanceElement.textContent = balance.toFixed(2);
});
