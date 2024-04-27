
(function() {
    const menuToggle = document.querySelector('.menu-toggle')
    menuToggle.onclick = function (e) {
        const body = document.querySelector('body')
        body.classList.toggle('hide-sidebar')
    };
})()

function addOneSecond(hours, minutes, seconds) {
    const d = new Date()
    d.setHours(parseInt(hours), parseInt(minutes), parseInt(seconds) + 1)
    const h = `${d.getHours()}` .padStart(2, 0)
    const m = `${d.getMinutes()}` .padStart(2, 0)
    const s = `${d.getSeconds()}` .padStart(2, 0)

    return `${h}:${m}:${s}`
}

function activateClock(){
    const activateClock = document.querySelector('[active-clock]')
    if (!activateClock) return ''

    console.log(activateClock)
    setInterval(function(){
        const parts = activateClock.innerHTML.split(':')
        activateClock.innerHTML = addOneSecond(...parts)
    } , 1000)
}

activateClock()