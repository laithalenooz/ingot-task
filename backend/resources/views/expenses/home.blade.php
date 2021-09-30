<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Balance') }}: <small>{{auth()->user()->balance}}</small>
        </h2>
    </x-slot>

    <section class="container mx-auto p-6 font-mono">
        @if(session()->has('error'))
            <div class="flex gap-4 bg-red-100 p-4 rounded-md mb-5">
                <div class="space-y-1 text-sm">
                    <h6 class="font-medium text-red-900">Balance Error!</h6>
                    <p class="text-red-700 leading-tight">{{ session()->get('error') }}</p>
                </div>
            </div>
        @endif
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
            <div class="w-full overflow-x-auto">
                <a href="{{route('expenses.create')}}"><button class="px-4 py-2 rounded-md text-sm font-medium border focus:outline-none focus:ring transition text-gray-600 border-gray-600 hover:text-white hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300">
                    Add Expense</button></a>
                <table class="w-full">
                    <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Note</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach($expenses as $value)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->category}}</span></td>
                            <td class="px-4 py-3 text-xs border">
                                <span>{{$value->amount}}</span>
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                <span>{{$value->note}}</span>
                            </td>
                            <td class="px-4 py-3 text-sm border">{{\Carbon\Carbon::create($value->created_at)->format('Y-m-d')}}</td>
                            <td class="px-4 py-3 text-sm border">
                                <form method="post" action="{{route('expenses.destroy', $value->id)}}">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                        <span class="mr-2">Delete</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentcolor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                        </svg>
                                    </button>

                                    <a href="{{route('expenses.edit', $value->id)}}" class="bg-white text-gray-800 font-bold rounded border-b-2 border-green-500 hover:border-green-600 hover:bg-green-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                        <span class="mr-2">Edit</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentcolor" d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                                        </svg>
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
