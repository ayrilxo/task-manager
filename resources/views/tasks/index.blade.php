<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale-1"/>
        <title>Task Manager</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/tasksChart.js') }}"></script>



    </head>

    <body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">

        <h1 class="text-4xl font-bold mb-6 text-center text-gray-800"> Task List</h1>



    <div class="mb-8 flex space-x-4">
        <form action="{{ route('tasks.create') }}" method="get" class="inline">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-blue-400 transition">
                + Add New Task
            </button>
        </form>

        <a href="{{ route('tasks.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 focus:outline-none focus:ring-gray-400 transition">
            All Tasks
        </a>

        <a href="{{ route('tasks.index', ['filter' => 'incomplete']) }}" class="bg-yellow-500 text-white px-6 py-3 rounded-lg shadow hover:bg-yellow-700 focus:outline-none focus:ring-yellow-400 transition">
            Incomplete Tasks
        </a>
    </div>


    <ul class="w-full max-w-xl space-y-4">
        @foreach ($tasks as $task )

        <li class="bg-white rounded-lg shadow p-4 flex items-center justify-between space-x-4">

        <div class="flex-1 min-w-0">
            <p class="text-lg font-semibold text-gray-900 truncate"> {{ $task->title }}</p>
            <span class="inline-block px-2 py-1 met-1 text-xs font-medium rounded-full {{ $task->is_completed ? 'bg-green-100 text-green-800': 'bg-yellow-100 text-yellow-800' }}">  
                {{ $task->is_completed ? 'Done' : 'Pending' }}
            </span>
        </div>

        <p class="text-sm text-gray-600">
            <strong>Deadline:</strong> 
            {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('F j, Y') : 'No deadline' }}
        </p>

        <div class="flex items-center space-x-2">

            <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-600 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-400 rounded px-2 py-1" aria-label="Edit task {{ $task->title }}">Edit</a>

            <form action="{{ route('tasks.delete', $task->id) }}" method="POST"  onsubmit="event.preventDefault(); confirmDelete(this);">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-400 rounded px-2 py-1" aria-label="Delete task {{ $task->title }}">DELETE</button>
            </form>
            
            @if(!$task->is_completed)
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" onsubmit="event.preventDefault(); confirmMarkAsDone(this);">
                @csrf
                @method('PUT')
                <input type="hidden" name="is_completed" value = "1">
                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition" aria-label="Mark task {{ $task->title }} as done">Mark as Done</button>
            </form>
            @endif
        </li>
    </div>
 
        @endforeach
    </ul>

        <div class="w-full max-w-sm mb-6">
            <canvas id="taskChart" class="!w-full !h-auto"></canvas>
        </div>




    </body>

<script>

     document.addEventListener('DOMContentLoaded', function () {
        const completedCount = {{ $completedCount }};
        const pendingCount = {{ $pendingCount }};
        renderTaskChart(completedCount, pendingCount);
    });

function confirmDelete(form) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to undo this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function confirmMarkAsDone(form) {
            Swal.fire({
                title: 'Mark as Done?',
                text: "Are you sure you want to mark this task as completed?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38a169',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, mark as done!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

</script>

</html>

