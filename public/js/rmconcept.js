function hideAlert()
{
    let container = document.getElementsByClassName('container');
    let alert = document.getElementsByClassName('alert');
    container[0].removeChild(alert[0]);
}

function timeOutAlert()
{
    setTimeout('hideAlert()', 5000);
}