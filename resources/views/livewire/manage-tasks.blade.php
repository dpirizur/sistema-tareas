<div class="p-6 bg-slate-900/95 border border-slate-700 rounded-3xl shadow-2xl">
    <h2 class="text-3xl font-semibold mb-5 text-slate-100">Mis Tareas Pendientes</h2>

    <form wire:submit.prevent="addTask" class="flex flex-col sm:flex-row gap-3 mb-6">
        <input type="text" wire:model="title" placeholder="¿Qué tienes que hacer hoy?"
            class="flex-1 px-4 py-3 bg-slate-800 border border-slate-700 text-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-500 transition">
            Añadir
        </button>
    </form>

    @error('title')
        <span class="text-rose-300 text-sm block mb-4">{{ $message }}</span>
    @enderror

    <ul class="space-y-3">
        @forelse($tasks as $task)
            <li class="flex items-center justify-between p-4 bg-slate-950 border border-slate-700 rounded-3xl hover:bg-slate-900 transition">
                <div class="flex items-center gap-4">
                    <input type="checkbox" wire:click="toggleTask({{ $task->id }})"
                        {{ $task->is_completed ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-500 rounded border-slate-600 bg-slate-900 focus:ring-blue-500" />
                    <span class="font-medium {{ $task->is_completed ? 'line-through text-slate-500' : 'text-slate-200' }}">
                        {{ $task->title }}
                    </span>
                </div>
            </li>
        @empty
            <p class="text-slate-400 text-center">No hay tareas pendientes. ¡Buen trabajo!</p>
        @endforelse
    </ul>
</div>
