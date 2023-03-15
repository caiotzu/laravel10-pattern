// loadings page
$( document ).ajaxStop(function() {
  RemoveLoading();
});
//---

// behavior
  const cpfCnpjMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
  }, CpfCnpjOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(cpfCnpjMaskBehavior.apply({}, arguments), options);
    }
  };

  const spMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  }, spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(spMaskBehavior.apply({}, arguments), options);
    }
  };
//---

// functions
  const formatDate = (date, formatIn = 'YYYY-MM-DD', formatOut = 'DD/MM/YYYY') => {
    const momentDate = moment(date, formatIn);
    if(!momentDate.isValid()) {
      return date;
    }
    return momentDate.format(formatOut);
  }

  const formatPhone = function (val) {
    if (val !== '' && val !== null) {
      val = val.replace(/\D+/g, '');

      if (val.length == 8) // Telefone fixo sem DDD
        return val.substr(0, 4)+'-'+val.substr(-4);
      else if (val.length == 9) // Celular sem DDD
        return val.substr(0, 5)+'-'+val.substr(-4);
      else if (val.length == 10) // Telefone fixo com DDD
        return '('+val.substr(0, 2)+') '+val.substr(2, 4)+'-'+val.substr(-4);
      else if (val.length == 11) // Celular com DDD
        return '('+val.substr(0, 2)+') '+val.substr(2, 5)+'-'+val.substr(-4);
      else if (val.length == 12) // Telefone fixo com DDD e DDI do Brasil
        return '+'+val.substr(0, 2)+' ('+val.substr(2, 2)+') '+val.substr(4, 4)+'-'+val.substr(-4);
      else if (val.length == 13) // Celular com DDD e DDI do Brasil
        return '+'+val.substr(0, 2)+' ('+val.substr(2, 2)+') '+val.substr(4, 5)+'-'+val.substr(-4);
      else
        return '';
    } else
      return '';
  }

  const formatMoney = (value, locale = 'pt-BR', currencySign = false) => {

    const currentValue = value.replace(/\D/gim, '');
    let options = {};
    let currency = '';
    let style = 'currency';

    // Get currency with locale
    switch (locale) {
      case 'en-US':
        currency = 'USD';
        break;
      default:
        currency = 'BRL';
        break;
    }

    // Verify with currencySign
    if(!currencySign)
      options = {minimumFractionDigits: 2};
    else
      options = {style, currency};

    if(currentValue.length >= 3){
      const position = parseInt(currentValue.length) - 2;
      const formattedValue = `${currentValue.substr(0,position)}.${currentValue.substr(-2)}`;
      return parseFloat(formattedValue).toLocaleString(locale, options);
    } else {
      return `${currentValue},00`;
    }
  }

  const formatZipCode = (value) => {
    const currentValue = value.replace(/\D/gim, '');

    return `${currentValue.substring(0, 5)}-${currentValue.substring(5, 8)}`;
  }

  const showMessageBox = function (msg, type, elm_ins, ins_place) {
    try {
      if ( (typeof msg != 'string' && !Array.isArray(msg)) || msg.length < 1)
        throw Error('Parâmetro da mensagem é inválido.');

      if (typeof type != 'string' || !['I', 'S', 'D', 'W'].includes(type))
        throw Error('Parâmetro tipo é inválido.');

      if (typeof ins_place != 'string' || !['after', 'before', 'append', 'prepend'].includes(ins_place))
        ins_place = 'after';

      if (!elm_ins)
        throw Error('Parâmetro elemento é inválido.');


      let boxMessage = '';

      switch (type) {
        case 'S':
          boxMessage = `
            <div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4 relative" role="alert">
              <p class="font-bold text-lg mb-2 relative">Sucesso</p>
              <p> ${
                typeof msg == 'string' ? `<span class="text-lg">&raquo;</span> ${msg}<br>` :
                `<span class="text-lg">&raquo;</span> ${msg.join('<br><span class="text-lg">&raquo;</span> ')}`
              }
              </p>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
              <a onClick="(function(){document.getElementById('successMessage').remove();return false;})();return false;" style="cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </a>
              </span>
            </div>
          `
          break;
        case 'D':
          boxMessage = `
            <div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4 relative" role="alert">
              <p class="font-bold text-lg mb-2 relative">Erro</p>
              <p> ${
                typeof msg == 'string' ? `<span class="text-lg">&raquo;</span> ${msg}<br>` :
                `<span class="text-lg">&raquo;</span> ${msg.join('<br><span class="text-lg">&raquo;</span> ')}`
              }
              </p>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <a onClick="(function(){document.getElementById('errorMessage').remove();return false;})();return false;" style="cursor: pointer;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </a>
              </span>
            </div>
          `
          break;
        case 'W':
          boxMessage = `
            <div id="warningMessage" class="border-l-4 p-4 mt-4 relative" role="alert" style="background-color: #fef3c7; border-color: #f59e0b; color: #b45309">
              <p class="font-bold text-lg mb-2 relative">Aviso</p>
              <p> ${
                typeof msg == 'string' ? `<span class="text-lg">&raquo;</span> ${msg}<br>` :
                `<span class="text-lg">&raquo;</span> ${msg.join('<br><span class="text-lg">&raquo;</span> ')}`
              }
              </p>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <a onClick="(function(){document.getElementById('warningMessage').remove();return false;})();return false;" style="cursor: pointer;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </a>
              </span>
            </div>
          `
          break;
        case 'I':
          boxMessage = `
            <div id="infoMessage" class="border-l-4 p-4 mt-4 relative" role="alert" style="background-color: #e0e7ff; border-color: #6366f1; color: #1d4ed8">
              <p class="font-bold text-lg mb-2 relative">Informação</p>
              <p> ${
                typeof msg == 'string' ? `<span class="text-lg">&raquo;</span> ${msg}<br>` :
                `<span class="text-lg">&raquo;</span> ${msg.join('<br><span class="text-lg">&raquo;</span> ')}`
              }
              </p>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <a onClick="(function(){document.getElementById('infoMessage').remove();return false;})();return false;" style="cursor: pointer;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </a>
              </span>
            </div>
          `
          break;
      }

      switch (ins_place) {
        case 'after':
          elm_ins.after(boxMessage)
          break;
        case 'before':
          elm_ins.before(boxMessage)
          break;
        case 'append':
        case 'prepend':
          elm_ins.append(boxMessage)
          break;
      }

      return true;
    } catch (e) {
      console.log(e);
      return false;
    }
  };

  const CreateLoading = function () {
    $('.wrapper-loading').show();
  };

  const RemoveLoading = function () {
    $('.wrapper-loading').hide();
  };
