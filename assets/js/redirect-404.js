document.addEventListener('DOMContentLoaded', function () {
  const homeUrl = Config404.homeUrl
  let timer = 5

  const elementoContador = document.getElementById('timer')

  const intervalo = setInterval(function () {
    timer--

    if (elementoContador) {
      elementoContador.innerText = timer
    }

    if (timer <= 0) {
      clearInterval(intervalo)
      window.location.href = homeUrl
    }
  }, 1000)
})
