function number_format(number, decimals = 2, dec_point = ',', thousands_point = '.') {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}

function somenteNumeros(e) {
    var tecla = e.which || e.keyCode;

    if(tecla >= 48 && tecla <= 57)
    {
        return true;
    }
    else
    {
        return false;
    }
}