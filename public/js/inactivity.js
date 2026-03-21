let timeout;

const tiempoInactividad = 10 * 60 * 1000;

function resetTimer(){

    clearTimeout(timeout);

    timeout = setTimeout(()=>{
        logoutAutomatico();
    }, tiempoInactividad);

}

function logoutAutomatico(){

    fetch('/api/logout',{
        method:'POST',
        credentials:'include'
    });

    Swal.fire({
        icon:'warning',
        title:'Sesión cerrada',
        text:'Se cerró la sesión por inactividad',
        confirmButtonText:'Ir a login'
    }).then(()=>{
        window.location.href="/login";
    });

}

document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);
document.addEventListener('click', resetTimer);
document.addEventListener('scroll', resetTimer);

resetTimer();