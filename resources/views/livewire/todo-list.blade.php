<div>
    @include('livewire.includes.create_todo_box')
    @include('livewire.includes.todo_searchbox')
    <div id="todos-list">
        @foreach ($Todos as $todo)
            @include('livewire.includes.todo_card')
        @endforeach
        <div class="my-2">
            {{ $Todos->links() }}
        </div>
    </div>
</div>
