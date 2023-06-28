<x-app-layout>
    <div class="profile-container">
        <h1 class="text-3xl font-bold">Profile</h1>
        <div class="flex flex-row flex-wrap">
            <div class="flex flex-col w-1/3">
                <div class="flex flex-row bg-white rounded-lg drop-shadow-xl m-5 p-3 pl-5 gap-5">
                    <div class="flex flex-col align-middle justify-center w-40 h-40 rounded-full drop-shadow-lg">
                        <img src="{{ asset('images/profile.png') }}" alt="Profile picture" class="rounded-full">
                    </div>
                    <div class="flex flex-col w-full justify-center">
                        <h2 class="text-xl">{{ session()->get('user')->username }}</h2>
                        <p class="text-xl">{{ session()->get('user')->name }} {{ session()->get('user')->surname }}</p>
                        <p class="text-l">{{ session()->get('user')->email }}</p>
                        <p class="text-l">{{ session()->get('user')->birthday }}</p>
                    </div>
                </div>
                <div class="flex flex-col bg-white rounded-lg drop-shadow-xl m-5 p-3 pl-5 gap-5">
                    <h2 class="text-xl">Change password</h2>
                    <form method="POST" action="{{ route('profile.password.post') }}" class="gap-1.5" id="password-change">
                        @if($errors->has('password-change'))
                            <p class="error">{{ $errors->first('password-change') }}</p>
                        @endif
                        @csrf

                        <x-label for="password_old">Old password</x-label>
                        <x-input name="password_old" id="password_old" placeholder="Old password" type="password"></x-input>
                        <x-error>{{ $errors->first('password_old') }}</x-error>

                        <x-label for="password_new">New password</x-label>
                        <x-input name="password_new" id="password_new" placeholder="New password" type="password"></x-input>
                        <x-error>{{ $errors->first('password_new') }}</x-error>

                        <x-label for="password_new_confirmation">Confirm new password</x-label>
                        <x-input name="password_new_confirmation" id="password_new_confirmation" placeholder="Confirm new password" type="password"></x-input>
                        <x-error>{{ $errors->first('password_new_confirmation') }}</x-error>
                        @if(session()->has('password-success'))
                            <p class="success text-xs text-green-700">{{ session()->get('password-success') }}</p>
                        @endif
                        <x-confirm-button>Save</x-confirm-button>
                    </form>
                </div>
                @if($errors->any())
                    <div class="flex flex-col bg-white rounded-lg drop-shadow-xl m-5 p-3 pl-5 gap-5">
                        <h2 class="text-xl">Errors</h2>
                        <ul>
                        @foreach($errors->all() as $error)
                            <li class="error">{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="flex flex-col w-2/3">
                <!--Profile edit form -->
                <div class="flex flex-col bg-white rounded-lg drop-shadow-xl m-5 p-3 pl-5 gap-5">
                    <h2 class="text-xl">Edit profile information</h2>
                    <form action="{{ route('profile.post') }}" method="POST" class="gap-1.5 content-stretch items-stretch" id="update">
                        @csrf
                        <div>
                            <x-label for="username">Username</x-label>
                            <x-input name="username" id="username" placeholder="Username" value="{{ session()->get('user')->username }}"></x-input>
                            <x-error>{{ $errors->first('username') }}</x-error>
                        </div>
                        <div>
                            <x-label for="name">Name</x-label>
                            <x-input name="name" id="name" placeholder="Name" value="{{ session()->get('user')->name }}"></x-input>
                            <x-error>{{ $errors->first('name') }}</x-error>
                        </div>
                        <div>
                            <x-label for="surname">Surname</x-label>
                            <x-input name="surname" id="surname" placeholder="Surname" value="{{ session()->get('user')->surname }}"></x-input>
                            <x-error>{{ $errors->first('surname') }}</x-error>
                        </div>
                        <div>
                            <x-label for="email">E-mail</x-label>
                            <x-input name="email" id="email" placeholder="E-mail" value="{{ session()->get('user')->email }}"></x-input>
                            <x-error>{{ $errors->first('email') }}</x-error>
                        </div>
                        <div>
                            <x-label for="birthday">Birthday</x-label>
                            <x-input name="birthday" id="birthday" type="date" placeholder="Birthday" value="{{ session()->get('user')->birthday }}"></x-input>
                            <x-error>{{ $errors->first('birthday') }}</x-error>
                        </div>
                        @if(session()->has('profile-success'))
                            <p class="profile-success text-xs text-green-700">{{ session()->get('profile-success') }}</p>
                        @endif
                        <x-confirm-button>Save</x-confirm-button>
                    </form>
                </div>
                <!--Delete account form -->
                <div class="flex flex-col bg-white rounded-lg drop-shadow-xl m-5 p-3 pl-5 gap-5">
                    <form method="post" action="{{ route('profile.delete.post') }}" class="gap-1.5">
                        @csrf
                        <h2 class="text-xl">Delete account</h2>
                        <p class="text-l text-red-500">This action is irreversible.</p>
                        <x-caution-button>Delete account</x-caution-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
