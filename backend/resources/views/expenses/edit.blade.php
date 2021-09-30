<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Balance') }}: <small>{{auth()->user()->balance}}</small>
        </h2>
    </x-slot>

    <section class="container mx-auto p-6 font-mono">
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{@route('wallet.update', $balance->id)}}" method="post">
                <div class="grid lg:grid-cols-2 gap-6">
                    @csrf
                    @method('put')
                    <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                        <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                            <p>
                                <label for="income_type" class="bg-white text-gray-600 px-1">Income Type *</label>
                            </p>
                        </div>
                        <p>
                            <select name="income_type" onchange="newCategory(this)" class="py-1 px-1 outline-none block h-full w-full">
                                <option value="{{$balance->income_type}}">{{$balance->income_type}}</option>
                                <option value="Salary">Salary</option>
                                <option value="Bonus">Bonus</option>
                                <option value="Overtime">Overtime</option>
                                <option value="Other">Other</option>
                            </select>
                        </p>
                        @error('income_type')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                        <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                            <p>
                                <label for="amount" class="bg-white text-gray-600 px-1">Amount *</label>
                            </p>
                        </div>
                        <p>
                            <input  value="{{$balance->amount}}" id="amount" autocomplete="false" tabindex="0" type="number"
                                   class="py-1 px-1 outline-none block h-full w-full" name="amount">
                        </p>
                        @error('amount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="newCategory" style="display: none;"
                         class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                        <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                            <p>
                                <label for="other" class="bg-white text-gray-600 px-1">New Category *</label>
                            </p>
                        </div>
                        <p>
                            <input name="income_type_new" id="other" autocomplete="false" tabindex="0" type="text"
                                   class="py-1 px-1 outline-none block h-full w-full">
                        </p>
                        @error('income_type_new')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="newCategoryDiv" style="display: none;"></div>
                    <div class="border-t mt-6 pt-3">
                        <button class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700 transition-all duration-300" name="submit">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>

<script type="text/javascript">
    function newCategory(that) {
        if (that.value == "Other") {
            document.getElementById("newCategory").style.display = "block";
            document.getElementById("newCategoryDiv").style.display = "block";
        } else {
            document.getElementById("newCategory").style.display = "none";
            document.getElementById("newCategoryDiv").style.display = "none";
        }
    }
</script>