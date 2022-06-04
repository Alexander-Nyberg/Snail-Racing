const betSnail = document.getElementById('bet-snail');
const betAmount = document.getElementById('bet-amount');
const betNow = document.getElementById('bet-now');

const bet = () => {
    if ((Math.floor((new Date()).getTime() / 1000) + 225) % 450 <= 225)
        betNow.style.display = 'inline-block';
    else
        betNow.style.display = 'none';
};

bet();
setInterval(bet, 1000);

betNow.onclick = () => {
    let xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = async () => {};
    
    xhttp.open('GET', `_bet.php?name=${__uname}&pwd=${__pwd}&amount=${betAmount.value}&snail=${betSnail.value}`);
    xhttp.send();
};
