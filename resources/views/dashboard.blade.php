<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/90 border border-slate-700 overflow-hidden shadow-lg sm:rounded-3xl">
                <div class="p-6 text-slate-100">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <livewire:make-reservation />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
