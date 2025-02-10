document.addEventListener('DOMContentLoaded', () => {
  const botao = document.getElementsByClassName('button-toggle-introducao')[0];
  
  botao.addEventListener('click', toggleIntroducao);
  
  function toggleIntroducao() {
    if (!botao.classList.contains('movendo')) {
      // Impede a função de ser acionada enquanto o painel estiver se movendo
      const timerAnimacao = 800;
      botao.classList.toggle('movendo');
      setTimeout(() => botao.classList.toggle('movendo'), timerAnimacao);
  
      const styleIntroducao = document.getElementsByClassName('introducao')[0].style;
      const styleBotao = botao.style;
      const svg = botao.getElementsByTagName('svg')[0];
  
      svg.classList.toggle('inverter');
  
      if (styleIntroducao.left == '-284px') {
        styleIntroducao.left = '16px';
        styleBotao.left = '316px';
        botao.setAttribute('aria-label', 'Fechar painel lateral');
        return;
      }
  
      styleIntroducao.left = '-284px';
      styleBotao.left = '16px';
      botao.setAttribute('aria-label', 'Abrir painel lateral');
    }
  }
});

