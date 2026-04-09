function apiFetch(url, options = {}) {

    const token = localStorage.getItem('token');

    options.headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(token && { Authorization: 'Bearer ' + token } ),
        ...options.headers
    };

    return fetch('/api/' + url,{
        ...options
    })
    .then(response => {

            if(response.status === 401){
                localStorage.removeItem('token');
                window.location.href = "/login";
                return;
            }

            return response.json();
        });
}

function checkAuth() {
    const token =localStorage.getItem('token');

    if(!token){
        window.location.href = '/login';
        return;
    }

    fetch('/api/me', {
        headers: {
            Authorization: 'Bearer ' + token
        }
    })
    .then(res => {
        if(res.status === 401){
            localStorage.removeItem('token');
            window.location.href = '/login';
        } else {
            document.body.style.display = "block";
        }
    })
    .catch(() => {
        window.location.href = '/login';
    })
}

function logout(){

    const token = localStorage.getItem('token');

    fetch('/api/logout',{
        method:'POST',
        headers:{
            Authorization: 'Bearer ' + token
        }
    });

    localStorage.removeItem('token');
    window.location.href="/login";
}