// Handle Signup Form
const signupForm = document.getElementById('signupForm');
if (signupForm) {
    signupForm.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(signupForm);

        fetch('signup.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('message').innerText = data;
            if(data.includes('success')) {
                window.location.href = 'login.html';
            }
        })
        .catch(err => console.error(err));
    });
}

// Handle Login Form
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(loginForm);

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data.includes('success')) {
                window.location.href = 'index.php';
            } else {
                document.getElementById('message').innerText = data;
            }
        })
        .catch(err => console.error(err));
    });
}
