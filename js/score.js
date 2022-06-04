const score = document.getElementById('score-elem');

if (score) {
    const func = () => {
        let xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = async () => {
            if (xhttp.readyState == xhttp.DONE) {
                score.innerHTML = `score: ${xhttp.responseText}`;
            }
        };
        
        xhttp.open('GET', `_score.php?id=${__uid}`);
        xhttp.send();
        
    };
    
    func();
    setInterval(func, 1000);
}
