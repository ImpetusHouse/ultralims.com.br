@foreach($products as $product)
    <div class="w-full lg:w-1/4 px-4 mb-10 product">
        <a class="block group mx-auto" href="{{ route('ultralims.produtos.show', $product->slug) }}">
            <div class="flex items-end justify-end square mb-4 bg-coolGray-100 rounded-xl border-2 border-transparent group-hover:border-[#01aef0] transition duration-150 overflow-hidden">
                <img class="block object-cover w-full h-full" src="{{ asset(str_replace('public/', 'storage/', $product->photo)) }}" alt="{{ $product->title }}">
            </div>
            <div class="text-center">
                <span class="block text-base text-[#0E1326]] mb-1">{{ $product->title }}</span>
                <span class="block text-base text-[#9FADC2] w-full two-line-text">{{ strip_tags(html_entity_decode($product->description)) }}</span>
            </div>
        </a>
    </div>
@endforeach
