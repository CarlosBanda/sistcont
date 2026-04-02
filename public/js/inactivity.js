let timeout;

const tiempoInactividad = 10 * 60 * 1000;
// const tiempoInactividad = 10000; para hacerr prueba de funcionalidad 10 segundos

function resetTimer(){

    clearTimeout(timeout);

    timeout = setTimeout(()=>{
        logoutAutomatico();
    }, tiempoInactividad);

}

function logoutAutomatico(){

    const token = localStorage.getItem('token');

    fetch('/api/logout',{
        method:'POST',
        headers:{
            Authorization: 'Bearer ' + token
        }
    });
    localStorage.removeItem('token');

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