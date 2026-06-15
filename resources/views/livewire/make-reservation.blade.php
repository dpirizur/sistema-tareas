<div class="space-y-6">
    <div class="p-6 bg-slate-900/95 border border-slate-700 rounded-3xl shadow-2xl">
        <h2 class="text-3xl font-semibold mb-6 text-slate-100">Reservar un Espacio</h2>

        @if ($errorMessage)
            <div class="p-4 mb-4 text-sm text-rose-200 bg-rose-950/80 border border-rose-800 rounded-2xl">{{ $errorMessage }}</div>
        @endif
        @if ($successMessage)
            <div class="p-4 mb-4 text-sm text-emerald-200 bg-emerald-950/80 border border-emerald-800 rounded-2xl">{{ $successMessage }}</div>
        @endif

        <form wire:submit.prevent="createReservation" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Selecciona el Espacio</label>
                <select wire:model="resource_id"
                    class="w-full px-4 py-3 bg-slate-800 border border-slate-700 text-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">-- Elige un espacio --</option>
                    @foreach ($resources as $resource)
                        <option value="{{ $resource->id }}">{{ $resource->name }} (Capacidad: {{ $resource->capacity }} p.)</option>
                    @endforeach
                </select>
                @error('resource_id')
                    <span class="text-rose-300 text-xs mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" wire:model="start_time"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 text-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    @error('start_time')
                        <span class="text-rose-300 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Fecha y Hora de Fin</label>
                    <input type="datetime-local" wire:model="end_time"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 text-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    @error('end_time')
                        <span class="text-rose-300 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-500 transition duration-200">
                Confirmar Reserva
            </button>
        </form>
    </div>

    <div class="p-6 bg-slate-900/95 border border-slate-700 rounded-3xl shadow-2xl" x-data="{ tab: 'actuales' }">
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center border-b border-slate-700 pb-4 mb-6">
            <button @click="tab = 'actuales'"
                :class="tab === 'actuales' ? 'border-blue-500 text-slate-100 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-200 hover:border-slate-600'"
                class="py-2 px-4 border-b-2 rounded-t-xl text-sm transition-colors duration-200">
                Reservas Actuales
            </button>
            <button @click="tab = 'pasadas'"
                :class="tab === 'pasadas' ? 'border-blue-500 text-slate-100 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-200 hover:border-slate-600'"
                class="py-2 px-4 border-b-2 rounded-t-xl text-sm transition-colors duration-200">
                Reservas Pasadas
            </button>
            <button @click="tab = 'candeladas'"
                :class="tab === 'candeladas' ? 'border-blue-500 text-slate-100 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-200 hover:border-slate-600'"
                class="py-2 px-4 border-b-2 rounded-t-xl text-sm transition-colors duration-200">
                Reservas Canceladas
            </button>
        </div>

        <div x-show="tab === 'actuales'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="bg-slate-800 text-slate-300 text-sm font-semibold">
                            <th class="p-3">Espacio</th>
                            <th class="p-3">Desde</th>
                            <th class="p-3">Hasta</th>
                            <th class="p-3">Estado</th>
                            <th class="p-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myReservations as $reservation)
                            <tr class="bg-slate-950 border border-slate-700 rounded-3xl hover:bg-slate-900 transition">
                                <td class="p-4 text-slate-100 font-medium">{{ $reservation->resource->name }}</td>
                                <td class="p-4 text-slate-300">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-slate-300">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $reservation->status === 'reservado' ? 'bg-emerald-950 text-emerald-200' : 'bg-rose-950 text-rose-200' }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    @if ($reservation->status === 'reservado')
                                        <button wire:click="cancelReservation({{ $reservation->id }})"
                                            wire:confirm="¿Estás seguro de que deseas cancelar esta reserva?"
                                            class="px-4 py-2 bg-rose-700 text-rose-100 font-semibold rounded-2xl hover:bg-rose-600 transition text-xs">
                                            Cancelar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">Aún no has realizado ninguna reserva activa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="tab === 'pasadas'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="bg-slate-800 text-slate-300 text-sm font-semibold">
                            <th class="p-3">Espacio</th>
                            <th class="p-3">Desde</th>
                            <th class="p-3">Hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myReservationsOld as $reservation)
                            <tr class="bg-slate-950 border border-slate-700 rounded-3xl hover:bg-slate-900 transition">
                                <td class="p-4 text-slate-100 font-medium">{{ $reservation->resource->name }}</td>
                                <td class="p-4 text-slate-300">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-slate-300">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-slate-400">No tienes historial de reservas pasadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="tab === 'candeladas'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="bg-slate-800 text-slate-300 text-sm font-semibold">
                            <th class="p-3">Espacio</th>
                            <th class="p-3">Desde</th>
                            <th class="p-3">Hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myReservationsCanceladas as $reservation)
                            <tr class="bg-slate-950 border border-slate-700 rounded-3xl hover:bg-slate-900 transition">
                                <td class="p-4 text-slate-100 font-medium">{{ $reservation->resource->name }}</td>
                                <td class="p-4 text-slate-300">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-slate-300">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-slate-400">No tienes historial de reservas pasadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
