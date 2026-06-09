<div class="space-y-6">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Reservar un Espacio</h2>

        @if ($errorMessage)
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ $errorMessage }}</div>
        @endif
        @if ($successMessage)
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ $successMessage }}</div>
        @endif

        <form wire:submit.prevent="createReservation" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Selecciona el Espacio</label>
                <select wire:model="resource_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Elige un espacio --</option>
                    @foreach ($resources as $resource)
                        <option value="{{ $resource->id }}">{{ $resource->name }} (Capacidad: {{ $resource->capacity }}
                            p.)</option>
                    @endforeach
                </select>
                @error('resource_id')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" wire:model="start_time"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('start_time')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora de Fin</label>
                    <input type="datetime-local" wire:model="end_time"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('end_time')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                Confirmar Reserva
            </button>
        </form>
    </div>

    {{-- <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Mis Reservas Actuales</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm font-semibold">
                        <th class="p-3 border-b">Espacio</th>
                        <th class="p-3 border-b">Desde</th>
                        <th class="p-3 border-b">Hasta</th>
                        <th class="p-3 border-b">Estado</th>
                        <th class="p-3 border-b text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($myReservations as $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b font-medium text-gray-800">{{ $reservation->resource->name }}</td>
                            <td class="p-3 border-b">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                            <td class="p-3 border-b">
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                            <td class="p-3 border-b">
                                {{ $reservation->status }}
                            </td>
                            @if ($reservation->status === 'reservado')

                                <td class="p-3 border-b text-right">
                                    <button wire:click="cancelReservation({{ $reservation->id }})"
                                        wire:confirm="¿Estás seguro de que deseas cancelar esta reserva?"
                                        class="px-3 py-1 bg-red-100 text-red-700 font-medium rounded-md hover:bg-red-200 transition text-xs">
                                        Cancelar
                                    </button>
                                </td>

                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">Aún no has realizado ninguna
                                reserva.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <h3 class="text-xl font-semibold mb-4 text-gray-800">Mis Reservas Pasadas</h3>.

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm font-semibold">
                        <th class="p-3 border-b">Espacio</th>
                        <th class="p-3 border-b">Desde</th>
                        <th class="p-3 border-b">Hasta</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($myReservationsOld as $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b font-medium text-gray-800">{{ $reservation->resource->name }}</td>
                            <td class="p-3 border-b">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                            <td class="p-3 border-b">
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">Aún no has realizado ninguna
                                reserva.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> --}}

    <div class="p-6 bg-white rounded-lg shadow-md" x-data="{ tab: 'actuales' }">

        <div class="flex border-b border-gray-200 mb-6">
            <button
                @click="tab = 'actuales'"
                :class="tab === 'actuales' ? 'border-indigo-500 text-indigo-600 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                Reservas Actuales
            </button>
            <button
                @click="tab = 'pasadas'"
                :class="tab === 'pasadas' ? 'border-indigo-500 text-indigo-600 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                Reservas Pasadas
            </button>
            <button
                @click="tab = 'candeladas'"
                :class="tab === 'candeladas' ? 'border-indigo-500 text-indigo-600 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                Reservas Canceladas
            </button>
        </div>

        <div x-show="tab === 'actuales'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm font-semibold">
                            <th class="p-3 border-b">Espacio</th>
                            <th class="p-3 border-b">Desde</th>
                            <th class="p-3 border-b">Hasta</th>
                            <th class="p-3 border-b">Estado</th>
                            <th class="p-3 border-b text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($myReservations as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border-b font-medium text-gray-800">{{ $reservation->resource->name }}</td>
                                <td class="p-3 border-b">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-3 border-b">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-3 border-b">
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $reservation->status === 'reservado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="p-3 border-b text-right">
                                    @if ($reservation->status === 'reservado')
                                        <button wire:click="cancelReservation({{ $reservation->id }})"
                                            wire:confirm="¿Estás seguro de que deseas cancelar esta reserva?"
                                            class="px-3 py-1 bg-red-100 text-red-700 font-medium rounded-md hover:bg-red-200 transition text-xs">
                                            Cancelar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Aún no has realizado ninguna reserva activa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="tab === 'pasadas'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm font-semibold">
                            <th class="p-3 border-b">Espacio</th>
                            <th class="p-3 border-b">Desde</th>
                            <th class="p-3 border-b">Hasta</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($myReservationsOld as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border-b font-medium text-gray-800">{{ $reservation->resource->name }}</td>
                                <td class="p-3 border-b">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-3 border-b">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">No tienes historial de reservas pasadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="tab === 'candeladas'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm font-semibold">
                            <th class="p-3 border-b">Espacio</th>
                            <th class="p-3 border-b">Desde</th>
                            <th class="p-3 border-b">Hasta</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($myReservationsCanceladas as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border-b font-medium text-gray-800">{{ $reservation->resource->name }}</td>
                                <td class="p-3 border-b">{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y H:i') }}</td>
                                <td class="p-3 border-b">{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">No tienes historial de reservas pasadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
