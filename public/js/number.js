var Integer = (function(){
	return {
		filterInput : function(event) {
			var value = parseInt(String.fromCharCode(event.which));

			if ((8 != event.which) && ((0 == event.target.selectionStart && 0 == value) || isNaN(value))) {
				event.preventDefault();
			}
		},
	}
}) (jQuery);

var Money = (function(){
	return {
		formatInput : function(number, symbol, thousand, decimal, decimalPlaces) {
			decimalPlaces = !isNaN(decimalPlaces = Math.abs(decimalPlaces)) ? decimalPlaces : 2;
			symbol = symbol !== undefined ? symbol : '';
			thousand = thousand || ',';
			decimal = decimal || '.';

			number = this.removeThousandSymbols(number, thousand);

			if ('.' == thousand) {
				number = number.replace(/,/g, '.');
			}

			var negative = number < 0 ? "-" : "",
	    		i = parseInt(number = Math.abs(+number || 0).toFixed(decimalPlaces), 10) + "",
	    		j = (j = i.length) > 3 ? j % 3 : 0;
			
			return symbol + 
				   negative + 
				   (j ? i.substr(0, j) + thousand : '') + 
				   i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + 
				   (decimalPlaces ? decimal + Math.abs(number - i).toFixed(decimalPlaces).slice(2) : "");
		},

		removeThousandSymbols : function(number, thousand) {
			var regex = new RegExp(thousand, 'g');
			if ('.' == thousand) {
				regex = /\./g;
			}

			number = number.toString().replace(regex, '');

			if ('.' == thousand) {
				return number;
			}

			return parseFloat(number);
		},

		numbersOnly : function(number) {
			return number.replace(/[^0-9]/g, '');
		},
		isValidMoney : function(number) {
			return number.match(/^[0-9.]+$/);
		},
		getThousandSymbolbyCurrency : function(currency) {
			if(currency.indexOf('EUR') > -1) {
				return '.';
			}
			return ',';
		},

		getDecimalSymbolbyCurrency : function(currency) {
			if(currency.indexOf('EUR') > -1) {
				return ',';
			}
			return '.';
		},
	}
}) (jQuery);
