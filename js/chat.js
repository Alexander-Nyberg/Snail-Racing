const input = document.getElementById('sendmsg-input');
let msgs = document.getElementById('msg-container-div');

let msglist = [];
let done = true;
let forcebottom = false;

input.addEventListener('keyup', async (e) => {
    if (e.code != 'Enter' && input.value.length)
        return;
    
    let msg = input.value;
    input.value = '';
    
    await pushMsg(msg);
});

async function waitfor(func, expected, wait = 5)
{
    while (func() != expected)
        await new Promise(r => setTimeout(r, wait));
}

async function waitless(func, expected, wait = 5)
{
    while (func() < expected)
        await new Promise(r => setTimeout(r, wait));
}

async function getMsgs()
{
    msglist = [];
    
    let xhttp = new XMLHttpRequest();
    
    done = false;
    
    setTimeout(() => { done = true; }, 1000);
    
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == xhttp.DONE) {
            let strs = unescapeChars(xhttp.responseText).split('\r\n');
            strs.pop();
            for (let i = 0; i < strs.length; i++)
                msglist.push(JSON.parse(strs[i]));
            done = true;
        }
    };
    
    xhttp.open('GET', `_msgs.php?action=get`);
    xhttp.send();
    
    await waitfor(() => { return done; }, true);
}

async function pushMsg(msg)
{
    let xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = () => {};
    
    xhttp.open('POST', `_msgs.php?uid=${__uid}&uname=${__uname}&pwd=${__pwd}&action=send`);
    xhttp.send(msg);
    
    forcebottom = true;
}

async function fetch()
{
    await getMsgs();
    
    let newdiv = document.createElement('div');
    newdiv.id = 'msg-container-div';
    
    for (let i = 0; i < msglist.length; i++) {
        let maindiv = document.createElement('div');
        let head = document.createElement('div');
        let uname = document.createElement('div');
        let date = document.createElement('div');
        let content = document.createElement('div');
        let sep = document.createElement('hr');
        
        sep.className = 'msg-line-sep';
        
        content.className = 'msg-content-div';
        content.innerHTML = escapehtml(msglist[i]['content']);
        //console.log(msglist[i]['content']);
        uname.className = 'msg-uname-div';
        uname.innerHTML = escapehtml(msglist[i]['uname'] + (parseInt(msglist[i]['admin']) ? ' [admin]' : ''));
        uname.style.color = msglist[i]['color'];
        
        date.className = 'msg-date-div';
        date.innerHTML = formatDate(msglist[i]['date']);
        
        head.className = 'msg-header-div';
        
        head.appendChild(uname);
        head.appendChild(date);
        
        maindiv.className = 'message-div';
        
        maindiv.appendChild(sep);
        maindiv.appendChild(head);
        maindiv.appendChild(content);
        
        newdiv.appendChild(maindiv);
    }
    
    let height = msgs.scrollHeight - msgs.clientHeight;
    let bottom = forcebottom || msgs.scrollTop + 10 >= height;
    let top = msgs.scrollTop;
    
    //console.log(msgs.scrollHeight, msgs.clientHeight, height, bottom, top);
    
    msgs.replaceWith(newdiv);
    
    newdiv.scrollTop = bottom ?
        newdiv.scrollHeight :
        top;
    
    msgs = newdiv;
    forcebottom = false;
}

setInterval(fetch, 1500);

function unescapeChars(str)
{
    let out = '';
    
    const unmap = {
        'a':  '\a',
        'b':  '\b',
        'f':  '\f',
        'n':  '\n',
        'r':  '\r',
        't':  '\t',
        'v':  '\v',
        '0':  '\0',
        '\"': '\"',
        '\'': '\'',
    };
    
    for (let i = 0; i < str.length; i++) {
        if (str[i] == '\\')
            out += unmap[str[++i]];
        else
            out += str[i];
    }
    
    return out;
}

function escapehtml(str)
{
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function formatDate(date)
{
    return date;
}

fetch();
