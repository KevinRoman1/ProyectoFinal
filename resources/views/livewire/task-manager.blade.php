<?php

use Livewire\Volt\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public string $taskTarea = '';

    public function with()
    {
        return [
            'tasks' => Auth::user()->tasks()->get(),
        ];
    }

    public function createTask()
    {
        $this->validate([
            'taskTarea' => 'required|string|max:255',
        ]);

        Auth::user()
            ->tasks()
            ->create([
                'tarea' => $this->taskTarea,
            ]);
        $this->taskTarea = '';
    }

    public function delete($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();
        $this->tasks = Auth::user()->tasks()->get();
    }


};;?>

<div>
    <form wire:submit.prevent="createTask">
        <x-text-input wire:model="taskTarea" placeholder="Ingresa Tarea" />
        <x-primary-button type="submit">Crear</x-primary-button>
    </form>

    @foreach ($tasks as $task)
        <div wire:key="{{ $task->id }}" class="flex items-center space-x-4 space-y-2">
            <div>
                {{ $task->tarea }}
            </div>
            <button wire:click="delete({{ $task->id }})" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Eliminar</button>
        </div>
    @endforeach
</div>
