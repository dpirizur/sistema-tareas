<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Mis Tareas Pendientes</h2>

    <form wire:submit.prevent="addTask" class="flex gap-2 mb-6">
        <input
            type="text"
            wire:model="title"
            placeholder="¿Qué tienes que hacer hoy?"
            class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Añadir
        </button>
    </form>

    @error('title') <span class="text-red-500 text-sm block mb-4">{{ $message }}</span> @enderror

    <ul class="space-y-3">
        @forelse($tasks as $task)
            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        wire:click="toggleTask({{ $task->id }})"
                        {{ $task->is_completed ? 'checked' : '' }}
                        class="w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                    >
                    <span class="{{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-700' }} font-medium">
                        {{ $task->title }}
                    </span>
                </div>
            </li>
        @empty
            <p class="text-gray-500 text-center">No hay tareas pendientes. ¡Buen trabajo!</p>
        @endforelse
    </ul>
</div>
