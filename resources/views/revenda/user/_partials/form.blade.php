@csrf

<div class="p-2 col-span-12">
  <div class="preview">
    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap" role="tablist">
      <li id="user" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2 active"
          data-tw-toggle="pill"
          data-tw-target="#tab-user"
          type="button"
          role="tab"
          aria-controls="tab-user"
          aria-selected="true"
        >
          Usuário
        </button>
      </li>
      <li id="accessCompanies" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2"
          data-tw-toggle="pill"
          data-tw-target="#tab-accessCompanies"
          type="button" role="tab"
          aria-controls="tab-accessCompanies"
          aria-selected="false"
        >
          Acesso a empresa
        </button>
      </li>
    </ul>

    <div class="tab-content border-l border-r border-b">
      <div id="tab-user" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="user">

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="name" class="form-label">Nome <span class="text-red-500">*</span></label>
            <input id="name" name="name" type="text" class="form-control w-full py-2.5" value="{{ old('name', $user->name ?? '') }}">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="email" class="form-label">E-mail <span class="text-red-500">*</span></label>
            <input id="email" name="email" type="email" class="form-control w-full py-2.5" value="{{ old('email', $user->email ?? '') }}">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="cpf" class="form-label">CPF <span class="text-red-500">*</span></label>
            <input id="cpf" name="cpf" type="text" class="form-control w-full py-2.5 cpf" value="{{ old('cpf', $user->cpf ?? '') }}">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="role_id" class="form-label">Regra <span class="text-red-500">*</span></label>
            <select class="form-select py-2.5" id="role_id" name="role_id">
              @foreach($roles as $role)
              @if(!!old())
                @if(old('role_id') == $role->id)
                  <option value="{{ $role->id }}" selected>{{ $role->description }}</option>
                @else
                  <option value="{{ $role->id }}">{{ $role->description }}</option>
                @endif
              @elseif(isset($user) && $user->role_id == $role->id)
                  <option value="{{ $role->id }}" selected>{{ $role->description }}</option>
                @else
                  <option value="{{ $role->id }}" >{{ $role->description }}</option>
                @endif
              @endforeach
            </select>
          </div>

          @if(isset($user->id))
            <div class="col-span-4 p-2 md:mt-11">
              <div class="form-check mt-2">
                <input id="active" name="active" class="form-check-input" type="checkbox"
                  @if(!!old())
                    @if(old('active') == 'on') checked @endif
                  @elseif($user->active)
                    checked
                  @endif
                >
                <label class="form-check-label" for="active">Ativo</label>
              </div>
            </div>
          @endif
        </div>
      </div>
      <div id="tab-accessCompanies" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="accessCompanies">
        <input type="hidden" name="arrUserAccessCompany" value="{{ old('arrUserAccessCompany', $userAccessCompany ?? "[]") }}">

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-6 p-2">
            <label for="company_id" class="form-label">Empresa</label>
            <select class="select-2 w-full" id="company_id" name="company_id">
              <option value="">Selecione a empresa</option>
              @foreach($companies as $company)
              @if(!!old())
                @if(old('id') == $company->id)
                  <option value="{{ $company->id }}" selected>{{ $company->trade_name }}</option>
                @else
                  <option value="{{ $company->id }}">{{ $company->trade_name }}</option>
                @endif
              @else
                <option value="{{ $company->id }}" >{{ $company->trade_name }}</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="col-span-12 md:col-span-6 p-2 md:mt-8">
            <a name="btnAddCompanyAccess" class="btn btn-primary w-32 mr-2 mb-2">Adicionar</a>
          </div>
        </div>

        <div class="grid grid-cols-12">
          <table class="table col-span-12" id="tableUserAccessCompanies">
            <thead>
              <tr>
                <th class="whitespace-nowrap">Empresa</th>
                <th class="whitespace-nowrap text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
              @php
                $userAccessCompanyJson = old('arrContact', $userAccessCompany ?? "[]");
                $UserAccessCompanies = json_decode($userAccessCompanyJson);
              @endphp
              @foreach($UserAccessCompanies as $k => $accessCompany)
                <tr data-id="{{$k}}" style="background-color:{{ $accessCompany->allowDeletion == 'S' ? '' : '#f1f5f9' }}">
                  <td data-title="Empresa">{{$accessCompany->companyDescription}}</td>
                  <td class="space-x-4">

                    <div class="flex gap-4 justify-center">
                      {!!
                        $accessCompany->allowDeletion == 'S' ?
                        '<a href="#" name="btnDeleteCompanyAccess" data-id="'.$k.'" title="Excluir o acesso a empresa">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <g color="#b91c1c">
                              <path d="M3 6h18"></path>
                              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                            </g>
                          </svg>
                        </a>'
                        : ''
                      !!}
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
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

