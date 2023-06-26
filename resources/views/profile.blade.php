<x-app-layout>
    <div class="profile-container">
        <h1>Profile</h1>

        @if(!session()->has('user'))
            <p>User is not logged in</p>
        @else
            <h2>{{ session()->get('user')->username }}</h2>
            <p>{{ session()->get('user')->name }} {{ session()->get('user')->surname }}</p>
        @endif
    </div>
</x-app-layout>
