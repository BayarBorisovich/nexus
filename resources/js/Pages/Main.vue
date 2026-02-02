<script setup>
defineProps({
    user: Object,
    posts: Array,
})
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">MySocial</h1>
                <div v-if="user">
                    👋 {{ user.name }}
                </div>
                <div v-else>
                    <a href="/profile" class="text-blue-500">Профиль</a>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="max-w-5xl mx-auto px-4 py-6 grid grid-cols-12 gap-4">
            <!-- Left sidebar -->
            <aside class="col-span-3 bg-white p-4 rounded shadow">
                <nav class="space-y-2">
                    <a href="#" class="block text-gray-700 hover:text-blue-500">Profile</a>
                    <a href="#" class="block text-gray-700 hover:text-blue-500">Friends</a>
                    <a href="#" class="block text-gray-700 hover:text-blue-500">Messages</a>
                </nav>
            </aside>

            <!-- Feed -->
            <section class="col-span-6 space-y-4">
                <!-- New post -->
                <div class="bg-white p-4 rounded shadow">
                    <textarea
                        class="w-full border rounded p-2"
                        placeholder="What's on your mind?"
                    ></textarea>
                    <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                        Post
                    </button>
                </div>

                <!-- Posts -->
                <div
                    v-for="post in posts"
                    :key="post.id"
                    class="bg-white p-4 rounded shadow"
                >
                    <div class="font-semibold">{{ post.author }}</div>
                    <div class="text-gray-700 mt-2">{{ post.content }}</div>
                    <div class="text-sm text-gray-400 mt-2">
                        {{ post.created_at }}
                    </div>
                </div>
            </section>

            <!-- Right sidebar -->
            <aside class="col-span-3 bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Suggestions</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>👤 Alex</li>
                    <li>👤 Maria</li>
                    <li>👤 Ivan</li>
                </ul>
            </aside>
        </main>
    </div>
</template>
