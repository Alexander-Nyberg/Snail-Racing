setInterval(() => {
    let xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = () => {};
    
    xhttp.open('GET', '_payout.php');
    xhttp.send();
}, 5000);
