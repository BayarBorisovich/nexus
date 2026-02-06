<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Успех иконка -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-400 to-green-500 rounded-full shadow-lg">
                    <svg style="width: 3rem; height: 3rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Заголовок -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Добро пожаловать, {{ user.name }}! 🎉</h1>
            <p class="text-xl text-gray-600 mb-8">Вы успешно зарегистрировались в Nexus</p>

            <!-- Информация профиля -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-8 mb-8">
                <div class="space-y-4 text-left">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <span class="text-gray-600">Никнейм:</span>
                        <span class="font-semibold text-gray-900">@{{ user.username }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold text-gray-900">{{ user.email }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Аккаунт:</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Активен ✓</span>
                    </div>
                </div>
            </div>

            <!-- Следующие шаги -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
                <h2 class="text-lg font-semibold text-blue-900 mb-4">Что дальше?</h2>
                <ul class="text-left space-y-2 text-blue-800">
                    <li class="flex items-center">
                        <svg style="width: 1.25rem; height: 1.25rem;" class="mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Заполните информацию в профиле
                    </li>
                    <li class="flex items-center">
                        <svg style="width: 1.25rem; height: 1.25rem;" class="mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Добавьте фото профиля
                    </li>
                    <li class="flex items-center">
                        <svg style="width: 1.25rem; height: 1.25rem;" class="mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Найдите интересующих вас людей
                    </li>
                </ul>
            </div>

            <!-- Кнопки действий -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <!-- Используем Link без route() для простоты -->
                <Link
                    :href="`/profile/${user.id}`"
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-200 hover:scale-105"
                >
                    Мой профиль
                </Link>
                <button
                    @click="logout"
                    class="px-8 py-3 bg-gray-200 text-gray-900 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200"
                >
                    Выход
                </button>
            </div>

            <!-- Дополнительная информация -->
            <p class="text-sm text-gray-500 mt-8">
                Спасибо за регистрацию! Если у вас есть вопросы, свяжитесь с нами.
            </p>
        </div>
    </div>
</template>

<script setup>
import { usePage, Link, router } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user

const logout = () => {
    router.post('/logout')
}
</script>

<style scoped>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

div {
    animation: fadeInUp 0.5s ease-out;
}
</style>
