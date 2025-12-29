<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

        <!-- Users Table -->
        <h2 class="text-xl font-semibold mb-2">Users</h2>
        <table class="min-w-full bg-white shadow rounded mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ $user->role }}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded">Ban</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Posts Table -->
        <h2 class="text-xl font-semibold mb-2">Posts</h2>
        <table class="min-w-full bg-white shadow rounded mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Author</th>
                    <th class="px-4 py-2">Comments</th>
                    <th class="px-4 py-2">Likes</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td class="border px-4 py-2">{{ $post->title }}</td>
                    <td class="border px-4 py-2">{{ $post->user->name }}</td>
                    <td class="border px-4 py-2">{{ $post->comments_count }}</td>
                    <td class="border px-4 py-2">{{ $post->likes_count }}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Comments Table -->
        <h2 class="text-xl font-semibold mb-2">Comments</h2>
        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2">Body</th>
                    <th class="px-4 py-2">Author</th>
                    <th class="px-4 py-2">Post</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td class="border px-4 py-2">{{ $comment->body }}</td>
                    <td class="border px-4 py-2">{{ $comment->user->name }}</td>
                    <td class="border px-4 py-2">{{ $comment->post->title }}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
