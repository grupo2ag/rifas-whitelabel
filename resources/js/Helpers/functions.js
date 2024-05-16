export const maskString = (str, pattern) => {
    let ptt = '';
    if(pattern === 'tel') ptt = '(##) #####-####';
    if(pattern === 'cpf') ptt = '###.###.###-##';
    if(pattern === 'cnpj') ptt = '##.###.###/####-##';
    str = str.toString()

        let i = 0;
        let padded = ptt.replace(/#/g, () => {
            return str[i++];
        });
        return padded;
    };

export const monthName = (month) => {
    let months = [ 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    return months[month];
};

export const monthNameAbbreviation = (month) => {
    let months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    return months[month];
};

export const formatValue = (value) => {
    let number = parseInt(value);

    let result = number/100;
    return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(result);
};

export const formatPhone = (value) => {
    return value.replace('(','').replace(')', '').replace(' ', '').replace('-', '');
};

export const formatNumber = (number, decimals, dec_point, thousands_sep) => {
    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;
    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec);
    var abs = Math.abs(n).toFixed(prec);
    var _, i;
    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;
        _[0] = s.slice(0, i + (n < 0)) + _[0].slice(i).replace(/(\d{3})/g, sep + '$1');
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }
    return s;
}

export const formatInteger = (value) => {
   return parseInt(value*100);
};

export const formatLimit = (value) => {
    let number = parseInt(value);

    let result = number/100;
    return parseInt(result);
};

export const formatBr = (value) => {
    return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(value);
};

export const formatTax = (value, type = 1) => {
    let number = parseInt(value);

    let result = number/1000000;
    if(type === 1) return Intl.NumberFormat('pt-br', {style: 'decimal', currency: 'BRL'}).format(result);
    if(type === 2) return parseFloat(result).toFixed(2);
};

export const returnValue = (tax, number, status) => {
    let result = parseFloat(tax) * parseInt(number)

    if(status === 0){
        return formatValue(0);
    } else if(status === 1){
        return formatValue(result);
    } else {
        return formatValue(result);
    }
};

export const adicionaZero = (numero) => {
    if (numero <= 9)
        return "0" + numero;
    else
        return numero;
}

export const dateFormat = (date, hours, seconds = false) => {
    let dataAtual = new Date(date);
    let data = (adicionaZero(dataAtual.getDate().toString()) + "/" + (adicionaZero(dataAtual.getMonth()+1).toString()) + "/" + dataAtual.getFullYear());

    if(hours){
        let horas = (adicionaZero(dataAtual.getHours().toString()) + ":" + (adicionaZero(dataAtual.getMinutes()).toString()));
        if(seconds) horas += ":" + adicionaZero(dataAtual.getSeconds()).toString();
        return data+' '+horas;
    }else{
        return data;
    }
};

export const firstUpper = (string = '') =>{
    string  = string.toLowerCase();
    return string.split(' ').map(function (item){
        return item.charAt(0).toUpperCase() + item.slice(1);
    }).join(' ');
}

export const limitString = (string, length = 20) => {
    return (string.length <= length) ? string : string.substring(0,length) + '...';
}

