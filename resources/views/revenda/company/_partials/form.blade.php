@csrf

<div class="p-2 col-span-12">
  <div class="preview">
    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap" role="tablist">
      <li id="company" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2 active"
          data-tw-toggle="pill"
          data-tw-target="#tab-company"
          type="button"
          role="tab"
          aria-controls="tab-company"
          aria-selected="true"
        >
          Empresa
        </button>
      </li>
      <li id="contacts" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2"
          data-tw-toggle="pill"
          data-tw-target="#tab-contacts"
          type="button" role="tab"
          aria-controls="tab-contacts"
          aria-selected="false"
        >
          Contatos
        </button>
      </li>
      <li id="addresses" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2"
          data-tw-toggle="pill"
          data-tw-target="#tab-addresses"
          type="button" role="tab"
          aria-controls="tab-addresses"
          aria-selected="false"
        >
          Endereços
        </button>
      </li>
      @if(!isset($company->id))
        <li id="user" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
          <button
            class="nav-link w-full py-2"
            data-tw-toggle="pill"
            data-tw-target="#tab-user"
            type="button" role="tab"
            aria-controls="tab-user"
            aria-selected="false"
          >
            Usuário responsável
          </button>
        </li>
      @endif
    </ul>

    <div class="tab-content border-l border-r border-b">
      <div id="tab-company" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="company">

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="company_type" class="form-label">Tipo empresa <span class="text-red-500">*</span></label>
            <select class="form-select py-2.5" id="company_type" name="company_type">
              @if(!!old())
                <option value="matriz" @if(old('company_type') == 'matriz') selected @endif>Matriz</option>
                <option value="filial" @if(old('company_type') == 'filial') selected @endif>Filial</option>
              @elseif(isset($company))
                <option value="matriz" @if($company->headquarter_id == null) selected @endif>Matriz</option>
                <option value="filial" @if($company->headquarter_id != null) selected @endif>Filial</option>
              @else
                <option value="matriz" selected>Matriz</option>
                <option value="filial">Filial</option>
              @endif
            </select>
          </div>

          <div class="col-span-12 md:col-span-4 p-2
            @if(!!old())
              @if(old('company_type') == 'matriz')
                hidden
              @endif
            @elseif(isset($company))
              @if($company->headquarter_id == null)
                hidden
              @endif
            @else
              hidden
            @endif
            "
            id="divFilial"
          >
            <label for="headquarter_id" class="form-label">Filial da empresa <span class="text-red-500">*</span></label>
            <select class="tom-select w-full" id="headquarter_id" name="headquarter_id">
              @if(isset($data['headquarter_id']) && $data['headquarter_id'] == '')
                <option value="" selected>Selecione a matriz</option>
              @else
                <option value="">Selecione a matriz</option>
              @endif

              @foreach($companies as $c)
                @if(!!old())
                  @if(old('headquarter_id') == $c->id)
                    <option value="{{ $c->id }}" selected>{{ $c->trade_name }}</option>
                  @else
                    <option value="{{ $c->id }}">{{ $c->trade_name }}</option>
                  @endif
                @elseif(isset($company) && $company->headquarter_id == $c->id)
                  <option value="{{ $c->id }}" selected>{{ $c->trade_name }}</option>
                @else
                  <option value="{{ $c->id }}" >{{ $c->trade_name }}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="cnpj" class="form-label">CNPJ <span class="text-red-500">*</span></label>
            <input id="cnpj" name="cnpj" type="text" class="form-control w-full py-2.5 cnpj" value="{{ old('cnpj', $company->cnpj ?? '') }}">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="trade_name" class="form-label">Nome fantasia <span class="text-red-500">*</span></label>
            <input id="trade_name" name="trade_name" type="text" class="form-control w-full py-2.5" value="{{ old('trade_name', $company->trade_name ?? '') }}" maxlength="60">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="company_name" class="form-label">Razão social <span class="text-red-500">*</span></label>
            <input id="company_name" name="company_name" type="text" class="form-control w-full py-2.5" value="{{ old('company_name', $company->company_name ?? '') }}" maxlength="60">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="state_registration" class="form-label">Inscrição estadual <span class="text-red-500">*</span></label>
            <input id="state_registration" name="state_registration" type="text" class="form-control w-full py-2.5" value="{{ old('state_registration', $company->state_registration ?? '') }}" maxlength="9">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="municipal_registration" class="form-label">Inscrição municipal <span class="text-red-500">*</span></label>
            <input id="municipal_registration" name="municipal_registration" type="text" class="form-control w-full py-2.5" value="{{ old('municipal_registration', $company->municipal_registration ?? '') }}" maxlength="11">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-4 p-2">
            <div class="form-check mt-2">
              <input id="active" name="active" class="form-check-input" type="checkbox"
                @if(!!old())
                  @if(old('active') == 'on') checked @endif
                @elseif(isset($company))
                  @if($company->active) checked @endif
                @else
                  checked
                @endif
              >
              <label class="form-check-label" for="active">Ativa</label>
            </div>
          </div>
        </div>

      </div>
      <div id="tab-contacts" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="contacts">
        <input type="hidden" name="arrContact" value="{{ old('arrContact', $companyContacts ?? "[]") }}">

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="contact_type" class="form-label">Tipo contato <span class="text-red-500">*</span></label>
            <select class="form-select py-2.5" id="contact_type" name="contact_type">
              <option value="E" selected>E-mail</option>
              <option value="T">Telefone</option>
            </select>
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="contact_value" class="form-label">Contato <span class="text-red-500">*</span></label>
            <input id="contact_value" name="contact_value" type="text" class="form-control w-full py-2.5">
          </div>

          <div class="col-span-12 md:col-span-4 p-2 md:mt-8">
            <a name="btnAddContact" class="btn btn-primary w-32 mr-2 mb-2">Adicionar</a>
            <a name="btnSaveEditContact" class="btn btn-primary w-32 mr-2 mb-2 hidden">Salvar</a>
            <a name="btnCancelEditContact" class="btn btn-secundary w-32 mr-2 mb-2 hidden">Cancelar</a>
          </div>
        </div>

        <div class="grid grid-cols-12">
          <table class="table col-span-12" id="tableContact">
            <thead>
              <tr>
                <th class="whitespace-nowrap">Principal</th>
                <th class="whitespace-nowrap">Contato</th>
                <th class="whitespace-nowrap">Tipo</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
              @php
                $constactsJson = old('arrContact', $companyContacts ?? "[]");
                $contacts = json_decode($constactsJson);
              @endphp
              @foreach($contacts as $k => $contact)
                <tr data-id="{{$k}}">
                  <td>
                    <div class="form-check mt-2">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="{{$contact->type}}_contact"
                        value="{{$contact->value}}"
                        data-id="{{$k}}"
                        {{$contact->main ? 'checked' : ''}}
                      >
                      <label class="form-check-label">{!!$contact->main ? 'Principal' : '&nbsp;'!!}</label>
                    </div>
                  </td>
                  <td data-title="Contato">{{$contact->value}}</td>
                  <td data-title="Tipo">{{$contact->type == 'E' ? 'E-mail' : 'Telefone'}}</td>
                  <td data-title="Status">
                    {!!
                      $contact->active ?
                      '<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>'
                      :
                      '<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>'
                    !!}
                  </td>
                  <td class="space-x-4">
                    <div class="flex gap-4 justify-center">
                      <a href="#" name="btnDeleteContact" data-id="{{$k}}" title="Excluir o endereço">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <g color="#b91c1c">
                            <path d="M3 6h18"></path>
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                          </g>
                        </svg>
                      </a>

                      <a href="#" name="btnEditContact" data-id="{{$k}}" title="Editar o endereço">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <g color="#4338ca">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                          </g>
                        </svg>
                      </a>

                      <a href="#" name="btnToggleActiveContact" data-id="{{$k}}" title="{{$contact->active ? 'Desativar endereço': 'Ativar endereço'}}">
                        {!!
                          $contact->active ?
                          '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <g color="#b91c1c">
                              <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                              <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                              <path d="M12 2v4"></path>
                              <path d="m2 2 20 20"></path>
                            </g>
                          </svg>'
                          :
                          '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <g color="#15803d">
                              <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                              <line x1="12" y1="2" x2="12" y2="12"></line>
                            </g>
                          </svg>'
                        !!}
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div id="tab-addresses" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="addresses">
        <input type="hidden" name="arrAddress" value="{{ old('arrAddress', $companyAddresses ?? "[]") }}">

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-2 p-2">
            <label for="address_zipCode" class="form-label">Cep <span class="text-red-500">*</span></label>
            <input id="address_zipCode" name="address_zipCode" type="text" class="form-control w-full py-2.5 cep">
          </div>

          <div class="col-span-12 md:col-span-8 p-2">
            <label for="address_address" class="form-label">Logradouro <span class="text-red-500">*</span></label>
            <input id="address_address" name="address_address" type="text" class="form-control w-full py-2.5" maxlength="100">
          </div>

          <div class="col-span-12 md:col-span-2 p-2">
            <label for="address_number" class="form-label">Número <span class="text-red-500">*</span></label>
            <input id="address_number" name="address_number" type="text" class="form-control w-full py-2.5" maxlength="5">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-8 p-2">
            <label for="address_neighborhood" class="form-label">Bairro <span class="text-red-500">*</span></label>
            <input id="address_neighborhood" name="address_neighborhood" type="text" class="form-control w-full py-2.5" maxlength="100">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="address_complement" class="form-label">Complemento </label>
            <input id="address_complement" name="address_complement" type="text" class="form-control w-full py-2.5" maxlength="50">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-6 p-2 form-group">
            <label for="address_county" class="form-label">Município <span class="text-red-500">*</span></label>
            <select class="select-2-county form-control" id="address_county" name="address_county">
            </select>
          </div>

          <div class="col-span-12 md:col-span-6 p-2 md:mt-8">
            <a name="btnAddAddress" class="btn btn-primary w-32 mr-2 mb-2">Adicionar</a>
            <a name="btnSaveEditAddress" class="btn btn-primary w-32 mr-2 mb-2 hidden">Salvar</a>
            <a name="btnCancelEditAddress" class="btn btn-secundary w-32 mr-2 mb-2 hidden">Cancelar</a>
          </div>
        </div>

        <div class="grid grid-cols-12">
          <table class="table col-span-12" id="tableAddress">
            <thead>
              <tr>
                <th class="whitespace-nowrap">Principal</th>
                <th class="whitespace-nowrap">Endereço</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
              @php
                $addressesJson = old('arrAddress', $companyAddresses ?? "[]");
                $addresses = json_decode($addressesJson);
              @endphp
              @foreach($addresses as $k => $address)
                <tr data-id="{{$k}}">
                  <td>
                    <div class="form-check mt-2">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="isMainAddress"
                        value="{{$k}}"
                        data-id="{{$k}}"
                        {{$address->main ? 'checked' : ''}}
                      >
                      <label class="form-check-label">{!! $address->main ? 'Principal' : '&nbsp;'!!}</label>
                    </div>
                  </td>
                  <td>
                    {{$address->zipCode}} - {{$address->address}}, nº {{$address->number}} <br>
                    {{$address->neighborhood}}, {{$address->county}}
                    {!!$address->complement ? '<br>Complemento: '.$address->complement : ''!!}
                  </td>
                  <td data-title="Status">
                    {!!
                      $address->active ?
                      '<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>'
                      :
                      '<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>'
                    !!}
                   </td>
                  <td class="space-x-4">
                    <div class="flex gap-4 justify-center">
                      <a href="#" name="btnDeleteAddress" data-id="{{$k}}" title="Excluir o endereço">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <g color="#b91c1c">
                            <path d="M3 6h18"></path>
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                          </g>
                        </svg>
                      </a>

                      <a href="#" name="btnEditAddress" data-id="{{$k}}" title="Editar o endereço">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <g color="#4338ca">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                          </g>
                        </svg>
                      </a>

                      <a href="#" name="btnToggleActiveAddress" data-id="{{$k}}" title="{{$address->active ? 'Desativar endereço': 'Ativar endereço'}}">
                        {!!
                          $address->active ?
                          '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <g color="#b91c1c">
                              <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                              <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                              <path d="M12 2v4"></path>
                              <path d="m2 2 20 20"></path>
                            </g>
                          </svg>'
                          :
                          '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <g color="#15803d">
                              <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                              <line x1="12" y1="2" x2="12" y2="12"></line>
                            </g>
                          </svg>'
                        !!}
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @if(!isset($company->id))
        <div id="tab-user" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="user">
          <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-4 p-2">
              <label for="user_name" class="form-label">Nome <span class="text-red-500">*</span></label>
              <input id="user_name" name="user_name" type="text" class="form-control w-full py-2.5" value="{{ old('user_name') }}">
            </div>

            <div class="col-span-12 md:col-span-4 p-2">
              <label for="user_email" class="form-label">E-mail <span class="text-red-500">*</span></label>
              <input id="user_email" name="user_email" type="email" class="form-control w-full py-2.5" value="{{ old('user_email') }}">
            </div>

            <div class="col-span-12 md:col-span-4 p-2">
              <label for="user_cpf" class="form-label">CPF <span class="text-red-500">*</span></label>
              <input id="user_cpf" name="user_cpf" type="text" class="form-control w-full py-2.5 cpf" value="{{ old('user_cpf') }}">
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>


<!-- Modals -->
<div id="modalDelete" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="p-5 text-center">
          <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
          <div class="text-3xl mt-5">
            Tem certeza ?
          </div>
          <div class="text-slate-500 mt-2">
            Você realmente deseja excluir esse registro? <br>
            Este processo não pode ser desfeito.</div>
          </div>
        <div class="px-5 pb-8 text-center">
          <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
          <button name="confirmDelete" type="button" class="btn btn-danger w-24">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
