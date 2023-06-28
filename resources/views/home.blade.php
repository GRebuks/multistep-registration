<x-app-layout>
    <div class="profile-container">
        <div class="flex flex-row justify-between items-center ml-5 mr-4">
            <h1 class="text-3xl font-bold">Home</h1>
            <div class="flex flex-row gap-5">
                <a href="{{ route('profile') }}" class="auth-redirect text-2xl">Profile</a>
                <a href="{{ route('logout') }}" class="auth-redirect text-2xl">Logout</a>
            </div>
        </div>
        <div class="flex flex-row flex-wrap">
            <div class="max-w-7xl mx-auto p-6 lg:p-8">

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="{{ route('shooter') }}" class="min-h-[12rem] overflow-hidden bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 flex-row">
                            <div class="w-1/3 bg-[url('../../public/images/shooter.png')] bg-cover ">
                            </div>
                            <div class="w-2/3 py-6 pl-6">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Shooter</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    This site features a relaxing PVE shooter game. The main goal is to destroy all cells on the field. The game is made with JS Phaser 3 framework. The game is still in development.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="{{ route('profile') }}" class="min-h-[12rem] overflow-hidden bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 flex-row">
                            <div class="w-1/3 bg-[url('../../public/images/mountains.jpg')] bg-cover">
                            </div>
                            <div class="w-2/3 py-6 pl-6">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Profile</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Manage your profile. Change your password, email, username, avatar and more.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="{{ route('inventory.index') }}" class="min-h-[12rem] overflow-hidden bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 flex-row">
                            <div class="w-1/3 bg-[url('../../public/images/box.jpg')] bg-center bg-contain bg-no-repeat">
                            </div>
                            <div class="w-2/3 py-6 pl-6">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Inventory</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Manage your inventory. Add, remove, edit items. View your inventory.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <a href="https://github.com/GRebuks/multistep-registration" target="_blank" class="min-h-[12rem] overflow-hidden bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 flex-row">
                            <div class="w-1/3 bg-[url('../../public/images/github.svg')] bg-center bg-contain bg-no-repeat">
                            </div>
                            <div class="w-2/3 py-6 pl-6">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Source code</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    View the source code of this site on GitHub.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm sm:text-left">
                        <div class="flex items-center gap-4">

                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm sm:text-right sm:ml-0 text-gray-300">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
