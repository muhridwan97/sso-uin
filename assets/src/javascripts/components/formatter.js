export default {
    numberFormat: function (number, decimalsLength, decimalSeparator, thousandSeparator) {
        var n = number,
            decimalsLength = isNaN(decimalsLength = Math.abs(decimalsLength)) ? 0 : decimalsLength,
            decimalSeparator = decimalSeparator == undefined ? "," : decimalSeparator,
            thousandSeparator = thousandSeparator == undefined ? "." : thousandSeparator,
            sign = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(decimalsLength)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;

        return sign +
            (j ? i.substr(0, j) + thousandSeparator : "") +
            i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousandSeparator) +
            (decimalsLength ? decimalSeparator + Math.abs(n - i).toFixed(decimalsLength).slice(2) : "");
    }
};
