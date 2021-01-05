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
                <label class="label">Task Name</label>
                <div class="control">
                    <input type="text" name="task_name" class="input" placeholder="task name" @isset($task)
                    value="{{ old('task_name', $task->task_name) }}" @else value="{{ old('task_name') }}" @endisset>

                @error('task_name')
                    <span class="help is-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        {{-- task desc --}}
        <div class="field">
            <label class="label">Task Description</label>
            <div class="control has-icons-left">
                <textarea name="task_desc" rows="5" class="textarea" style="resize: none"
                    placeholder="task desc">@isset($task){{ old('task_desc', $task->task_desc) }} @else {{ old('task_desc') }} @endisset</textarea>
                @error('task_desc')
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
        let calendars = bulmaCalendar.attach('[type="date"]');
    });

</script>
@endsection
