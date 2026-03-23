@extends('admin.layout')
@section('content')
    <div class="card mb-10">
        <div class="card-header card-header-stretch border-0">
            <h3 class="card-title">Configurações</h3>
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0" id="myTab">
                    @if(false)
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#reasonsRefusal">Motivos de recusa</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#preAwnser">Respostas pré definidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#autoMessage">Mensagens automáticas</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <div class="tab-content" id="myTabContent">
        @if(false)
            <div class="tab-pane fade show active" id="reasonsRefusal" role="tabpanel">
                @include('admin.pages.quickActions.tickets.configuration.reasonsRefusals.index')
            </div>
        @endif
        <div class="tab-pane fade show active" id="preAwnser" role="tabpanel">
            @include('admin.pages.quickActions.tickets.configuration.preAwnser.index')
        </div>
        <div class="tab-pane fade" id="autoMessage" role="tabpanel">
            @include('admin.pages.quickActions.tickets.configuration.autoMessage.index')
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
            $(window).scrollTop(0);
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#myTab a[href="' + hash + '"]').tab('show');
    </script>
@endpush
