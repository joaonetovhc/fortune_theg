// script.js

const spinBtn = document.getElementById("spinBtn");
const reels = [
  document.getElementById("reel1"),
  document.getElementById("reel2"),
  document.getElementById("reel3")
];
const resultText = document.getElementById("result");
const balanceSpan = document.getElementById("balance");

const icons = ["🏍️", "🚗", "🛵"];

spinBtn.addEventListener("click", () => {
  spinBtn.disabled = true;
  resultText.textContent = "Girando...";

  fetch("../app/spin.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({})
  })
    .then(res => res.json())
    .then(data => {
      const { result, win, balance } = data;

      for (let i = 0; i < reels.length; i++) {
        reels[i].textContent = icons[result[i]];
      }

      balanceSpan.textContent = parseFloat(balance).toFixed(2);
      resultText.textContent = win > 0 ? `🎉 Você ganhou R$ ${win.toFixed(2)}!` : "Tente novamente...";
    })
    .catch(err => {
      resultText.textContent = "Erro ao girar. Tente novamente.";
      console.error(err);
    })
    .finally(() => {
      spinBtn.disabled = false;
    });
});
