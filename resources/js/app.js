import './bootstrap';


// Dark/Light Mode
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = `${name}=${value};${expires};path=/`;
}

document.getElementById('lightBtn').addEventListener('click', () => {
    document.body.classList.add('light-mode');
    setCookie("theme", "light", 365);
});

document.getElementById('darkBtn').addEventListener('click', () => {
    document.body.classList.remove('light-mode');
    setCookie("theme", "dark", 365);
});
