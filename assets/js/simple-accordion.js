document.addEventListener('DOMContentLoaded', () => {
  const botoes = document.querySelectorAll('.accordion button')
  console.log(botoes)
  for (const botao of botoes) {
    botao.addEventListener('click', (event) => {
      const section = botao.parentElement.nextElementSibling
      const icone = botao.querySelector('svg')
      let timeout = 0

      botao.blur()

      section.classList.toggle('transparente')

      // Adiciona delay no fechamento do accordion
      if (icone.classList.contains('inverter')) {
        timeout = 300
      }

      setTimeout(() => {
        section.classList.toggle('hidden')
        icone.classList.toggle('inverter')
        botao.ariaExpanded = botao.ariaExpanded !== 'true'
      }, timeout)
    })
  }
})
