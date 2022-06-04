const div = document.getElementById('cookie');

if (localStorage.getItem('_userwothaspressedthebutton') != null)
    div.classList.add('cookie-accept');

function cookieaccept()
{
    div.classList.add('cookie-accept');
    localStorage.setItem('_userwothaspressedthebutton', 1);
}
