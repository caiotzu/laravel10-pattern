$(function($) {
  const _url = window.location.origin,
        _token = $(':input[name=_token]').val(),
        userPermission = JSON.parse(localStorage.getItem('userPermission'));

  $('a[name=btnAddCompanyAccess]').on('click', function(e) {
    e.preventDefault();

    const companyId = $('select[name=company_id] option:selected').val(),
          companyDescription = $('select[name=company_id] option:selected').text(),
          elmMessage = $('#divMessage');

    let arrData = {},
        itens = JSON.parse($(':input[name=arrUserAccessCompany]').val()),
        tableUserAccessCompanies = $('#tableUserAccessCompanies').find('tbody');

    if(!companyId) {
      showMessageBox('Obrigatório selecionar a empresa', 'D', elmMessage, 'after');
      return false;
    }

    for(let i in itens) {
      if(itens[i].companyId == companyId && itens[i].insert == 'S') {
        showMessageBox('Está empresa já está adicionada', 'D', elmMessage, 'after');
        return false;
      }
    }

    $('#errorMessage').remove();

    arrData['companyId'] = companyId;
    arrData['companyDescription'] = companyDescription;
    arrData['insert'] = 'S';
    arrData['allowDeletion'] = 'S';

    itens.push(arrData);
    $(':input[name=arrUserAccessCompany]').val(JSON.stringify(itens));

    tableUserAccessCompanies.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableUserAccessCompanies.append(`
          <tr data-id="${i}" style="background-color:${itens[i].allowDeletion == 'S' ? '' : '#f1f5f9'}">
              <td data-title="Contato">${itens[i].companyDescription}</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                ${itens[i].allowDeletion == 'S' ?
                  `<a href="#" name="btnDeleteCompanyAccess" data-id="${i}" title="Excluir o acesso a empresa">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>`
                  :
                  ``
                }
                </div>
              </td>
          </tr>
        `);
      }
    }

    $('select[name=company_id]').val(null).trigger('change');
  });

  $(document).on('click', 'a[name=btnDeleteCompanyAccess]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    modal.show();
    $('button[name=confirmDelete]').attr('data-id', controlId);
  });

  $('button[name=confirmDelete]').on('click', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    let itens = JSON.parse($(':input[name=arrUserAccessCompany]').val()),
        tableUserAccessCompanies = $('#tableUserAccessCompanies').find('tbody');


    if(itens[controlId]['id']) {
      itens[controlId]['insert'] = 'N';
    } else {
      itens.splice(controlId, 1);
    }

    modal.hide();
    $(':input[name=arrUserAccessCompany]').val(JSON.stringify(itens));
    tableUserAccessCompanies.find(`tr[data-id=${controlId}]`).html('');
  });

  $('button[name=btnSave]').on('click', function(e) {
    CreateLoading();
  });
});
