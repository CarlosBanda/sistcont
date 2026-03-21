function apiFetch(url, options = {}) {

    options.headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers
    };

    return fetch('/api/' + url,{
        ...options,
        credentials: 'include'
    })
    .then(response => {

            if(response.status === 401){
                window.location.href = "/login";
                return;
            }

            return response.json();
        });
}

function logout(){

    fetch('/api/logout',{
        method:'POST',
        credentials: 'include'
    });

    window.location.href="/login";
}