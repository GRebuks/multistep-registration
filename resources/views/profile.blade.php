<x-app-layout>
    <div class="profile-container">
        <h1 class="text-3xl font-bold">Profile</h1>

        @if(!session()->has('user'))
            <p>User is not logged in</p>
        @else
            <h2 class="text-2xl">{{ session()->get('user')->username }}</h2>
            <p class="text-xl">{{ session()->get('user')->name }} {{ session()->get('user')->surname }}</p>
        @endif
    </div>
</x-app-layout>