//---

// validate
  function isValidCpf(cpf) {
    try {
      if (!cpf)
        return false;

      cpf = cpf.replace(/\D/g, '');
      cpf = ('00000000000'+cpf).slice(-11);

      if (cpf.length != 11)
        return false;

      else if (cpf == '00000000000' || cpf == '11111111111' || cpf == '22222222222' || cpf == '33333333333' || cpf == '44444444444' ||
                cpf == '55555555555' || cpf == '66666666666' || cpf == '77777777777' || cpf == '88888888888' || cpf == '99999999999')
        return false;

      else {
        for (var t = 9; t < 11; t++) {
          for (var d = 0, c = 0; c < t; c++) {
            d += cpf[c] * ((t + 1) - c);
          }
          d = ((10 * d) % 11) % 10;
          if (cpf[c] != d) {
            return false;
          }
        }
        return true;
      }
    } catch (e) {
    } {
      return false;
    }
  }

  function isValidCnpj(cnpj){
    try {
      if (!cnpj)
        return false;

      var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2),
          dig1= new Number,
          dig2= new Number;

      cnpj = cnpj.toString().replace(/\D/g, '');
      var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));

      for(i = 0; i<valida.length; i++){
              dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);
              dig2 += cnpj.charAt(i)*valida[i];
      }
      dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
      dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

      if(((dig1*10)+dig2) != digito)
        return false;
      else
        return true;
    }
    catch (e) {
      return false;
    }
  }
//---

$('.money').mask('#.##0,00', {reverse: true});
$('.cpfCnpj').mask(cpfCnpjMaskBehavior, CpfCnpjOptions);
$('.celPhone').mask(spMaskBehavior, spOptions);
$('.cpf').mask('000.000.000-00');
$('.cnpj').mask('00.000.000/0000-00');
$('.cep').mask('00000-000');
$('.placa').mask('SSS0A00');
$('.placa').css("text-transform", "uppercase");
$('.chassi').mask('AAAAAAAAAAAAAAAAA');
$('.chassi').css("text-transform", "uppercase");
$('.renavam').mask('00000000000');


$('.select-2').select2({
  placeholder: 'Selecione um registro',
  allowClear: true
});

// Pega o nome do arquivo selecionado no input file da tela atual
$('.selected-file').on('change', function(e) {
  e.preventDefault();

  $('.selected-file-name').html('');
  $('.selected-file-name').text(this.files[0].name);
});
//---
