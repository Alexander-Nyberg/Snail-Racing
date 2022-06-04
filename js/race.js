const canvas = document.getElementById('race-canvas');
const ctx    = canvas.getContext('2d');

canvas.width = Math.floor(canvas.clientWidth * window.devicePixelRatio);
canvas.height = Math.floor(canvas.clientHeight * window.devicePixelRatio);

ctx.imageSmoothingEnabled = false;

const names = [
    'Dave',
    'John',
    'Adam',
    'Jeremy',
    'Oscar',
];

let places;

const racelength = 20;
const snailimg = new Image(500, 250);

snailimg.src = 'img/dave_nobg.png';

let _randseed = 0;

function roundRect(ctx, x, y, width, height, radius)
{
    ctx.beginPath();
    ctx.moveTo(x + radius, y);
    ctx.lineTo(x + width - radius, y);
    ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
    ctx.lineTo(x + width, y + height - radius);
    ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
    ctx.lineTo(x + radius, y + height);
    ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
    ctx.lineTo(x, y + radius);
    ctx.quadraticCurveTo(x, y, x + radius, y);
    ctx.closePath();
    ctx.stroke();
    ctx.fill();
};

async function delay(milli)
{
    return new Promise(r => setTimeout(r, milli));
}

function init(seed)
{
    _randseed = seed;
    
    places = [
        0,
        0,
        0,
        0,
        0,
    ];
    
    for (let i = 0; i < 64; i++)
        random(0, 1);
}

function randbit()
{
    let newbit = (_randseed & 1) ^ ((_randseed & 8) >> 3);
    
    let bit = _randseed & 1;
    
    _randseed = Math.abs(newbit << 31) + Math.floor(_randseed / 2);
    
    _randseed = Math.abs(_randseed % 0x100000000);
    
    return bit ? 1 : 0;
}

// random number in the range [min, max)
function random(min, max)
{
    let num = randbit();
    
    for (let i = 0; i < 31; i++) {
        num *= 2;
        num += randbit();
    }
    
    return Math.floor((num / 0x100000000) * (max - min)) + min;
}

function forwardby(time)
{
    while (time--) {
        if (!raceiter())
            return false;
    }
    
    return true;
}

function raceiter()
{
    let i = random(0, 5); 
    
    places[i]++;
    
    if (places[i] >= racelength) {
        drawrace();
        return false;
    } else {
        return true;
    }
}

async function drawrace()
{
    const h = canvas.height;
    const w = canvas.width;
    
    const h5 = h / 5;
    const h30 = h / 30;
    const w20 = w / 23;
    
    ctx.fillStyle = '#FFF';
    ctx.fillRect(0, 0, w, h);
    
    let black = false;
    
    for (let x = 0; x < 4; x++) {
        for (let y = 0; y < 30; y++) {
            if (black)
                ctx.fillStyle = '#FFF';
            else
                ctx.fillStyle = '#000';
            black = !black;
            
            ctx.fillRect(w - w20 * 1.75 + x * h30, y * h30, h30, h30);
        }
        
        black = !black;
    }
    
    ctx.font = '25px arial';
    
    for (let i = 0; i < 5; i++)
        ctx.fillText(names[i], w20 * 0.5, h5 * (i + 1) - h5 * 0.5);
    
    for (let i = 0; i < 5; i++)
        ctx.drawImage(snailimg, w20 * places[i], h5 * i, w20 * 2.5, h5);
}

function drawwinscreen()
{
    const h2 = canvas.height / 2;
    const w2 = canvas.width / 2;
    
    drawrace();
    
    ctx.strokeStyle = '#000';
    ctx.fillStyle   = '#FFF';
    roundRect(ctx, w2 / 2, h2 / 2, w2, h2, 10);
    
    let winner;
    
    for (let i = 0; i < places.length; i++) {
        if (places[i] >= racelength) {
            winner = names[i];
            break;
        }
    }
    
    ctx.fillStyle = '#000';
    ctx.font = '25px arial';
    
    ctx.fillText(`${winner} won!`, w2 * 0.9, h2);
}

async function drawdelay(time)
{
    const h = canvas.height;
    const w = canvas.width;
    
    ctx.fillStyle = '#FFF';
    ctx.fillRect(0, 0, w, h);
    
    ctx.fillStyle = '#000';
    ctx.font = '25px arial';
    
    ctx.fillText(`Time remaining: ${time}`, w / 3, h / 2);
}

setInterval(() => {
    let timezone = Date.now() - Date.UTC();
    
    
}, 10000);

snailimg.onload = async () => {
    while (true) {
        let xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = async () => {
            if (xhttp.readyState == xhttp.DONE) {
                let obj = JSON.parse(xhttp.responseText);
                
                if (obj["race"] == 1) {
                    init(obj["seed"]);
                    
                    if (forwardby(obj["time"]))
                        drawrace();
                    else {
                        drawwinscreen();
                    }
                } else {
                    drawdelay(obj["time"]);
                }
            }
        };
        
        xhttp.open('GET', '_update.php?action=info');
        xhttp.send();
        
        await delay(500);
    }
};
