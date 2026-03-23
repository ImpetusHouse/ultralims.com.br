<style>
    .breadcrumb{
        color: {{ env('BREADCRUMB') }};
    }
    .breadcrumb-active{
        color: {{ env('BREADCRUMB_ACTIVE') }};
    }
</style>
<section>
    <div class="bg-white shadow-lg">
        <div class="container px-4 mx-auto">
            <div class="flex flex-wrap h-16 py-4 items-center">
                <a class="inline-block text-sm font-bold breadcrumb" href="/">Home</a>
                <span class="mx-2">
                    <svg width="6" height="11" viewbox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.694 11L5.698 0.78H3.99L0 11H1.694Z" fill="black"></path>
                    </svg>
                </span>
                @foreach($breadcrumbs as $breadcrumb)
                    @php
                        // Define o nome a ser exibido: se for "Extensoes lims", muda para "Plugins Ultra LIMS"
                        $displayName = (trim($breadcrumb['name']) === 'Extensoes lims') 
                            ? 'Plugins Ultra LIMS' 
                            : $breadcrumb['name'];
                    @endphp
                    @if(!$loop->first)
                        <span class="mx-2">
                            <svg width="6" height="11" viewbox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.694 11L5.698 0.78H3.99L0 11H1.694Z" fill="black"></path>
                            </svg>
                        </span>
                    @endif
                    @if(!$loop->last)
                        <a class="inline-block text-sm font-bold breadcrumb" href="{{ $breadcrumb['url'] }}">{{ Str::limit($displayName, 47, '...') }}</a>
                    @else
                        <a class="inline-block text-sm font-bold breadcrumb-active" href="{{ $breadcrumb['url'] }}">{{ Str::limit($displayName, 47, '...') }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
