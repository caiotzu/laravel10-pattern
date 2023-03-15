
$(function($) {
  const _url = window.location.origin,
        _token = $(':input[name=_token]').val(),
        userPermission = JSON.parse(localStorage.getItem('userPermission'));

  $('.select-2-county').select2({
    ajax: {
      url: `${_url}/ajax/countySearch`,
      dataType: 'json',
      method: 'GET',
      headers: { 'X-CSRF-TOKEN' : _token },

      data: function (params) { return { county: params.term, page: params.page }; },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results:  $.map(data, function (county) {
            return {
              text: `${county.id} - ${county.county}/${county.uf}`,
              id: county.id
            }
          }),
          pagination: { more: (params.page * 30) < data.total_count }
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) { return markup; },
    minimumInputLength: 3,
    language: {
      inputTooShort: function () { return'Por favor, digite 3 ou mais caracteres'}
    },
  });

  $(':input[name=cnpj]').on('blur', function(e) {
    const cnpj = $(this).cleanVal(),
      elmMessage = $('#divMessage');

    if(!isValidCnpj(cnpj)) {
      $(':input[name=cnpj]').val('');
      showMessageBox(`O CNPJ (<strong>${formatCpfCnpj(cnpj)}</strong>) é inválido`, 'D', elmMessage, 'after');
      return false;
    }
    $('#errorMessage').remove();
  });

  $(':input[name=user_cpf]').on('blur', function(e) {
    const cpf = $(this).cleanVal(),
      elmMessage = $('#divMessage');

    if(!isValidCpf(cpf)) {
      $(':input[name=user_cpf]').val('');
      showMessageBox(`O CPF (<strong>${formatCpfCnpj(cpf)}</strong>) é inválido`, 'D', elmMessage, 'after');
      return false;
    }
    $('#errorMessage').remove();
  });

  $('select[name=company_type]').on('change', function(e) {
    e.preventDefault();
    const companyType = $('select[name=company_type] option:selected').val();

    if(companyType == 'filial')
      $('#divFilial').fadeIn();
    else
      $('#divFilial').fadeOut();
  });

  $('select[name=contact_type]').on('change', function(e) {
    e.preventDefault();
    const contactType = $('select[name=contact_type] option:selected').val();

    $(':input[name=contact_value]').val('');

    if(contactType == 'E')
      $(':input[name=contact_value]').unmask();
    else
      $(':input[name=contact_value]').mask(spMaskBehavior, spOptions);
  });

  $('a[name=btnAddContact]').on('click', function(e) {
    e.preventDefault();

    const contactType = $('select[name=contact_type] option:selected').val(),
          contactValue = $(':input[name=contact_value]').val(),
          elmMessage = $('#divMessage');

    let arrData = {},
        itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody'),
        main = true;

    if(!contactValue) {
      showMessageBox('Obrigatório informar o contato', 'D', elmMessage, 'after');
      return false;
    }

    $('#errorMessage').remove();

    for(let item of itens) {
      if(item.type == contactType && item.main) {
        main = false;
        break;
      }
    }

    arrData['type'] = contactType;
    arrData['value'] = contactValue;
    arrData['main'] = main;
    arrData['active'] = true;
    arrData['insert'] = 'S';

    itens.push(arrData);
    $(':input[name=arrContact]').val(JSON.stringify(itens));

    tableContact.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableContact.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="${itens[i].type}_contact"
                      value="${itens[i].value}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td data-title="Contato">${itens[i].value}</td>
              <td data-title="Tipo">${itens[i].type == 'E' ? 'E-mail' : 'Telefone'}</td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteContact" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditContact" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveContact" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }

    $(':input[name=contact_value]').val('');
    $('select[name=contact_type]').val('E').trigger('change');
  });

  $(document).on('click', 'a[name=btnEditContact]', function(e){
    e.preventDefault();

    const controlId = $(this).attr('data-id');
    let itens = JSON.parse($(':input[name=arrContact]').val());

    $('select[name=contact_type]').val(itens[controlId].type).trigger('change');
    $(':input[name=contact_value]').val(itens[controlId].value);

    $('a[name=btnSaveEditContact]').attr('data-id', controlId);
    $('a[name=btnSaveEditContact]').removeClass('hidden');
    $('a[name=btnCancelEditContact]').removeClass('hidden');
    $('a[name=btnAddContact]').addClass('hidden');
  });

  $('a[name=btnCancelEditContact]').on('click', function(e) {
    e.preventDefault();

    $('a[name=btnSaveEditContact]').attr('data-id', '');
    $('a[name=btnSaveEditContact]').addClass('hidden');
    $('a[name=btnCancelEditContact]').addClass('hidden');
    $('a[name=btnAddContact]').removeClass('hidden');

    $('select[name=contact_type]').val('E').trigger('change');
    $(':input[name=contact_value]').val('');
  });

  $('a[name=btnSaveEditContact]').on('click', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          contactType = $('select[name=contact_type] option:selected').val(),
          contactValue = $(':input[name=contact_value]').val(),
          elmMessage = $('#divMessage');

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    if(!contactValue) {
      showMessageBox('Obrigatório informar o contato', 'D', elmMessage, 'after');
      return false;
    }

    $('#errorMessage').remove();

    itens[controlId]['type'] = contactType;
    itens[controlId]['value'] = contactValue;
    itens[controlId]['insert'] = 'S';

    $(':input[name=arrContact]').val(JSON.stringify(itens));

    tableContact.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableContact.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="${itens[i].type}_contact"
                      value="${itens[i].value}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td data-title="Contato">${itens[i].value}</td>
              <td data-title="Tipo">${itens[i].type == 'E' ? 'E-mail' : 'Telefone'}</td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteContact" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditContact" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveContact" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }


    const tr = tableContact.find(`tr[data-id=${controlId}]`);
    tr.css('background-color', '#fcf0a8');
    tr.css('transition', 'background-color 1000ms linear');

    setTimeout(function() {
        tr.css('background-color', '#FFF');
        tr.css('transition', 'background-color 1000ms linear');
    }, 1800);

    $('a[name=btnSaveEditContact]').attr('data-id', '');
    $('a[name=btnSaveEditContact]').addClass('hidden');
    $('a[name=btnCancelEditContact]').addClass('hidden');
    $('a[name=btnAddContact]').removeClass('hidden');

    $('select[name=contact_type]').val('E').trigger('change');
    $(':input[name=contact_value]').val('');
  });

  $(document).on('click', 'a[name=btnDeleteContact]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    modal.show();
    $('button[name=confirmDelete]').attr('data-id', controlId);
    $('button[name=confirmDelete]').attr('data-type', 'contact');
  });

  $('button[name=confirmDelete]').on('click', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          typeToDelete = $(this).attr('data-type'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    if(typeToDelete == 'contact') {
      let itens = JSON.parse($(':input[name=arrContact]').val()),
          tableContact = $('#tableContact').find('tbody');

      if(itens[controlId]['id']) {
        itens[controlId]['main'] = false;
        itens[controlId]['active'] = false;
        itens[controlId]['insert'] = 'N';
      } else {
        itens.splice(controlId, 1);
      }

      modal.hide();
      $(':input[name=arrContact]').val(JSON.stringify(itens));
      tableContact.find(`tr[data-id=${controlId}]`).html('');
    } else {
      let itens = JSON.parse($(':input[name=arrAddress]').val()),
          tableAddress = $('#tableAddress').find('tbody');

      if(itens[controlId]['id']) {
        itens[controlId]['main'] = false;
        itens[controlId]['active'] = false;
        itens[controlId]['insert'] = 'N';
      } else {
        itens.splice(controlId, 1);
      }

      modal.hide();
      $(':input[name=arrAddress]').val(JSON.stringify(itens));
      tableAddress.find(`tr[data-id=${controlId}]`).html('');
    }
  });

  $(document).on('click', 'input[name=E_contact], input[name=T_contact]', function(e) {
    e.preventDefault();

    const contactType = $(this).attr('name').split('_')[0],
          controlId = $(this).attr('data-id');

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    for(let i in itens) {
      if(i === controlId && itens[i].type === contactType) {
        itens[i]['main'] = true;
      } else if(itens[i].type === contactType) {
        itens[i]['main'] = false;
      }
    }

    $(':input[name=arrContact]').val(JSON.stringify(itens));

    tableContact.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableContact.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input h-3"
                      type="radio"
                      name="${itens[i].type}_contact"
                      value="${itens[i].value}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td data-title="Contato">${itens[i].value}</td>
              <td data-title="Tipo">${itens[i].type == 'E' ? 'E-mail' : 'Telefone'}</td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteContact" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditContact" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveContact" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }
  });

  $(document).on('click', 'a[name=btnToggleActiveContact]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id');

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    itens[controlId]['active'] = !itens[controlId]['active'];

    $(':input[name=arrContact]').val(JSON.stringify(itens));

    if(itens[controlId]['active']) {
      tableContact.find(`tr[data-id=${controlId}]`).find('td').eq(3).html(`<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`);
      $(this).attr('title', 'Desativar endereço');
      $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <g color="#b91c1c">
            <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
            <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
            <path d="M12 2v4"></path>
            <path d="m2 2 20 20"></path>
          </g>
        </svg>
      `);
    } else {
      tableContact.find(`tr[data-id=${controlId}]`).find('td').eq(3).html(`<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`);
      $(this).attr('title', 'Ativar endereço');
      $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <g color="#15803d">
            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
            <line x1="12" y1="2" x2="12" y2="12"></line>
          </g>
        </svg>
      `);
    }
  });

  $(':input[name=address_zipCode]').on('blur', function(e) {
    e.preventDefault();

    const zipCode = $(this).cleanVal(),
          elmMessage = $('#divMessage');


    $('#errorMessage').remove();

    if(zipCode.length < 8) {
      showMessageBox('CEP inválido', 'D', elmMessage, 'after');
      return false;
    }

    $.ajax({
      url : `${_url}/ajax/zipCodeSearch`,
      headers: {'X-CSRF-TOKEN': _token},
      type : 'post',
      data : { zipCode },
    })
    .done(function(responseJson) {
      const response = JSON.parse(responseJson);

      if(response.error) {
        showMessageBox(response.message, 'D', elmMessage, 'before');
        return false;
      } else {
        const address = response.response;

        $(':input[name=address_address]').val(address.logradouro);
        $(':input[name=address_neighborhood]').val(address.bairro);

        const option = $(`<option value="${address.municipio.id}" selected>${address.municipio.id} - ${address.municipio.county}/${address.municipio.uf}</option>`);
        $('select[name=address_county]').html('').append(option).trigger('change');
      }
    })
    .fail(function(jqXHR, textStatus, response){
      const message = jqXHR.responseJSON.message || response;
      showMessageBox(message, 'D', elmMessage, 'after');
      return false;
    });
  });

  $('a[name=btnAddAddress]').on('click', function(e) {
    e.preventDefault();

    const zipCode = $(':input[name=address_zipCode]').val(),
          address = $(':input[name=address_address]').val(),
          number = $(':input[name=address_number]').val(),
          neighborhood = $(':input[name=address_neighborhood]').val(),
          complement = $(':input[name=address_complement]').val(),
          countyId = $('select[name=address_county] option:selected').val(),
          county = $('select[name=address_county] option:selected').text(),
          elmMessage = $('#divMessage');

    let arrData = {},
        errors = [],
        itens = JSON.parse($(':input[name=arrAddress]').val()),
        tableAddress = $('#tableAddress').find('tbody'),
        main = true;

    if(!zipCode)
      errors.push('Obrigatório informar o cep');
    if(!address)
      errors.push('Obrigatório informar o logradouro');
    if(!number)
      errors.push('Obrigatório informar o número do endereço');
    if(!neighborhood)
      errors.push('Obrigatório informar o bairro');
    if(!countyId)
      errors.push('Obrigatório informar o município');

    if(errors.length > 0) {
      showMessageBox(errors, 'D', elmMessage, 'after');
      return false;
    }

    $('#errorMessage').remove();

    for(let item of itens) {
      if(item.main) {
        main = false;
        break;
      }
    }

    arrData['zipCode'] = zipCode;
    arrData['address'] = address;
    arrData['number'] = number;
    arrData['neighborhood'] = neighborhood;
    arrData['complement'] = complement;
    arrData['countyId'] = countyId;
    arrData['county'] = county;
    arrData['main'] = main;
    arrData['active'] = true;
    arrData['insert'] = 'S';

    itens.push(arrData);
    $(':input[name=arrAddress]').val(JSON.stringify(itens));

    tableAddress.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableAddress.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="isMainAddress"
                      value="${i}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td>
                ${itens[i].zipCode} - ${itens[i].address}, nº ${itens[i].number} <br>
                ${itens[i].neighborhood}, ${itens[i].county}
                ${itens[i].complement ? `<br>Complemento: ${itens[i].complement}`: ''}
              </td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteAddress" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditAddress" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveAddress" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }

    $(':input[name=address_zipCode]').val('');
    $(':input[name=address_address]').val('');
    $(':input[name=address_number]').val('');
    $(':input[name=address_neighborhood]').val('');
    $(':input[name=address_complement]').val('');
    $('select[name=address_county]').val(null).trigger('change');
  });

  $(document).on('click', 'a[name=btnEditAddress]', function(e){
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          elmMessage = $('#divMessage');

    let itens = JSON.parse($(':input[name=arrAddress]').val());

    $(':input[name=address_zipCode]').val(itens[controlId].zipCode);
    $(':input[name=address_address]').val(itens[controlId].address);
    $(':input[name=address_number]').val(itens[controlId].number);
    $(':input[name=address_neighborhood]').val(itens[controlId].neighborhood);
    $(':input[name=address_complement]').val(itens[controlId].complement);

    $.ajax({
      url : `${_url}/ajax/getCountyById`,
      headers: {'X-CSRF-TOKEN': _token},
      type : 'GET',
      data : { id: itens[controlId].countyId },
    })
    .done(function(response) {

      if(!response) {
        showMessageBox('Não foi possível carregar o município', 'D', elmMessage, 'before');
        return false;
      } else {
        const option = $(`<option value="${response.id}" selected>${response.id} - ${response.county}/${response.uf}</option>`);
        $('select[name=address_county]').html('').append(option).trigger('change');
      }
    })
    .fail(function(jqXHR, textStatus, response){
      const message = jqXHR.responseJSON.message || response;
      showMessageBox(message, 'D', elmMessage, 'after');
      return false;
    });

    $('a[name=btnSaveEditAddress]').attr('data-id', controlId);
    $('a[name=btnSaveEditAddress]').removeClass('hidden');
    $('a[name=btnCancelEditAddress]').removeClass('hidden');
    $('a[name=btnAddAddress]').addClass('hidden');
  });

  $('a[name=btnCancelEditAddress]').on('click', function(e) {
    e.preventDefault();

    $('a[name=btnSaveEditAddress]').attr('data-id', '');
    $('a[name=btnSaveEditAddress]').addClass('hidden');
    $('a[name=btnCancelEditAddress]').addClass('hidden');
    $('a[name=btnAddAddress]').removeClass('hidden');

    $(':input[name=address_zipCode]').val('');
    $(':input[name=address_address]').val('');
    $(':input[name=address_number]').val('');
    $(':input[name=address_neighborhood]').val('');
    $(':input[name=address_complement]').val('');
    $('select[name=address_county]').val(null).trigger('change');
  });

  $('a[name=btnSaveEditAddress]').on('click', function(e) {
    console.log('aqui');
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          zipCode = $(':input[name=address_zipCode]').val(),
          address = $(':input[name=address_address]').val(),
          number = $(':input[name=address_number]').val(),
          neighborhood = $(':input[name=address_neighborhood]').val(),
          complement = $(':input[name=address_complement]').val(),
          countyId = $('select[name=address_county] option:selected').val(),
          county = $('select[name=address_county] option:selected').text(),
          elmMessage = $('#divMessage');

    let errors = [],
        itens = JSON.parse($(':input[name=arrAddress]').val()),
        tableAddress = $('#tableAddress').find('tbody');

    if(!zipCode)
      errors.push('Obrigatório informar o cep');
    if(!address)
      errors.push('Obrigatório informar o logradouro');
    if(!number)
      errors.push('Obrigatório informar o número do endereço');
    if(!neighborhood)
      errors.push('Obrigatório informar o bairro');
    if(!countyId)
      errors.push('Obrigatório informar o município');

    if(errors.length > 0) {
      showMessageBox(errors, 'D', elmMessage, 'after');
      return false;
    }

    $('#errorMessage').remove();

    itens[controlId]['zipCode'] = zipCode;
    itens[controlId]['address'] = address;
    itens[controlId]['number'] = number;
    itens[controlId]['neighborhood'] = neighborhood;
    itens[controlId]['complement'] = complement;
    itens[controlId]['countyId'] = countyId;
    itens[controlId]['county'] = county;
    itens[controlId]['insert'] = 'S';

    $(':input[name=arrAddress]').val(JSON.stringify(itens));

    tableAddress.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableAddress.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="isMainAddress"
                      value="${i}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td>
                ${itens[i].zipCode} - ${itens[i].address}, nº ${itens[i].number} <br>
                ${itens[i].neighborhood}, ${itens[i].county}
                ${itens[i].complement ? `<br>Complemento: ${itens[i].complement}`: ''}
              </td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteAddress" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditAddress" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveAddress" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }

    const tr = tableAddress.find(`tr[data-id=${controlId}]`);
    tr.css('background-color', '#fcf0a8');
    tr.css('transition', 'background-color 1000ms linear');

    setTimeout(function() {
        tr.css('background-color', '#FFF');
        tr.css('transition', 'background-color 1000ms linear');
    }, 1800);

    $('a[name=btnSaveEditAddress]').attr('data-id', '');
    $('a[name=btnSaveEditAddress]').addClass('hidden');
    $('a[name=btnCancelEditAddress]').addClass('hidden');
    $('a[name=btnAddAddress]').removeClass('hidden');

    $(':input[name=address_zipCode]').val('');
    $(':input[name=address_address]').val('');
    $(':input[name=address_number]').val('');
    $(':input[name=address_neighborhood]').val('');
    $(':input[name=address_complement]').val('');
    $('select[name=address_county]').val(null).trigger('change');
  });

  $(document).on('click', 'a[name=btnDeleteAddress]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    modal.show();
    $('button[name=confirmDelete]').attr('data-id', controlId);
    $('button[name=confirmDelete]').attr('data-type', 'address');
  });

  $(document).on('click', 'input[name=isMainAddress]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id');

    let itens = JSON.parse($(':input[name=arrAddress]').val()),
        tableAddress = $('#tableAddress').find('tbody');

    for(let i in itens) {
      if(i === controlId) {
        itens[i]['main'] = true;
      } else {
        itens[i]['main'] = false;
      }
    }

    $(':input[name=arrAddress]').val(JSON.stringify(itens));

    tableAddress.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableAddress.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="isMainAddress"
                      value="${i}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td>
                ${itens[i].zipCode} - ${itens[i].address}, nº ${itens[i].number} <br>
                ${itens[i].neighborhood}, ${itens[i].county}
                ${itens[i].complement ? `<br>Complemento: ${itens[i].complement}`: ''}
              </td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteAddress" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditAddress" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveAddress" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }
  });

  $(document).on('click', 'a[name=btnToggleActiveAddress]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id');

    let itens = JSON.parse($(':input[name=arrAddress]').val()),
        tableAddress = $('#tableAddress').find('tbody');

    itens[controlId]['active'] = !itens[controlId]['active'];

    $(':input[name=arrAddress]').val(JSON.stringify(itens));

    if(itens[controlId]['active']) {
      tableAddress.find(`tr[data-id=${controlId}]`).find('td').eq(2).html(`<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`);
      $(this).attr('title', 'Desativar endereço');
      $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <g color="#b91c1c">
            <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
            <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
            <path d="M12 2v4"></path>
            <path d="m2 2 20 20"></path>
          </g>
        </svg>
      `);
    } else {
      tableAddress.find(`tr[data-id=${controlId}]`).find('td').eq(2).html(`<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`);
      $(this).attr('title', 'Ativar endereço');
      $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <g color="#15803d">
            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
            <line x1="12" y1="2" x2="12" y2="12"></line>
          </g>
        </svg>
      `);
    }
  });

  $('button[name=btnFilter], button[name=btnSave]').on('click', function(e) {
    CreateLoading();
  });
});
