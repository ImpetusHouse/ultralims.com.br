@extends('site.layout')
@section('content')
    <section class="relative bg-white overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="py-5">
                <div class="flex flex-wrap items-center gap-2">
                    <a class="text-rhino-500 text-sm hover:text-rhino-500 transition duration-200" href="#">Homepage</a>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none"><line x1="7.6279" y1="17.6356" x2="14.6356" y2="5.3721" stroke="#A0A5B8" stroke-width="2" stroke-linecap="round"></line></svg>
                    </div>
                    <a class="text-rhino-500 text-sm hover:text-rhino-500 transition duration-200" href="#">Catalogue</a>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none"><line x1="7.6279" y1="17.6356" x2="14.6356" y2="5.3721" stroke="#A0A5B8" stroke-width="2" stroke-linecap="round"></line></svg>
                    </div>
                    <a class="text-rhino-300 text-sm hover:text-rhino-500 transition duration-200" href="#">Product</a>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-12 bg-white">
        <div class="container px-4 mx-auto">
            <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-0 justify-between flex-wrap mb-6">
                <div>
                    <h1 class="font-heading text-rhino-700 text-2xl font-semibold">Found 420 results for</h1>
                    <p class="text-rhino-300">Summer sneakers</p>
                </div>
                <div class="flex gap-4 flex-wrap">
                    <select class="rounded-sm border border-coolGray-200 py-3 px-4 text-coolGray-400 text-sm outline-none">
                        <option value="">
                            <span>Sort by</span>
                            <span class="text-coolGray-800">Newest</span>
                        </option>
                        <option value="">
                            <span>Sort by</span>
                            <span class="text-coolGray-800">Limited</span>
                        </option>
                        <option value="">
                            <span>Sort by</span>
                            <span class="text-coolGray-800">Sale</span>
                        </option>
                    </select>
                    <div class="border border-gray-200 rounded-sm flex">
                        <a class="flex-1 py-1 px-4 flex items-center justify-center bg-coolGray-100 hover:bg-coolGray-200 transition duration-200" href="#">
                            <div class="text-coolGray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                    <path d="M12.6667 0.333252H0.666667C0.489856 0.333252 0.320286 0.40349 0.195262 0.528514C0.0702379 0.653538 0 0.823108 0 0.999919V12.9999C0 13.1767 0.0702379 13.3463 0.195262 13.4713C0.320286 13.5963 0.489856 13.6666 0.666667 13.6666H12.6667C12.8435 13.6666 13.013 13.5963 13.1381 13.4713C13.2631 13.3463 13.3333 13.1767 13.3333 12.9999V0.999919C13.3333 0.823108 13.2631 0.653538 13.1381 0.528514C13.013 0.40349 12.8435 0.333252 12.6667 0.333252ZM4 12.3333H1.33333V9.66659H4V12.3333ZM4 8.33325H1.33333V5.66659H4V8.33325ZM4 4.33325H1.33333V1.66659H4V4.33325ZM8 12.3333H5.33333V9.66659H8V12.3333ZM8 8.33325H5.33333V5.66659H8V8.33325ZM8 4.33325H5.33333V1.66659H8V4.33325ZM12 12.3333H9.33333V9.66659H12V12.3333ZM12 8.33325H9.33333V5.66659H12V8.33325ZM12 4.33325H9.33333V1.66659H12V4.33325Z" fill="currentColor"></path>
                                </svg>
                            </div>
                        </a>
                        <a class="flex-1 py-1 px-4 flex items-center justify-center group hover:bg-coolGray-100 transition duration-200" href="#">
                            <div class="text-coolGray-400 group-hover:text-coolGray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                    <path d="M12.6667 7.66659H1.00004C0.82323 7.66659 0.65366 7.73682 0.528636 7.86185C0.403612 7.98687 0.333374 8.15644 0.333374 8.33325V12.9999C0.333374 13.1767 0.403612 13.3463 0.528636 13.4713C0.65366 13.5963 0.82323 13.6666 1.00004 13.6666H12.6667C12.8435 13.6666 13.0131 13.5963 13.1381 13.4713C13.2631 13.3463 13.3334 13.1767 13.3334 12.9999V8.33325C13.3334 8.15644 13.2631 7.98687 13.1381 7.86185C13.0131 7.73682 12.8435 7.66659 12.6667 7.66659ZM12 12.3333H1.66671V8.99992H12V12.3333ZM12.6667 0.333252H1.00004C0.82323 0.333252 0.65366 0.40349 0.528636 0.528514C0.403612 0.653538 0.333374 0.823108 0.333374 0.999919V5.66659C0.333374 5.8434 0.403612 6.01297 0.528636 6.13799C0.65366 6.26301 0.82323 6.33325 1.00004 6.33325H12.6667C12.8435 6.33325 13.0131 6.26301 13.1381 6.13799C13.2631 6.01297 13.3334 5.8434 13.3334 5.66659V0.999919C13.3334 0.823108 13.2631 0.653538 13.1381 0.528514C13.0131 0.40349 12.8435 0.333252 12.6667 0.333252ZM12 4.99992H1.66671V1.66659H12V4.99992Z" fill="currentColor"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="border-t border-coolGray-200 py-6 w-full md:w-1/3 lg:w-1/4 px-4">
                    <div class="flex justify-between items-center flex-wrap gap-4 mb-4">
                        <p class="text-rhino-700 font-semibold">Category</p>
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                                <path d="M12.2723 9C12.3679 8.99989 12.4626 9.01868 12.5509 9.05528C12.6393 9.09189 12.7195 9.14559 12.787 9.2133L18.3315 14.7574C18.468 14.8939 18.5447 15.079 18.5447 15.2721C18.5447 15.4651 18.468 15.6503 18.3315 15.7868C18.195 15.9233 18.0098 16 17.8168 16C17.6237 16 17.4386 15.9233 17.3021 15.7868L12.2723 10.7574L7.24253 15.7868C7.10603 15.9233 6.92088 16 6.72783 16C6.53479 16 6.34964 15.9233 6.21314 15.7868C6.07663 15.6503 5.99994 15.4652 5.99994 15.2721C5.99994 15.0791 6.07663 14.8939 6.21313 14.7574L11.7576 9.21327C11.8251 9.14557 11.9054 9.09187 11.9937 9.05527C12.082 9.01867 12.1767 8.99989 12.2723 9Z" fill="#252E4A"></path>
                            </svg>
                        </a>
                    </div>
                    <ul class="text-coolGray-700 flex flex-col gap-2 pb-6 border-b border-coolGray-200">
                        <li class="hover:text-coolGray-800 transition duration-200"><a href="#">Sport shoes</a></li>
                        <li class="hover:text-coolGray-800 transition duration-200"><a href="#">Sneakers</a></li>
                        <li class="hover:text-coolGray-800 transition duration-200"><a href="#">Special edition shoes</a></li>
                        <li class="hover:text-coolGray-800 transition duration-200"><a href="#">Summer specials</a></li>
                        <li class="hover:text-coolGray-800 transition duration-200"><a href="#">Jordan series</a></li>
                    </ul>


                    <div class="py-6 border-b border-coolGray-200">
                        <div class="flex justify-between items-center flex-wrap gap-4 mb-4">
                            <p class="text-rhino-700 font-semibold">Size</p>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                                    <path d="M12.2723 9C12.3679 8.99989 12.4626 9.01868 12.5509 9.05528C12.6393 9.09189 12.7195 9.14559 12.787 9.2133L18.3315 14.7574C18.468 14.8939 18.5447 15.079 18.5447 15.2721C18.5447 15.4651 18.468 15.6503 18.3315 15.7868C18.195 15.9233 18.0098 16 17.8168 16C17.6237 16 17.4386 15.9233 17.3021 15.7868L12.2723 10.7574L7.24253 15.7868C7.10603 15.9233 6.92088 16 6.72783 16C6.53479 16 6.34964 15.9233 6.21314 15.7868C6.07663 15.6503 5.99994 15.4652 5.99994 15.2721C5.99994 15.0791 6.07663 14.8939 6.21313 14.7574L11.7576 9.21327C11.8251 9.14557 11.9054 9.09187 11.9937 9.05527C12.082 9.01867 12.1767 8.99989 12.2723 9Z" fill="#252E4A"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">30</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">40</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-purple-500 text-center text-sm text-purple-700 cursor-pointer">41</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">42</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">43</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">44</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">45</div>
                            </div>
                            <div class="w-1/4 p-2">
                                <div class="flex items-center justify-center border py-3 px-5 rounded-sm border-coolGray-200 text-center text-sm text-coolGray-700 cursor-pointer hover:border-purple-500 hover:text-purple-700 transition duration-200">46</div>
                            </div>
                        </div>
                    </div>

                    <div class="py-6">
                        <div class="flex justify-between items-center flex-wrap gap-4 mb-8">
                            <p class="text-rhino-700 font-semibold">Price</p>
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                                    <path d="M12.2723 9C12.3679 8.99989 12.4626 9.01868 12.5509 9.05528C12.6393 9.09189 12.7195 9.14559 12.787 9.2133L18.3315 14.7574C18.468 14.8939 18.5447 15.079 18.5447 15.2721C18.5447 15.4651 18.468 15.6503 18.3315 15.7868C18.195 15.9233 18.0098 16 17.8168 16C17.6237 16 17.4386 15.9233 17.3021 15.7868L12.2723 10.7574L7.24253 15.7868C7.10603 15.9233 6.92088 16 6.72783 16C6.53479 16 6.34964 15.9233 6.21314 15.7868C6.07663 15.6503 5.99994 15.4652 5.99994 15.2721C5.99994 15.0791 6.07663 14.8939 6.21313 14.7574L11.7576 9.21327C11.8251 9.14557 11.9054 9.09187 11.9937 9.05527C12.082 9.01867 12.1767 8.99989 12.2723 9Z" fill="#252E4A"></path>
                                </svg>
                            </a>
                        </div>
                        <input class="custom-range-1 w-full" type="range">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <p class="text-coolGray-700 text-sm font-medium">$9</p>
                            <p class="text-coolGray-700 text-sm font-medium">$798</p>
                        </div>
                    </div>
                </div>
                <div class="pb-8 w-full md:w-2/3 lg:w-3/4 px-4">
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-orange-500 py-1 px-3 rounded-full text-white text-xs font-bold text-center">New</div>
                                    <img src="coleos-assets/product-list/product1.png" alt="">
                                </div>
                                <p class="text-rhino-700">Nike Sport Shoes V2.04</p>
                                <p class="text-rhino-300">$ 199.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-rhino-600 py-1 px-3 rounded-full text-white text-xs font-bold text-center">Limited</div>
                                    <img src="coleos-assets/product-list/product2.png" alt="">
                                </div>
                                <p class="text-rhino-700">White Label Cap</p>
                                <p class="text-rhino-300">$ 48.99</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-white py-1 px-3 rounded-full text-rhino-700 text-xs font-bold text-center">Sale</div>
                                    <img src="coleos-assets/product-list/product3.png" alt="">
                                </div>
                                <p class="text-rhino-700">Nike Sport Shoes V2.04</p>
                                <p class="text-rhino-300">$ 199.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <img src="coleos-assets/product-list/product4.png" alt="">
                                </div>
                                <p class="text-rhino-700">Summer Slim Shorts</p>
                                <p class="text-rhino-300">$ 79.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <img src="coleos-assets/product-list/product5.png" alt="">
                                </div>
                                <p class="text-rhino-700">Nike Sport Shoes V2.04</p>
                                <p class="text-rhino-300">$ 199.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-orange-500 py-1 px-3 rounded-full text-white text-xs font-bold text-center">New</div>
                                    <img src="coleos-assets/product-list/product6.png" alt="">
                                </div>
                                <p class="text-rhino-700">Brown Original 64’s Jacket</p>
                                <p class="text-rhino-300">$ 249.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <img src="coleos-assets/product-list/product7.png" alt="">
                                </div>
                                <p class="text-rhino-700">Set of colorful t-shirts</p>
                                <p class="text-rhino-300">$ 98.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-orange-500 py-1 px-3 rounded-full text-white text-xs font-bold text-center">New</div>
                                    <img src="coleos-assets/product-list/product8.png" alt="">
                                </div>
                                <p class="text-rhino-700">Blue High School Hoodie</p>
                                <p class="text-rhino-300">$ 65.90</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-white py-1 px-3 rounded-full text-rhino-700 text-xs font-bold text-center">Sale</div>
                                    <img src="coleos-assets/product-list/product9.png" alt="">
                                </div>
                                <p class="text-rhino-700">BlackSeries Nike SuperSport</p>
                                <p class="text-rhino-300">$ 319.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <img src="coleos-assets/product-list/product10.png" alt="">
                                </div>
                                <p class="text-rhino-700">Nike Sport Shoes V2.04</p>
                                <p class="text-rhino-300">$ 199.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <img src="coleos-assets/product-list/product11.png" alt="">
                                </div>
                                <p class="text-rhino-700">TriBlend Crew T-Shirt</p>
                                <p class="text-rhino-300">$ 199.00</p>
                            </a>
                        </div>
                        <div class="w-full xs:w-1/2 lg:w-1/3 px-4">
                            <a class="block mb-10 group" href="#">
                                <div class="w-full h-64 bg-coolGray-100 rounded-xl mb-3 flex items-center justify-center relative flex-1 p-6 border-2 border-transparent group-hover:border-purple-500 transition duration-150">
                                    <div class="absolute left-5 top-5 uppercase bg-orange-500 py-1 px-3 rounded-full text-white text-xs font-bold text-center">New</div>
                                    <img src="coleos-assets/product-list/product12.png" alt="">
                                </div>
                                <p class="text-rhino-700">Nike Sport Shoes V2.04</p>
                                <p class="text-rhino-300">$ 199.00</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
