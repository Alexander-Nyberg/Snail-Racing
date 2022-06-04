function changeShow(id)
{
    const div = document.getElementById(id);
    
    if (div.style.display == 'block' || !div.style.display)
        div.style.display = 'none';
    else
        div.style.display = 'block';
}
