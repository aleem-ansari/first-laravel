<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            User Avatar
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Add or update your avatar
        </p>
    </header>
    <img width=50 height= 50 class="rounded-full"  src="{{ "/storage/$user->avatar" }}" alt="User Avatar"/>

    <form action="{{ route('profile.avatar.ai') }}" method="post" class="mt-4">
        @csrf
        @method('post')

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Generate your Avatar using Ai
        </p>
        <x-primary-button>Generate Avatar</x-primary-button>
    </form>

        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            Or
        </p>

    @if (session('message'))
    <div class="text-red-500">
        {{ session('message') }}
    </div>
    @endif

    <form method="post" action="{{ route('profile.avatar') }}" class="mt-2 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" value="Upload your own Avatar" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" required autofocus autocomplete="avatar" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>
        
        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
