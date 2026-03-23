@extends('admin.layout')

@section('content')
    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header pt-8">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input id="searchInput" type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Procurar arquivos e pastas" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                    @if(!isset($folderOpen))
                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">
                            <!--begin::Svg Icon | path: icons/duotune/files/fil013.svg-->
                            <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor" />
                                <path opacity="0.3" d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor" />
                            </svg>
                        </span>
                            <!--end::Svg Icon-->
                            Nova pasta
                        </button>
                        <!--end::Export-->
                    @endif
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_upload">
                        <!--begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="currentColor" />
                                <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Enviar arquivos
                    </button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-filemanager-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-filemanager-table-select="selected_count"></span>selecionado(s)</div>
                    <button type="button" class="btn btn-danger" data-kt-filemanager-table-select="delete_selected">Excluir selecionado(s)</button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Table header-->
            <div class="d-flex justify-content-end">
                <!--begin::Folder Stats-->
                <div class="badge badge-lg badge-primary">
                    <span id="kt_file_manager_items_counter">{{ $folders->count() + $items->count() }} items</span>
                </div>
                <!--end::Folder Stats-->
            </div>
            <!--end::Table header-->
            <table id="kt_file_manager_list" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    {{--<th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_file_manager_list .form-check-input" value="1" />
                        </div>
                    </th>--}}
                    <th class="min-w-250px">Nome</th>
                    <th class="min-w-10px text-center">Extensão</th>
                    <th class="min-w-10px text-center">Tamanho</th>
                    <th class="min-w-125px text-center">Última modificação</th>
                    <th class="w-125px"></th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                @foreach($folders as $folder)
                    <tr data-id="{{ $folder->id }}" data-type="folder">
                        {{--<!--begin::Checkbox-->
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <!--end::Checkbox-->--}}
                        <!--begin::Name-->
                        <td data-order="{{ $folder->title }}">
                            <div class="d-flex align-items-center">
                                <!--begin::Svg Icon | path: icons/duotune/files/fil012.svg-->
                                <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                        <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <a href="{{ route('admin.folders.show', $folder->id) }}" class="text-gray-800 text-hover-primary">{{ $folder->title }}</a>
                            </div>
                        </td>
                        <!--end::Name-->
                        <!--begin::Extension-->
                        <td class="text-center">-</td>
                        <!--end::Extension-->
                        <!--begin::Size-->
                        <td class="text-center">-</td>
                        <!--end::Size-->
                        <!--begin::Last modified-->
                        <td class="text-center">{{ $folder->updated_at->format('d M Y, h:i a') }}</td>
                        <!--end::Last modified-->
                        <!--begin::Actions-->
                        <td class="text-end" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <!--begin::More-->
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-filemanager-table="rename" data-id="{{ $folder->id }}" data-type="folder">Renomear</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-filemanager-table="delete" data-id="{{ $folder->id }}" data-type="folder">Excluir</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                    <!--end::More-->
                                </div>
                            </div>
                        </td>
                        <!--end::Actions-->
                    </tr>
                @endforeach

                @foreach($items as $item)
                    <tr data-id="{{ $item->id }}" data-path="{{ asset('storage/' . $item->path) }}" data-type="item">
                        {{--<!--begin::Checkbox-->
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <!--end::Checkbox-->--}}
                        <!--begin::Name-->
                        <td data-order="{{ $item->title }}">
                            <div class="d-flex align-items-center">
                                <!--begin::Svg Icon | path: icons/duotune/files/fil003.svg-->
                                <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor" />
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <a href="{{ asset('storage/' . $item->path) }}" class="text-gray-800 text-hover-primary" download>{{ $item->title }}</a>
                            </div>
                        </td>
                        <!--end::Name-->
                        <!--begin::Extension-->
                        <td class="text-center">{{ $item->extension }}</td>
                        <!--end::Extension-->
                        <!--begin::Size-->
                        <td class="text-center">{{ number_format($item->size / 1024, 2) }} KB</td>
                        <!--end::Size-->
                        <!--begin::Last modified-->
                        <td class="text-center">{{ $item->updated_at->format('d M Y, h:i a') }}</td>
                        <!--end::Last modified-->
                        <!--begin::Actions-->
                        <td class="text-end" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <!--begin::Share link-->
                                <div class="ms-2" data-kt-filemanger-table="copy_link">
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M18.4 5.59998C18.7766 5.9772 18.9881 6.48846 18.9881 7.02148C18.9881 7.55451 18.7766 8.06577 18.4 8.44299L14.843 12C14.466 12.377 13.9547 12.5887 13.4215 12.5887C12.8883 12.5887 12.377 12.377 12 12C11.623 11.623 11.4112 11.1117 11.4112 10.5785C11.4112 10.0453 11.623 9.53399 12 9.15698L15.553 5.604C15.9302 5.22741 16.4415 5.01587 16.9745 5.01587C17.5075 5.01587 18.0188 5.22741 18.396 5.604L18.4 5.59998ZM20.528 3.47205C20.0614 3.00535 19.5074 2.63503 18.8977 2.38245C18.288 2.12987 17.6344 1.99988 16.9745 1.99988C16.3145 1.99988 15.661 2.12987 15.0513 2.38245C14.4416 2.63503 13.8876 3.00535 13.421 3.47205L9.86801 7.02502C9.40136 7.49168 9.03118 8.04568 8.77863 8.6554C8.52608 9.26511 8.39609 9.91855 8.39609 10.5785C8.39609 11.2384 8.52608 11.8919 8.77863 12.5016C9.03118 13.1113 9.40136 13.6653 9.86801 14.132C10.3347 14.5986 10.8886 14.9688 11.4984 15.2213C12.1081 15.4739 12.7616 15.6039 13.4215 15.6039C14.0815 15.6039 14.7349 15.4739 15.3446 15.2213C15.9543 14.9688 16.5084 14.5986 16.975 14.132L20.528 10.579C20.9947 10.1124 21.3649 9.55844 21.6175 8.94873C21.8701 8.33902 22.0001 7.68547 22.0001 7.02551C22.0001 6.36555 21.8701 5.71201 21.6175 5.10229C21.3649 4.49258 20.9947 3.93867 20.528 3.47205Z" fill="currentColor" />
                                                <path d="M14.132 9.86804C13.6421 9.37931 13.0561 8.99749 12.411 8.74695L12 9.15698C11.6234 9.53421 11.4119 10.0455 11.4119 10.5785C11.4119 11.1115 11.6234 11.6228 12 12C12.3766 12.3772 12.5881 12.8885 12.5881 13.4215C12.5881 13.9545 12.3766 14.4658 12 14.843L8.44699 18.396C8.06999 18.773 7.55868 18.9849 7.02551 18.9849C6.49235 18.9849 5.98101 18.773 5.604 18.396C5.227 18.019 5.0152 17.5077 5.0152 16.9745C5.0152 16.4413 5.227 15.93 5.604 15.553L8.74701 12.411C8.28705 11.233 8.28705 9.92498 8.74701 8.74695C8.10159 8.99737 7.5152 9.37919 7.02499 9.86804L3.47198 13.421C2.52954 14.3635 2.00009 15.6417 2.00009 16.9745C2.00009 18.3073 2.52957 19.5855 3.47202 20.528C4.41446 21.4704 5.69269 21.9999 7.02551 21.9999C8.35833 21.9999 9.63656 21.4704 10.579 20.528L14.132 16.975C14.5987 16.5084 14.9689 15.9544 15.2215 15.3447C15.4741 14.735 15.6041 14.0815 15.6041 13.4215C15.6041 12.7615 15.4741 12.108 15.2215 11.4983C14.9689 10.8886 14.5987 10.3347 14.132 9.86804Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px" data-kt-menu="true">
                                        <!--begin::Card-->
                                        <div class="card card-flush">
                                            <div class="card-body p-5">
                                                <!--begin::Loader-->
                                                <div class="d-flex d-none" data-kt-filemanger-table="copy_link_generator">
                                                    <!--begin::Spinner-->
                                                    <div class="me-5">
                                                        <span class="indicator-progress">
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </div>
                                                    <!--end::Spinner-->
                                                    <!--begin::Label-->
                                                    <div class="fs-6 text-dark">Gerando link de compartilhamento...</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Loader-->
                                                <!--begin::Link-->
                                                <div class="d-flex flex-column text-start" data-kt-filemanger-table="copy_link_result">
                                                    <div class="d-flex mb-3 d-none">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr085.svg-->
                                                        <span class="svg-icon svg-icon-2 svg-icon-success me-3">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <div class="fs-6 text-dark">Link de compartilhamento gerado</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" value="https://path/to/file/or/folder/" />
                                                </div>
                                                <!--end::Link-->
                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Menu-->
                                    <!--end::Share link-->
                                </div>
                                <!--begin::More-->
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-filemanager-table="rename" data-id="{{ $item->id }}" data-type="item">Renomear</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-filemanager-table="delete" data-id="{{ $item->id }}" data-type="item">Excluir</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                    <!--end::More-->
                                </div>
                            </div>
                        </td>
                        <!--end::Actions-->
                    </tr>
                @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    <!--begin::Upload template-->
    <table class="d-none">
        <tr id="kt_file_manager_new_folder_row" data-kt-filemanager-template="upload">
            <td id="kt_file_manager_add_folder_form" class="fv-row">
                <div class="d-flex align-items-center">
                    <!--begin::Folder icon-->
                    <!--begin::Svg Icon | path: icons/duotune/files/fil012.svg-->
                    <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                            <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <!--end::Folder icon-->
                    <!--begin:Input-->
                    <input type="text" name="new_folder_name" placeholder="Digite o nome da pasta" class="form-control mw-250px me-3" />
                    <!--end:Input-->
                    <!--begin:Submit button-->
                    <button class="btn btn-icon btn-light-primary me-3" id="kt_file_manager_add_folder">
                        <span class="indicator-label">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr085.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                        </span>
                    </button>
                    <!--end:Submit button-->
                    <!--begin:Cancel button-->
                    <button class="btn btn-icon btn-light-danger" id="kt_file_manager_cancel_folder">
                        <span class="indicator-label">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                        </span>
                    </button>
                    <!--end:Cancel button-->
                </div>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <!--end::Upload template-->
    <!--begin::Rename template-->
    <div class="d-none" data-kt-filemanager-template="rename">
        <div class="fv-row">
            <div class="d-flex align-items-center">
                <span id="kt_file_manager_rename_folder_icon"></span>
                <input type="text" id="kt_file_manager_rename_input" name="rename_folder_name" placeholder="Digite o novo nome da pasta" class="form-control mw-250px me-3" value="" />
                <button class="btn btn-icon btn-light-primary me-3" id="kt_file_manager_rename_folder">
                    <span class="indicator-label">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr085.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="indicator-progress">
                        <span class="spinner-border spinner-border-sm align-middle"></span>
                    </span>
                </button>
                <button class="btn btn-icon btn-light-danger" id="kt_file_manager_rename_folder_cancel">
                    <span class="indicator-label">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="indicator-progress">
                        <span class="spinner-border spinner-border-sm align-middle"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <!--end::Rename template-->
    <!--begin::Action template-->
    <div class="d-none" data-kt-filemanager-template="action">
        <div class="d-flex justify-content-end">
            <!--begin::Share link-->
            <div class="ms-2" data-kt-filemanger-table="copy_link">
                <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 0" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M18.4 5.59998C18.7766 5.9772 18.9881 6.48846 18.9881 7.02148C18.9881 7.55451 18.7766 8.06577 18.4 8.44299L14.843 12C14.466 12.377 13.9547 12.5887 13.4215 12.5887C12.8883 12.5887 12.377 12.377 12 12C11.623 11.623 11.4112 11.1117 11.4112 10.5785C11.4112 10.0453 11.623 9.53399 12 9.15698L15.553 5.604C15.9302 5.22741 16.4415 5.01587 16.9745 5.01587C17.5075 5.01587 18.0188 5.22741 18.396 5.604L18.4 5.59998ZM20.528 3.47205C20.0614 3.00535 19.5074 2.63503 18.8977 2.38245C18.288 2.12987 17.6344 1.99988 16.9745 1.99988C16.3145 1.99988 15.661 2.12987 15.0513 2.38245C14.4416 2.63503 13.8876 3.00535 13.421 3.47205L9.86801 7.02502C9.40136 7.49168 9.03118 8.04568 8.77863 8.6554C8.52608 9.26511 8.39609 9.91855 8.39609 10.5785C8.39609 11.2384 8.52608 11.8919 8.77863 12.5016C9.03118 13.1113 9.40136 13.6653 9.86801 14.132C10.3347 14.5986 10.8886 14.9688 11.4984 15.2213C12.1081 15.4739 12.7616 15.6039 13.4215 15.6039C14.0815 15.6039 14.7349 15.4739 15.3446 15.2213C15.9543 14.9688 16.5084 14.5986 16.975 14.132L20.528 10.579C20.9947 10.1124 21.3649 9.55844 21.6175 8.94873C21.8701 8.33902 22.0001 7.68547 22.0001 7.02551C22.0001 6.36555 21.8701 5.71201 21.6175 5.10229C21.3649 4.49258 20.9947 3.93867 20.528 3.47205Z" fill="currentColor" />
                            <path d="M14.132 9.86804C13.6421 9.37931 13.0561 8.99749 12.411 8.74695L12 9.15698C11.6234 9.53421 11.4119 10.0455 11.4119 10.5785C11.4119 11.1115 11.6234 11.6228 12 12C12.3766 12.3772 12.5881 12.8885 12.5881 13.4215C12.5881 13.9545 12.3766 14.4658 12 14.843L8.44699 18.396C8.06999 18.773 7.55868 18.9849 7.02551 18.9849C6.49235 18.9849 5.98101 18.773 5.604 18.396C5.227 18.019 5.0152 17.5077 5.0152 16.9745C5.0152 16.4413 5.227 15.93 5.604 15.553L8.74701 12.411C8.28705 11.233 8.28705 9.92498 8.74701 8.74695C8.10159 8.99737 7.5152 9.37919 7.02499 9.86804L3.47198 13.421C2.52954 14.3635 2.00009 15.6417 2.00009 16.9745C2.00009 18.3073 2.52957 19.5855 3.47202 20.528C4.41446 21.4704 5.69269 21.9999 7.02551 21.9999C8.35833 21.9999 9.63656 21.4704 10.579 20.528L14.132 16.975C14.5987 16.5084 14.9689 15.9544 15.2215 15.3447C15.4741 14.735 15.6041 14.0815 15.6041 13.4215C15.6041 12.7615 15.4741 12.108 15.2215 11.4983C14.9689 10.8886 14.5987 10.3347 14.132 9.86804Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px" data-kt-menu="true">
                    <!--begin::Card-->
                    <div class="card card-flush">
                        <div class="card-body p-5">
                            <!--begin::Loader-->
                            <div class="d-flex" data-kt-filemanger-table="copy_link_generator">
                                <!--begin::Spinner-->
                                <div class="me-5" data-kt-indicator="on">
                                    <span class="indicator-progress">
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </div>
                                <!--end::Spinner-->
                                <!--begin::Label-->
                                <div class="fs-6 text-dark">Gerando link de compartilhamento...</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Loader-->
                            <!--begin::Link-->
                            <div class="d-flex flex-column text-start d-none" data-kt-filemanger-table="copy_link_result">
                                <div class="d-flex mb-3">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr085.svg-->
                                    <span class="svg-icon svg-icon-2 svg-icon-success me-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <div class="fs-6 text-dark">Link de compartilhamento gerado</div>
                                </div>
                                <input type="text" class="form-control form-control-sm" value="https://path/to/file/or/folder/" />
                            </div>
                            <!--end::Link-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Menu-->
                <!--end::Share link-->
            </div>
            <!--begin::More-->
            <div class="ms-2">
                <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
                            <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
                            <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-filemanager-table="rename">Renomear</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-filemanager-table="delete">Excluir</a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
                <!--end::More-->
            </div>
        </div>
    </div>
    <!--end::Action template-->
    <!--begin::Modals-->
    <div class="modal fade" id="kt_modal_upload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Enviar arquivos</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <div class="modal-body">
                    <form id="kt_modal_upload_form" class="form" action="{{ route('admin.folders.items.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">
                                <span class="required">Selecionar arquivos</span>
                            </label>
                            @if(isset($folderOpen))
                                <input type="hidden" name="folder_id" value="{{ $folderOpen->id }}" />
                            @endif
                            <input type="file" name="files[]" multiple class="form-control" />
                        </div>
                        <div class="text-center">
                            <button id="submitButton" type="submit" class="btn btn-primary">
                                <span class="indicator-label">Enviar</span>
                                <span class="indicator-progress">Aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modals-->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileManagerTable = document.getElementById('kt_file_manager_list');

            const addFolderButton = document.getElementById('kt_file_manager_new_folder');
            const addFolderFormTemplate = document.getElementById('kt_file_manager_new_folder_row');
            const tableBody = fileManagerTable.querySelector('tbody');

            // Initialize DataTable
            const dataTable = $(fileManagerTable).DataTable({
                info: false,
                order: [],
                scrollY: "700px",
                scrollCollapse: true,
                paging: false,
                ordering: false,
                columns: [
                    {{--{ data: "checkbox" },--}}
                    { data: "name" },
                    { data: "extension" },
                    { data: "size" },
                    { data: "date" },
                    { data: "action" }
                ],
                conditionalPaging: true,
                language: {
                    emptyTable: `
                    <div class="d-flex flex-column flex-center">
                        <img src="{{ asset('assets/media/illustrations/sketchy-1/5.png') }}" class="mw-400px" />
                        <div class="fs-1 fw-bolder text-dark">Nenhum item encontrado.</div>
                        <div class="fs-6">Comece a criar novas pastas ou enviar um novo arquivo!</div>
                    </div>`
                }
            });

            // Apply search filter
            document.getElementById('searchInput').addEventListener('keyup', function() {
                dataTable.search(this.value).draw();
            });

            // Update Items Counter
            const updateItemsCounter = () => {
                const counter = document.getElementById("kt_file_manager_items_counter");
                counter.innerText = dataTable.rows().count() + " itens";
                KTMenu.createInstances();
            };

            updateItemsCounter();

            @if(!isset($folderOpen))
                // Add Folder
                addFolderButton.addEventListener('click', function() {
                    const clone = addFolderFormTemplate.cloneNode(true);
                    clone.id = '';
                    clone.classList.remove('d-none');
                    tableBody.prepend(clone);

                    const input = clone.querySelector('input[name="new_folder_name"]');
                    const addButton = clone.querySelector('#kt_file_manager_add_folder');
                    const cancelButton = clone.querySelector('#kt_file_manager_cancel_folder');

                    addButton.addEventListener('click', function() {
                        addButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
                        addButton.disabled = true;
                        cancelButton.disabled = true;

                        const folderName = input.value;
                        if (folderName) {
                            axios.post('{{ route('admin.folders.store') }}', { title: folderName })
                                .then(function(response) {
                                    const folder = response.data.folder;
                                    const newRow = `
                                    <tr data-id="${folder.id}" data-type="folder">
                                        {{--<td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                            </div>
                                        </td>--}}
                                        <td data-order="${folder.title}">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                                        <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <a href="`+('{{ route('admin.folders.show', '_ID_') }}').replace('_ID_', folder.id)+`" class="text-gray-800 text-hover-primary">${folder.title}</a>
                                            </div>
                                        </td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">${new Date(folder.updated_at).toLocaleDateString('pt-BR', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end">
                                                <div class="ms-2">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                                <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                                <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-filemanager-table="rename" data-id="${folder.id}" data-type="folder">Renomear</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-filemanager-table="delete" data-id="${folder.id}" data-type="folder">Excluir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`;
                                    dataTable.row.add($(newRow)).draw();
                                    updateItemsCounter();
                                    clone.remove();
                                })
                                .catch(function(error) {
                                    addButton.removeAttribute('data-kt-indicator');
                                    addButton.disabled = false;
                                    cancelButton.disabled = false;
                                    console.error('Erro ao criar pasta:', error);
                                });
                        }
                    });

                    cancelButton.addEventListener('click', function() {
                        clone.remove();
                    });
                });
            @endif

            // Rename Folder or File
            fileManagerTable.addEventListener('click', function(event) {
                const renameButton = event.target.closest('[data-kt-filemanager-table="rename"]');
                if (renameButton) {
                    const id = renameButton.getAttribute('data-id');
                    const type = renameButton.getAttribute('data-type');
                    const row = renameButton.closest('tr');
                    const nameCell = row.querySelector('td[data-order]');
                    const oldName = nameCell.getAttribute('data-order');
                    const renameTemplate = document.querySelector('[data-kt-filemanager-template="rename"]').cloneNode(true);
                    renameTemplate.classList.remove('d-none');
                    renameTemplate.querySelector('input').value = oldName;
                    nameCell.innerHTML = '';
                    nameCell.appendChild(renameTemplate);

                    const saveButton = renameTemplate.querySelector('#kt_file_manager_rename_folder');
                    const cancelButton = renameTemplate.querySelector('#kt_file_manager_rename_folder_cancel');

                    saveButton.addEventListener('click', function() {
                        saveButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
                        saveButton.disabled = true;
                        cancelButton.disabled = true;

                        const newName = renameTemplate.querySelector('input').value;
                        if (newName) {
                            const url = type === 'folder' ? '{{ url('admin/folders') }}/' + id : '{{ url('admin/folders/items') }}/' + id;
                            axios.put(url, { title: newName })
                                .then(function(response) {
                                    nameCell.setAttribute('data-order', newName);
                                    nameCell.innerHTML = `
                                <div class="d-flex align-items-center">
                                `+(type === 'folder' ? `
                                    <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                            <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
                                        </svg>
                                    </span>`
                                    :
                                    `<span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor" />
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                        </svg>
                                    </span>`)+`
                                    <a href="`+(type === 'folder' ? '{{ route('admin.folders.show', '_ID_') }}' : '{{ asset('storage/' . '_ID_') }}').replace('_ID_', type === 'folder' ? id : response.data.item.path)+`" class="text-gray-800 text-hover-primary" `+(type !== 'folder' ? 'download':'')+`>${newName}</a>
                                </div>`;
                                    updateItemsCounter();
                                })
                                .catch(function(error) {
                                    saveButton.removeAttribute('data-kt-indicator');
                                    saveButton.disabled = false;
                                    cancelButton.disabled = false;
                                    console.error('Erro ao renomear:', error);
                                });
                        }
                    });

                    cancelButton.addEventListener('click', function() {
                        nameCell.innerHTML = `
                    <div class="d-flex align-items-center">
                        <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                            <svg width="24" height="24" viewBox="0 0 24 0" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
                            </svg>
                        </span>
                        <a href="`+(type === 'folder' ? '{{ route('admin.folders.show', '_ID_') }}' : '{{ route('admin.folders.items.show', '_ID_') }}').replace('_ID_', id)+`" class="text-gray-800 text-hover-primary">${oldName}</a>
                    </div>`;
                    });
                }
            });

            // Delete Folder or File
            fileManagerTable.addEventListener('click', function(event) {
                const deleteButton = event.target.closest('[data-kt-filemanager-table="delete"]');
                if (deleteButton) {
                    const id = deleteButton.getAttribute('data-id');
                    const type = deleteButton.getAttribute('data-type');
                    const row = deleteButton.closest('tr');
                    const url = type === 'folder' ? '{{ url('admin/folders') }}/' + id : '{{ url('admin/folders/items') }}/' + id;

                    // Confirmação antes de excluir
                    Swal.fire({
                        text: "Tem certeza que deseja excluir?",
                        icon: "question",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Sim, excluir!",
                        cancelButtonText: "Não, cancelar",
                        customClass: {
                            cancelButton: "btn fw-bold btn-primary",
                            confirmButton: "btn fw-bold btn-danger"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(url)
                                .then(function(response) {
                                    dataTable.row(row).remove().draw();
                                    updateItemsCounter();
                                    Swal.fire(
                                        'Excluído!',
                                        'O item foi excluído.',
                                        'success',
                                    );
                                })
                                .catch(function(error) {
                                    console.error('Erro ao excluir:', error);
                                    Swal.fire(
                                        'Erro!',
                                        'Houve um problema ao excluir o item.',
                                        'error'
                                    );
                                });
                        }
                    });
                }
            });

            // Upload Files
            $('#kt_modal_upload_form').on('submit', function(e){
                e.preventDefault();
                const formData = new FormData(this);
                const button = document.querySelector('#submitButton');
                button.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
                button.disabled = true;

                axios.post('{{ route('admin.folders.items.upload') }}', formData)
                    .then(function(response) {
                        location.reload(); // Reload the page to see the new files
                    })
                    .catch(function(error) {
                        button.removeAttribute('data-kt-indicator');
                        button.disabled = false;
                        console.error('Erro ao enviar arquivos:', error);
                    });
            });

            // Copy Link
            fileManagerTable.addEventListener('click', function(event) {
                const copyButton = event.target.closest('[data-kt-filemanger-table="copy_link"]');
                if (copyButton) {
                    const row = copyButton.closest('tr');
                    const path = row.getAttribute('data-path');

                    const generating = row.querySelector('[data-kt-filemanger-table="copy_link_generator"]');
                    const generate = row.querySelector('[data-kt-filemanger-table="copy_link_result"]');

                    // Mostrar estado de gerando link
                    generating.classList.remove('d-none');
                    generating.classList.add('d-flex');
                    generate.classList.add('d-none');
                    generate.classList.remove('d-flex');

                    // Simulação de tempo de geração de link
                    setTimeout(() => {
                        const linkInput = document.createElement('input');
                        document.body.appendChild(linkInput);
                        linkInput.value = path;
                        linkInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(linkInput);

                        const linkInputVisual = generate.querySelector('input');
                        linkInputVisual.value = path;

                        // Mostrar estado de link gerado
                        generating.classList.add('d-none');
                        generating.classList.remove('d-flex');
                        generate.classList.remove('d-none');
                        generate.classList.add('d-flex');
                    }, 2000); // Simula 2 segundos para geração de link
                }
            });

            // Seleciona todos os inputs dentro do menu de cópia de link
            const copyLinkInputs = document.querySelectorAll('[data-kt-filemanger-table="copy_link_result"] input');
            // Adiciona um listener de clique para cada input
            copyLinkInputs.forEach(function(input) {
                input.addEventListener('click', function(event) {
                    // Impede a propagação do evento de clique
                    event.stopPropagation();
                    input.select(); // Seleciona todo o texto ao clicar no input
                });
            });
        });
    </script>
@endpush
