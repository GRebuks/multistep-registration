<x-app-layout>
    <script>
        let csrf = "{{ csrf_token() }}";
    </script>
    @vite('resources/js/inventory.js')
    <div class="profile-container">
        <div class="flex flex-row justify-between items-center ml-5 mr-4">
            <h1 class="text-3xl font-bold">Inventory</h1>
            <div class="flex flex-row gap-5">
                <input type="text" id="search" class="border border-sky-200 rounded-lg p-1 active:border-sky-200 active:border-3" placeholder="Search...">
                <button id="search-btn" class="py-2 px-4 rounded-full border border-sky-200 text-sm font-semibold bg-sky-100 text-sky-700 hover:bg-sky-200 w-30">Search</button>
            </div>

            <div class="flex flex-row gap-5">
                <a href="{{ route('home') }}" class="auth-redirect text-2xl">Home</a>
                <a href="{{ route('profile') }}" class="auth-redirect text-2xl">Profile</a>
                <a href="{{ route('logout') }}" class="auth-redirect text-2xl">Logout</a>
            </div>
        </div>
        <div class="flex flex-col flex-wrap mx-5">
            <table class="border-collapse border border-slate-400 bg-slate-200 w-full text-center m-3" id="inventory-table">
                <thead class="text-xl">
                    <tr class="bg-slate-200">
                        <th class="border border-slate-300 w-1/6 hover:bg-slate-300 cursor-pointer inventory-col" data-id="name">Item</th>
                        <th class="border border-slate-300 w-1/3 hover:bg-slate-300 cursor-pointer inventory-col" data-id="description">Description</th>
                        <th class="border border-slate-300 w-1/12 hover:bg-slate-300 cursor-pointer inventory-col" data-id="quantity">Quantity</th>
                        <th class="border border-slate-300 w-1/12 hover:bg-slate-300 cursor-pointer inventory-col" data-id="price">Price</th>
                        <th class="border border-slate-300 w-1/12 hover:bg-slate-300 cursor-pointer inventory-col" data-id="category">Category</th>
                        <th class="border border-slate-300 w-1/12 hover:bg-slate-300 cursor-pointer inventory-col" data-id="owner">Owner</th>
                        <th class="border border-slate-300 w-1/6">Control</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($inventory as $item)
                        <tr class="odd:bg-white even:bg-slate-50">
                            <td class="border border-slate-300">{{ $item->name }}</td>
                            <td class="border border-slate-300">{{ $item->description }}</td>
                            <td class="border border-slate-300">{{ $item->quantity }}</td>
                            <td class="border border-slate-300">{{ $item->price }}</td>
                            <td class="border border-slate-300">{{ $item->category }}</td>
                            <td class="border border-slate-300">{{ $item->user->username }}</td>
                            <td class="border border-slate-300">
                                <div class="flex flex-row gap-3 justify-evenly">
                                    <a href="{{ route('inventory.edit', $item->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('inventory.delete', $item->id) }}" method="POST">
                                        <input type="hidden" name="csrf" value="{{ csrf_token() }}">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="text-red-500 flex">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="flex flex-row items-center">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <a href="{{ route('inventory.create') }}" class="btn btn-primary text-gray-500">Add Item</a>
            </div>
        </div>
    </div>
</x-app-layout>
