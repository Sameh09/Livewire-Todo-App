<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{

    use WithPagination;
    public $name;
    public $search;

    public $todo_id;
    public $todo_new_name;

    public function create(){
        $validated = $this->validate([
            'name'=>'required'
        ]);

        Todo::create($validated);
        
        $this->reset('name');

        request()->session()->flash('success','Todo Created Successfully');
        
        $this->resetPage();
    }

    public function delete(Todo $todo){
        $todo->delete();
    }

    public function toggle(Todo $todo){
        $todo->completed = ! $todo->completed ;
        $todo->save();
    }

    public function edit(Todo $todo){
        $this->todo_id = $todo->id;
        $this->todo_new_name = $todo->name;
    }

    public function cancel_edit(){
        $this->reset('todo_new_name','todo_id');
    }

    public function update(){

        $this->validate([
            'todo_new_name'=>'required'
        ]);
        Todo::find($this->todo_id)->update([
            'name'=>$this->todo_new_name
        ]);
        
        $this->cancel_edit();

    }

    public function render()
    {
        
        return view('livewire.todo-list',[
            'Todos'=>Todo::latest()->where('name','like',"%{$this->search}%")->paginate(5)
        ]);
    }
}
