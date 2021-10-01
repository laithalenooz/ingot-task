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
                <a href="{{route('wallet.create')}}">
                    <button class="px-4 py-2 rounded-md text-sm font-medium border focus:outline-none focus:ring transition text-gray-600 border-gray-600 hover:text-white hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300">
                        Add Balance
                    </button>
                </a>
                <table class="w-full">
                    <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Birthdate</th>
                        <th class="px-4 py-3">Total Expenses</th>
                        <th class="px-4 py-3">Total Income</th>
                        <th class="px-4 py-3">Wallet Balance</th>
                        <th class="px-4 py-3">Registered Date</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach($users as $value)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->name}}</span></td>
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->email}}</span></td>
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->phone}}</span></td>
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->birthdate}}</span></td>
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->expenses}}</span></td>
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->income}}</span></td>
                            <td class="px-4 py-3 text-ms font-semibold border"><span>{{$value->balance}}</span></td>
                            <td class="px-4 py-3 text-sm border">{{\Carbon\Carbon::create($value->created_at)->format('Y-m-d')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $users->links() !!}
    </section>
</x-app-layout>