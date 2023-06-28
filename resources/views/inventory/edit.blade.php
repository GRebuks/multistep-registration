<x-app-layout>
    <div class="flex flex-col bg-white rounded-lg drop-shadow-xl m-5 p-3 pl-5 gap-5">
        <div class="flex flex-row justify-between items-center ml-5 mr-4">
            <h1 class="text-3xl font-bold">Edit product</h1>
            <div class="flex flex-row gap-5">
                <a href="{{ route('inventory.index') }}" class="auth-redirect text-2xl">Back</a>
            </div>
        </div>
        <form action="{{ route('inventory.update', ['id' => $inventory->id]) }}" method="POST" class="gap-1.5 content-stretch items-stretch" id="update">
            @csrf
            <div>
                <x-label for="name">Name</x-label>
                <x-input name="name" id="name" placeholder="Name" value="{{ $inventory->name }}"></x-input>
                <x-error>{{ $errors->first('name') }}</x-error>
            </div>
            <div>
                <x-label for="description">Description</x-label>
                <x-input name="description" id="description" placeholder="Description" value="{{ $inventory->description }}"></x-input>
                <x-error>{{ $errors->first('description') }}</x-error>
            </div>
            <div>
                <x-label for="price">Price</x-label>
                <x-input name="price" id="price" placeholder="Price" value="{{ $inventory->price }}"></x-input>
                <x-error>{{ $errors->first('price') }}</x-error>
            </div>
            <div>
                <x-label for="quantity">Quantity</x-label>
                <x-input name="quantity" id="quantity" placeholder="Quantity" value="{{ $inventory->quantity }}"></x-input>
                <x-error>{{ $errors->first('quantity') }}</x-error>
            </div>
            <div>
                <x-label for="category">Category</x-label>
                <x-input name="category" id="category" placeholder="category" value="{{ $inventory->category }}"></x-input>
                <x-error>{{ $errors->first('category') }}</x-error>
            </div>
            <input type="hidden" name="user_id" value="{{ session()->get('user')->id }}">

            <x-confirm-button>Edit</x-confirm-button>
        </form>
    </div>
</x-app-layout>
