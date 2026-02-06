<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Logo -->
                <Link href="/" class="text-2xl font-bold text-blue-600">
                    Nexus
                </Link>

                <!-- Nav Items -->
                <div class="flex items-center gap-6">
                    <!-- Профиль -->
                    <Link
                        :href="`/profile/${auth.user.id}`"
                        class="text-gray-700 hover:text-blue-600 transition flex items-center gap-1"
                    >
                        👤 Профиль
                    </Link>

                    <!-- Выход -->
                    <form @submit.prevent="logout" class="inline">
                        <button
                            type="submit"
                            class="text-red-500 hover:text-red-700 transition font-medium"
                        >
                            Выход
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { Link, router } from '@inertiajs/vue3'

const page = usePage()
const auth = page.props.auth

const logout = () => {
    // ИСПРАВЛЕНО: используем строку вместо route()
    router.post('/logout')
}
</script>

<style scoped>
/* Плавные переходы для ссылок */
a {
    transition: color 0.2s ease;
}
</style>