export const hourSeconds = (seconds) =>
{
    if(!seconds) {
        return '00:00:00';
    }

    // console.log(seconds)

    var extenso = '';
    let x = seconds.split(':');


    if(x[0] != 0) {
        extenso = x[0] + ' h ';
    }
    extenso = x[1] + ' min '+ x[2] + 's';

    return extenso;
}
/*
export const dddFormat = (phone) => {
    let states = [
        {"nome": "Acre", "sigla": "AC", "ddd": [68]},
        {"nome": "Alagoas", "sigla": "AL", "ddd": [82]},
        {"nome": "Amapá", "sigla": "AP", "ddd": [96]},
        {"nome": "Amazonas", "sigla": "AM", "ddd": [92, 97]},
        {"nome": "Bahia", "sigla": "BA", "ddd": [71, 73, 74, 75, 77]},
        {"nome": "Ceará", "sigla": "CE", "ddd": [85, 88]},
        {"nome": "Distrito Federal","sigla": "DF", "ddd": [61]},
        {"nome": "Espírito Santo","sigla": "ES", "ddd": [27, 28]},
        {"nome": "Goiás", "sigla": "GO", "ddd": [62, 64]},
        {"nome": "Maranhão", "sigla": "MA", "ddd": [98, 99]},
        {"nome": "Mato Grosso","sigla": "MT", "ddd": [65, 66]},
        {"nome": "Mato Grosso do Sul", "sigla": "MS", "ddd": [67]},
        {"nome": "Minas Gerais", "sigla": "MG", "ddd": [31, 32, 33, 34, 35, 37, 38]},
        {"nome": "Pará", "sigla": "PA", "ddd": [91, 93, 94]},
        {"nome": "Paraíba", "sigla": "PB", "ddd": [83]},
        {"nome": "Paraná", "sigla": "PR", "ddd": [41, 42, 43, 44, 45, 46]},
        {"nome": "Pernambuco", "sigla": "PE", "ddd": [81, 87]},
        {"nome": "Piauí", "sigla": "PI", "ddd": [86, 89]},
        {"nome": "Rio de Janeiro", "sigla": "RJ", "ddd": [21, 22, 24]},
        {"nome": "Rio Grande do Norte", "sigla": "RN", "ddd": [84]},
        {"nome": "Rio Grande do Sul", "sigla": "RS", "ddd": [51, 53, 54, 55]},
        {"nome": "Rondônia", "sigla": "RO", "ddd": [69]},
        {"nome": "Roraima", "sigla": "RR", "ddd": [95]},
        {"nome": "Santa Catarina","sigla": "SC", "ddd": [47, 48, 49]},
        {"nome": "São Paulo","sigla": "SP", "ddd": [11, 12, 13, 14, 15, 16, 17, 18, 19]},
        {"nome": "Sergipe", "sigla": "SE", "ddd": [79]},
        {"nome": "Tocantins", "sigla": "TO", "ddd": [63]}
    ]

    let ddd = states.filter((item) => {

    })

    let result = states.filter(item => {
        // for(let i = 0; i < item.ddd.length; i++){
            console.log(item.ddd.map)
        // }
    })

    // console.log(result)

    /!*let ddd = states.filter((item) => {
        return (item.ddd == phone)
    })*!/

    // console.log(ddd)

    return ddd;
}*/

export const mountUrl = (url, category, subcategory) =>
{
    return route('') + category + '/' + (subcategory ? subcategory + '/' : '') + url;
}

export const slugify = str =>
    str
        .toLowerCase()
        .trim()
        .replace(/[ÀÁÂÃÄÅ]/,"A")
        .replace(/[àáâãäå]/,"a")
        .replace(/[ÈÉÊË]/,"E")
        .replace(/[èéêë]/,"e")
        .replace(/[Ç]/,"C")
        .replace(/[ç]/,"c")
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');

/*
export const imitateText = (text, limit) =>
{
    let count = text.length;
    if (count > limit) {
        let newText = substr($texto, 0, $limite) . '...';
        return newText;
    } else {
        return $texto;
    }
}
*/

export const emailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)

export const clieanString = (string) => {
    /** TIRAR ACENTOS */

    string = string.replace(new RegExp('[ÁÀÂÃ]','gi'), 'a');
    string = string.replace(new RegExp('[ÉÈÊ]','gi'), 'e');
    string = string.replace(new RegExp('[ÍÌÎ]','gi'), 'i');
    string = string.replace(new RegExp('[ÓÒÔÕ]','gi'), 'o');
    string = string.replace(new RegExp('[ÚÙÛ]','gi'), 'u');
    string = string.replace(new RegExp('[Ç]','gi'), 'c');

    /** TIRAR CARACTERES ESPECIAIS */
    return string.replaceAll(/[^a-zA-Z0-9\- ]/g, "");
}
