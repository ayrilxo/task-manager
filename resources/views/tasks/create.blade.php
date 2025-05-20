<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Task</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">

    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Create a New Task</h1>

    <div class="bg-white rounded-lg shadow p-8 w-full max-w-lg">
        <form action="{{ route('tasks.store') }}" method="POST" onsubmit="event.preventDefault(); confirmCreateTask(this);">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title:</label>
                <input type="text" name="title" id="title" required class="w-full border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="Enter task title">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description:</label>
                <textarea name="description" id="description" class="w-full border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" rows="4" placeholder="Enter task description"></textarea>
            </div>

            <div class="mb-6">
                <label for="deadline" class="block text-gray-700 font-semibold mb-2">Deadline:</label>
                <input type="date" name="deadline" id="deadline" class="w-full border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>


            <div class="flex justify-end space-x-4">
                <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded px-4 py-2 transition">Back to Task List</a>
                
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">Create Task</button>
            </div>
        </form>
    </div>

    <script>
        function confirmCreateTask(form) {
            const title = document.getElementById('title').value.trim();
            if (title === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Title Required',
                    text: 'Please enter a title for your task.',
                });
                return;
            }

            Swal.fire({
                title: 'Create Task?',
                text: "Are you sure you want to create this task?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

</body>
</html>
