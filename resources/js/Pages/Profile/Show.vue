<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Обложка -->
            <div class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 h-48 rounded-t-2xl"></div>

            <!-- Карточка профиля -->
            <div class="bg-white rounded-b-2xl shadow-lg -mt-20 relative pb-8">
                <!-- АВАТАР С ЗАГРУЗКОЙ И УДАЛЕНИЕМ -->
                <div class="flex justify-between items-start px-8 pt-8">
                    <div class="flex items-end gap-6">

                        <!-- АВАТАР СВОЕГО ПРОФИЛЯ (с возможностью загрузки и удаления) -->
                        <div v-if="isOwnProfile" class="relative group">
                            <!-- Изображение аватара -->
                            <img
                                :src="currentAvatarUrl"
                                :alt="user.name"
                                class="w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover cursor-pointer"
                            />

                            <!-- Оверлей при наведении мыши -->
                            <label class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 transition duration-200 cursor-pointer">
                                <span class="text-white text-sm font-medium flex flex-col items-center gap-1">
                                    📷
                                    <span>Изменить фото</span>
                                </span>

                                <!-- Скрытый input для выбора файла -->
                                <input
                                    ref="avatarInput"
                                    type="file"
                                    accept="image/*"
                                    class="hidden"
                                    @change="uploadAvatar"
                                    :disabled="uploading || deleting"
                                />
                            </label>

                            <!-- Индикатор загрузки -->
                            <div v-if="uploading" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-60 rounded-full">
                                <div class="animate-spin">⏳</div>
                            </div>
                        </div>

                        <!-- СТАТИЧНЫЙ АВАТАР ДЛЯ ЧУЖИХ ПРОФИЛЕЙ -->
                        <img
                            v-else
                            :src="user.avatar_url"
                            :alt="user.name"
                            class="w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover"
                        />

                        <!-- Информация профиля -->
                        <div class="pb-4">
                            <h1 class="text-4xl font-bold text-gray-900">{{ user.name }}</h1>
                            <p class="text-xl text-gray-500">@{{ user.username }}</p>
                            <p v-if="profile?.location" class="text-gray-600 mt-2">
                                📍 {{ profile.location }}
                            </p>
                        </div>
                    </div>

                    <!-- Кнопка редактирования профиля -->
                    <a
                        v-if="isOwnProfile"
                        href="/profile/edit"
                        class="px-8 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full font-semibold transition"
                    >
                        Редактировать
                    </a>
                </div>

                <!-- КНОПКА УДАЛЕНИЯ АВАТАРА (если есть и свой профиль) -->
                <div v-if="isOwnProfile && hasAvatar" class="px-8 mt-4 flex gap-2">
                    <button
                        @click="deleteAvatar"
                        :disabled="deleting || uploading"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition disabled:opacity-50"
                    >
                        {{ deleting ? 'Удаление...' : '🗑️ Удалить фото' }}
                    </button>
                </div>

                <!-- СООБЩЕНИЯ ОБ ОШИБКЕ ЗАГРУЗКИ -->
                <div v-if="uploadError" class="mx-8 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 text-sm">{{ uploadError }}</p>
                </div>

                <!-- СООБЩЕНИЕ ОБ ОШИБКЕ УДАЛЕНИЯ -->
                <div v-if="deleteError" class="mx-8 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 text-sm">{{ deleteError }}</p>
                </div>

                <!-- СООБЩЕНИЕ ОБ УСПЕХЕ УДАЛЕНИЯ -->
                <div v-if="deleteSuccess" class="mx-8 mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 text-sm">{{ deleteSuccess }}</p>
                </div>

                <!-- СООБЩЕНИЕ ОБ УСПЕХЕ ЗАГРУЗКИ -->
                <div v-if="uploadSuccess" class="mx-8 mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 text-sm">{{ uploadSuccess }}</p>
                </div>

                <!-- Остальная информация профиля -->
                <div class="px-8 mt-6">
                    <p v-if="profile?.bio" class="text-gray-700 mb-4">{{ profile.bio }}</p>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-6">
                        <span v-if="profile?.website" class="flex items-center gap-1">
                            🔗 <a :href="profile.website" target="_blank" class="text-blue-500 hover:underline">
                                {{ profile.website }}
                            </a>
                        </span>
                        <span v-if="profile?.birthdate" class="flex items-center gap-1">
                            🎂 {{ profile.birthdate }}
                        </span>
                        <span class="flex items-center gap-1">
                            📅 Присоединился {{ profile.created_at }}
                        </span>
                    </div>

                    <!-- Интересы -->
                    <div v-if="profile?.interests?.length" class="mb-6">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Интересы:</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="interest in profile.interests"
                                :key="interest"
                                class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
                            >
                                #{{ interest }}
                            </span>
                        </div>
                    </div>

                    <!-- Статистика -->
                    <div class="border-t pt-6 mt-6">
                        <div class="grid grid-cols-3 gap-6 text-center">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ profile.posts_count }}</div>
                                <div class="text-sm text-gray-600">Постов</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ profile.followers_count }}</div>
                                <div class="text-sm text-gray-600">Подписчиков</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ profile.following_count }}</div>
                                <div class="text-sm text-gray-600">Подписок</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layouts/AppLayout.vue'
