@foreach($analysisGroups as $analysisGroup)
    <div class="py-6 border-t-2 border-gray-100 group">
        <div class="flex flex-wrap lg:flex-nowrap items-center">
            <div class="w-full lg:w-9/12 px-4 mb-10 lg:mb-0">
                <div class="max-w-2xl">
                    <p class="text-lg font-semibold text-gray-900 mb-1">{{ $analysisGroup->name }}</p>
                    <span class="block text-gray-400">{{ $analysisGroup->description }}</span>
                </div>
            </div>
            <div class="w-full lg:w-auto px-4 ml-auto text-right">
                <a href="{{ route('prolab.analysisgroups.show', $analysisGroup->slug) }}?fonte={{ $page->slug }}" class="hidden group-hover:inline-block w-full lg:w-auto transition duration-300 ease-in-out py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center text-[#FFFFFF] bg-[#E69E2E] hover:bg-[#734F17] font-semibold leading-none hover:opacity-70 rounded">
                    Mais informações
                </a>
            </div>
        </div>
    </div>
@endforeach
