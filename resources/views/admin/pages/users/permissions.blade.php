@extends('admin.layout')

@section('content')
    @include('admin.pages.users.header')

    <!--begin::Notifications-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Permissões</h3>
            </div>
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_notifications" class="collapse show">
            @if(Auth::user()->can('Usuários'))
                <!--begin::Form-->
                <form class="form savePermissions">
                    <!--begin::Card body-->
                    <div class="card-body border-top px-9 pt-3 pb-4">
                        <!--begin::Table-->
                        <table class="table table-row-dashed border-gray-300 align-middle gy-6">
                            <tbody class="fs-6 fw-semibold">
                            @foreach($roles as $role)
                                @if($role->name == 'Super-Admin' && Auth::user()->hasRole('Super-Admin'))
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="min-w-150px">Super Admin:</td>
                                        <td>
                                            <div class="row">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" name="super_admin" type="checkbox" value="{{ $role->id }}" id="role-{{ $role->id }}" style="cursor: pointer; margin-left: 12px" {!! $user->hasRole('Super-Admin') ? 'checked="checked"':'' !!}/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                @else
                                    @if($role->name == 'Super-Admin')
                                        @continue
                                    @endif
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="min-w-150px">{{ $role->name }}:</td>
                                        <td>
                                            <div class="row">
                                                @foreach($role->permissions->sortBy('name') as $permission)
                                                    <div class="col-3 mb-2 mt-2">
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <input class="form-check-input" name="permissions_id[]" type="checkbox" value="{{ $permission->id }}" id="{{ $permission->id }}" style="cursor: pointer" {!! $user->permissions->pluck('id')->contains($permission->id) ? 'checked="checked"':'' !!}/>
                                                            <label class="form-check-label ps-2" for="{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" id="btnSubmit" class="btn btn-primary">
                            <span class="indicator-label">Salvar</span>
                            <span class="indicator-progress">Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Card footer-->
                </form>
                <!--end::Form-->
            @else
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    @if(Auth::user()->hasRole('Super-Admin'))
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Super Admin</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Row-->
                    @endif
                    @foreach($roles as $role)
                        @if($role->name == 'Super-Admin')
                            @continue
                        @endif
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">{{ $role->name }}:</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">
                                    @php $permissionsName = []; @endphp
                                    @foreach($role->permissions as $permission)
                                        @if(Auth::user()->permissions->pluck('id')->contains($permission->id))
                                            @php $permissionsName[] = $permission->name; @endphp
                                        @endif
                                    @endforeach
                                    @if(count($permissionsName) == 0)
                                        Nenhuma
                                    @else
                                        {{ implode(', ', $permissionsName) }}
                                    @endif
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    @endforeach
                </div>
                <!--end::Card body-->
            @endif
        </div>
        <!--end::Content-->
    </div>
    <!--end::Notifications-->
@endsection

@push('scripts')
    <script>
        var submitButton = document.getElementById('btnSubmit');
        $('.savePermissions').on("submit", function(e){
            e.preventDefault();
            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;
            var form = new FormData(this);
            $.ajax({
                url: '{{ route('admin.users.permissions.save', $user->hash_id) }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    if(data.success === true){
                        Swal.fire('Sucesso!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    Swal.fire('Falha!', data.message, 'error');
                }
            });
        });
    </script>
@endpush