import axios from 'axios'

const page = usePage()

const props = defineProps({
    user: Object,
    profile: Object,
    isOwnProfile: Boolean,
})

const avatarInput = ref(null)
const uploading = ref(false)
const uploadError = ref(null)
const uploadSuccess = ref(null)
const deleting = ref(false)
const deleteError = ref(null)
const deleteSuccess = ref(null)

// Текущий URL аватара (обновляется без перезагрузки страницы)
const currentAvatarUrl = ref(props.user.avatar_url)

// Проверить, есть ли загруженный аватар (не дефолтный)
const hasAvatar = computed(() => {
    return currentAvatarUrl.value && !currentAvatarUrl.value.startsWith('data:')
})

/**
 * ЗАГРУЗИТЬ АВАТАР
 * Асинхронная загрузка с обновлением UI без перезагрузки страницы
 */
const uploadAvatar = async (event) => {
    const file = event.target.files?.[0]
    if (!file) return

    uploading.value = true
    uploadError.value = null
    uploadSuccess.value = null

    // Создаём FormData для отправки файла
    const formData = new FormData()
    formData.append('avatar', file)

    try {
        // POST запрос на /avatar
        const response = await axios.post('/avatar', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            }
        })

        // ✅ БЕЗ перезагрузки: обновляем URL аватара в памяти
        currentAvatarUrl.value = response.data.url
        uploadSuccess.value = response.data.message || 'Аватар успешно загружен!'

        // Очистить input
        if (avatarInput.value) {
            avatarInput.value.value = ''
        }

        // Скрыть сообщение через 3 секунды
        setTimeout(() => {
            uploadSuccess.value = null
        }, 3000)
    } catch (error) {
        uploadError.value = error.response?.data?.message || 'Ошибка при загрузке аватара'
        console.error('Upload error:', error)
    } finally {
        uploading.value = false
    }
}

/**
 * УДАЛИТЬ АВАТАР
 * Асинхронное удаление с обновлением UI без перезагрузки страницы
 */
const deleteAvatar = async () => {
    // Подтверждение
    if (!confirm('Вы уверены? Аватар будет удалён безвозвратно.')) {
        return
    }

    deleting.value = true
    deleteError.value = null
    deleteSuccess.value = null

    try {
        // DELETE запрос на /avatar
        const response = await axios.delete('/avatar')

        // ✅ БЕЗ перезагрузки: устанавливаем дефолтный аватар
        // Дефолтный SVG аватар (тот же что в модели)
        currentAvatarUrl.value = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Crect width="200" height="200" fill="%23E5E7EB"/%3E%3Ccircle cx="100" cy="70" r="30" fill="%23A3A3A3"/%3E%3Cpath d="M 50 180 Q 50 130 100 130 Q 150 130 150 180" fill="%23A3A3A3"/%3E%3C/svg%3E'

        deleteSuccess.value = response.data?.message || 'Аватар успешно удалён!'

        // Скрыть сообщение через 3 секунды
        setTimeout(() => {
            deleteSuccess.value = null
        }, 3000)
    } catch (error) {
        deleteError.value = error.response?.data?.message || 'Ошибка при удалении аватара'
        console.error('Delete error:', error)
    } finally {
        deleting.value = false
    }
}
</script>
