@extends('admin.template.template')
@section('content')
    @parent
@section('page_name', $page_name)
    <div class="box">
        <form action="" method="POST">
            @csrf
            @method($method)
            {{-- task name --}}
            <div class="field">
                <label class="label">Task</label>
                <div class="control select is-fullwidth">
                    <select name="task_id">
                        <option value="" disabled selected>Select</option>
                        @foreach ($tasks as $item)
                            <option value="{{ $item->id }}" @isset($task) @if ($task->id == $item->id)
                                selected
                        @endif
                    @endisset>{{ $item->task_name }}</option>
                    @endforeach
                </select>
                @error('task_id')
                    <span class="help is-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @if ($method == 'POST')
            <button class="button is-primary is-fullwidth has-text-weight-bold">Create</button>
        @endif
        @if ($method == 'PUT')
            <button class="button is-primary is-fullwidth has-text-weight-bold">Update</button>
        @endif
    </form>
</div>
@endsection

@section('script')
@parent
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let method = "{{ $method }}";
        if (!method) {
            document.querySelectorAll('input,textarea').forEach((item) => {
                item.setAttribute('disabled', 'disabled')
            });
        }
    });

</script>
@endsection
