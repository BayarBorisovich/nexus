<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8">Редактирование профиля</h1>

            <!-- Форма -->
            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-lg p-8">
                <!-- Имя -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Имя
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ваше имя"
                    />
                    <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="your@email.com"
                    />
                    <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Username -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Имя пользователя
                    </label>
                    <input
                        v-model="form.username"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="username"
                    />
                    <p v-if="form.errors.username" class="text-red-500 text-sm mt-1">
                        {{ form.errors.username }}
                    </p>
                </div>

                <!-- Био -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        О себе
                    </label>
                    <textarea
                        v-model="form.bio"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        placeholder="Расскажите о себе..."
                    ></textarea>
                    <p v-if="form.errors.bio" class="text-red-500 text-sm mt-1">
                        {{ form.errors.bio }}
                    </p>
                </div>

                <!-- Дата рождения -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Дата рождения
                    </label>
                    <input
                        v-model="form.birthdate"
                        type="date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-if="form.errors.birthdate" class="text-red-500 text-sm mt-1">
                        {{ form.errors.birthdate }}
                    </p>
                </div>

                <!-- Локация -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Местоположение
                    </label>
                    <input
                        v-model="form.location"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Город, страна"
                    />
                    <p v-if="form.errors.location" class="text-red-500 text-sm mt-1">
                        {{ form.errors.location }}
                    </p>
                </div>

                <!-- Сайт -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Веб-сайт
                    </label>
                    <input
                        v-model="form.website"
                        type="url"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="https://example.com"
                    />
                    <p v-if="form.errors.website" class="text-red-500 text-sm mt-1">
                        {{ form.errors.website }}
                    </p>
                </div>

                <!-- Интересы -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Интересы (через запятую)
                    </label>
                    <input
                        :value="interestsString"
                        @input="updateInterests"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Спорт, музыка, путешествия..."
                    />
                    <p v-if="form.errors.interests" class="text-red-500 text-sm mt-1">
                        {{ form.errors.interests }}
                    </p>
                </div>

                <!-- Кнопка отправки -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition disabled:opacity-50"
                >
                    {{ form.processing ? 'Сохранение...' : 'Сохранить профиль' }}
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layouts/AppLayout.vue'

const props = defineProps({
    user: Object,
    profile: Object,
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    username: props.user.username,
    bio: props.profile.bio || '',
    birthdate: props.profile.birthdate || '',
    location: props.profile.location || '',
    website: props.profile.website || '',
    social_links: props.profile.social_links || [],
    interests: props.profile.interests || [],
})

const interestsString = computed(() => {
    return form.interests.join(', ')
})

const updateInterests = (event) => {
    form.interests = event.target.value
        .split(',')
        .map(i => i.trim())
        .filter(Boolean)
}

const submit = () => {
    form.put('/profile')
}
</script>
