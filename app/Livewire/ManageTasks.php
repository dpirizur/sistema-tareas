<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class ManageTasks extends Component
{
    // Esta variable guardará lo que el usuario escriba en el input del formulario
    public $title = '';

    // Reglas de validación para el formulario
    protected $rules = [
        'title' => 'required|min:3|max:255',
    ];

    // Función para guardar una nueva tarea
    public function addTask()
    {
        $this->validate();

        // Creamos la tarea asociada al usuario que tiene la sesión iniciada en Mac
        Auth::user()->tasks()->create([
            'title' => $this->title,
        ]);

        // Limpiamos el input del formulario después de guardar
        $this->title = '';
    }

    // Función para marcar como completada / desmarcar una tarea
    public function toggleTask($taskId)
    {
        $task = Auth::user()->tasks()->find($taskId);
        if ($task) {
            $task->update([
                'is_completed' => !$task->is_completed
            ]);
        }
    }

    // Renderiza la vista y le pasa las tareas actuales del usuario
    public function render()
    {
        return view('livewire.manage-tasks', [
            'tasks' => Auth::user()->tasks()->latest()->get()
        ]);
    }
}
