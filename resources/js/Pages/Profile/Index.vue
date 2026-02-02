<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-10 px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Заголовок -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Профиль</h1>
                <p class="text-gray-600 mt-2">Управляйте своей личной информацией</p>
            </div>

            <!-- Сообщения об успехе -->
            <div v-if="$page.props.flash?.success" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-fade-in">
                <div class="flex items-center">
                    <svg style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;" class="text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700 text-sm font-medium">{{ $page.props.flash.success }}</p>
                </div>
            </div>

            <!-- Карточка профиля и аватара -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8 mb-6">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Секция аватара -->
                    <div class="flex flex-col items-center lg:w-64 flex-shrink-0">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Фото профиля</h2>

                        <!-- Превью аватара с фиксированным размером -->
                        <div class="relative w-40 h-40 flex-shrink-0 mb-4">
                            <img
                                :src="avatarPreviewUrl"
                                alt="Avatar"
                                class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg"
                            />

                            <!-- Индикатор загрузки -->
                            <div v-if="avatarForm.processing" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full">
                                <svg style="width: 2rem; height: 2rem;" class="animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Кнопки управления аватаром -->
                        <div class="flex flex-col gap-2 w-full max-w-xs">
                            <label class="cursor-pointer">
                                <span class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-[1.02]">
                                    <svg style="width: 1.1rem; height: 1.1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ avatarForm.avatar ? 'Изменить' : 'Выбрать фото' }}
                                </span>
                                <input
                                    type="file"
                                    @change="handleAvatarSelect"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                    class="hidden"
                                    :disabled="avatarForm.processing"
                                />
                            </label>

                            <!-- Кнопка загрузки -->
                            <button
                                v-if="avatarForm.avatar"
                                @click="uploadAvatar"
                                type="button"
                                :disabled="avatarForm.processing"
                                class="w-full px-4 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ avatarForm.processing ? 'Загрузка...' : 'Загрузить' }}
                            </button>

                            <!-- Кнопка удаления -->
                            <button
                                v-if="profile?.avatar_url && !avatarForm.avatar"
                                @click="deleteAvatar"
                                type="button"
                                :disabled="deleteAvatarForm.processing"
                                class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ deleteAvatarForm.processing ? 'Удаление...' : 'Удалить' }}
                            </button>
                        </div>

                        <p class="text-xs text-gray-500 mt-3 text-center">
                            JPG, PNG, GIF, WebP<br>Максимум 1MB
                        </p>

                        <!-- Ошибки валидации -->
                        <div v-if="avatarForm.errors.avatar" class="mt-3 p-2 bg-red-50 rounded-lg">
                            <p class="text-red-600 text-xs text-center">{{ avatarForm.errors.avatar }}</p>
                        </div>
                    </div>

                    <!-- Основная информация -->
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Основная информация</h2>
                        <div class="space-y-3">
                            <div class="info-card">
                                <svg style="width: 1.1rem; height: 1.1rem;" class="text-indigo-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Имя</p>
                                    <p class="font-medium text-gray-900 truncate">{{ user.name }}</p>
                                </div>
                            </div>
                            <div class="info-card">
                                <svg style="width: 1.1rem; height: 1.1rem;" class="text-purple-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Никнейм</p>
                                    <p class="font-medium text-gray-900 truncate">{{ user.username }}</p>
                                </div>
                            </div>
                            <div class="info-card">
                                <svg style="width: 1.1rem; height: 1.1rem;" class="text-pink-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500 mb-0.5">Email</p>
                                    <p class="font-medium text-gray-900 truncate">{{ user.email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Форма дополнительной информации -->
            <form @submit.prevent="submit" class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Дополнительная информация</h2>

                <div class="space-y-6">
                    <!-- О себе -->
                    <div class="form-group">
                        <label class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            О себе
                        </label>
                        <textarea
                            v-model="form.bio"
                            class="form-input resize-none"
                            rows="4"
                            placeholder="Расскажите немного о себе..."
                        ></textarea>
                        <p v-if="form.errors.bio" class="form-error">{{ form.errors.bio }}</p>
                    </div>

                    <!-- Два столбца для остальных полей -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Дата рождения -->
                        <div class="form-group">
                            <label class="form-label">
                                <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                Дата рождения
                            </label>
                            <input v-model="form.birthdate" type="date" class="form-input" />
                            <p v-if="form.errors.birthdate" class="form-error">{{ form.errors.birthdate }}</p>
                        </div>

                        <!-- Пол -->
                        <div class="form-group">
                            <label class="form-label">
                                <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Пол
                            </label>
                            <select v-model="form.gender" class="form-input">
                                <option value="">Не выбрано</option>
                                <option value="male">Мужской</option>
                                <option value="female">Женский</option>
                            </select>
                            <p v-if="form.errors.gender" class="form-error">{{ form.errors.gender }}</p>
                        </div>
                    </div>

                    <!-- Локация -->
                    <div class="form-group">
                        <label class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Местоположение
                        </label>
                        <input
                            v-model="form.location"
                            type="text"
                            class="form-input"
                            placeholder="Город, страна"
                        />
                        <p v-if="form.errors.location" class="form-error">{{ form.errors.location }}</p>
                    </div>

                    <!-- Телефон -->
                    <div class="form-group">
                        <label class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.418 1.265 1.215 2.807 2.016 3.57.801.764 2.206 1.495 3.487 1.495s2.686-.731 3.487-1.495c.801-.764 1.598-2.305 2.016-3.57l1.548-.773a1 1 0 01.54-1.06l-.74-4.435a1 1 0 01-.986-.836H5a1 1 0 01-1 1v2.051a7 7 0 013.192 5.816A7 7 0 015 6.051V3z"></path>
                            </svg>
                            Телефон
                        </label>
                        <input
                            v-model="form.phone"
                            type="tel"
                            class="form-input"
                            placeholder="+7 (999) 123-45-67"
                        />
                        <p v-if="form.errors.phone" class="form-error">{{ form.errors.phone }}</p>
                    </div>

                    <!-- Интересы -->
                    <div class="form-group">
                        <label class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Интересы
                        </label>
                        <input
                            :value="interestsInput"
                            @input="interestsInput = $event.target.value"
                            type="text"
                            class="form-input"
                            placeholder="Спорт, музыка, путешествия... (через запятую)"
                        />
                        <p v-if="form.errors.interests" class="form-error">{{ form.errors.interests }}</p>
                    </div>

                    <!-- Социальные сети -->
                    <div class="form-group">
                        <div class="flex items-center justify-between mb-3">
                            <label class="form-label m-0">
                                <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.375rem;" class="text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                                Социальные сети
                            </label>
                            <button
                                @click="addSocial"
                                type="button"
                                class="text-indigo-600 hover:text-indigo-700 text-sm font-semibold"
                            >
                                + Добавить
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div v-for="(social, index) in form.social_links" :key="index" class="flex gap-3">
                                <input
                                    v-model="social.platform"
                                    @change="formatSocialPlatform(index)"
                                    type="text"
                                    class="form-input"
                                    placeholder="Платформа (Instagram, Twitter...)"
                                />
                                <input
                                    v-model="social.url"
                                    type="url"
                                    class="form-input"
                                    placeholder="URL профиля"
                                />
                                <button
                                    @click="removeSocial(index)"
                                    type="button"
                                    class="px-3 py-2.5 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors flex-shrink-0"
                                >
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопка отправки -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed mt-6"
                    >
                        {{ form.processing ? 'Сохранение...' : 'Сохранить профиль' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

const props = defineProps({
    user: Object,
    profile: Object,
})

const form = useForm({
    bio: props.profile?.bio || '',
    birthdate: props.profile?.birthdate || '',
    location: props.profile?.location || '',
    phone: props.profile?.phone || '',
    gender: props.profile?.gender || null,
    social_links: props.profile?.social_links || [],
    interests: props.profile?.interests || [],
})

const avatarForm = ref({
    avatar: null,
    processing: false,
    errors: { avatar: '' }
})

const deleteAvatarForm = ref({
    processing: false
})

const profile = computed(() => usePage().props.profile)

const avatarPreviewUrl = computed(() => {
    if (avatarForm.value.avatar) {
        return URL.createObjectURL(avatarForm.value.avatar)
    }
    // Используем встроенный SVG вместо внешнего файла
    if (!profile.value?.avatar_url) {
        return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Crect width="200" height="200" fill="%23E5E7EB"/%3E%3Ccircle cx="100" cy="70" r="30" fill="%23A3A3A3"/%3E%3Cpath d="M 50 180 Q 50 130 100 130 Q 150 130 150 180" fill="%23A3A3A3"/%3E%3C/svg%3E'
    }
    return profile.value?.avatar_url
})

/**
 * Обработка выбора файла аватара
 */
const handleAvatarSelect = (event) => {
    const file = event.target.files?.[0]
    if (!file) return

    // Валидация размера
    const maxSize = 2048 * 1024 // 2MB
    if (file.size > maxSize) {
        avatarForm.value.errors.avatar = 'Файл больше 2MB'
        return
    }

    // Валидация типа
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
    if (!validTypes.includes(file.type)) {
        avatarForm.value.errors.avatar = 'Недопустимый формат файла'
        return
    }

    avatarForm.value.avatar = file
    avatarForm.value.errors.avatar = ''
}

/**
 * Загрузка аватара через fetch с правильной обработкой JSON
 */
const uploadAvatar = async () => {
    if (!avatarForm.value.avatar) {
        alert('Выберите файл')
        return
    }

    try {
        avatarForm.value.processing = true

        const formData = new FormData()
        formData.append('avatar', avatarForm.value.avatar)

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content

        const response = await fetch('/profile/avatar/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
            credentials: 'same-origin',
        })

        const data = await response.json()

        if (response.ok && data.success) {
            // Очищаем форму
            avatarForm.value.avatar = null
            avatarForm.value.errors.avatar = ''

            // Обновляем страницу для получения новых данных профиля
            window.location.reload()
        } else {
            console.error('Ошибка ответа:', data)
            alert('Ошибка при загрузке файла')
        }
    } catch (error) {
        console.error('Ошибка сети:', error)
        alert('Ошибка при загрузке файла. Проверьте консоль.')
    } finally {
        avatarForm.value.processing = false
    }
}

/**
 * Удаление аватара через fetch с правильной обработкой
 */
const deleteAvatar = async () => {
    if (!confirm('Вы уверены, что хотите удалить фото профиля?')) return

    try {
        deleteAvatarForm.value.processing = true

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content

        const response = await fetch('/profile/avatar', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        })

        const data = await response.json()

        if (response.ok && data.success) {
            // Обновляем страницу для получения новых данных профиля
            window.location.reload()
        } else {
            console.error('Ошибка удаления:', data)
            alert('Ошибка удаления аватара')
        }
    } catch (error) {
        console.error('Ошибка сети:', error)
        alert('Ошибка при удалении файла')
    } finally {
        deleteAvatarForm.value.processing = false
    }
}

/**
 * Интересы — через строку
 */
const interestsInput = computed({
    get: () => form.interests.join(', '),
    set: value => {
        form.interests = value
            .split(',')
            .map(i => i.trim())
            .filter(Boolean)
    }
})

/**
 * Добавить поле соцсети
 */
const addSocial = () => {
    form.social_links.push({ platform: '', url: '' })
}

/**
 * Удалить поле соцсети
 */
const removeSocial = index => {
    form.social_links.splice(index, 1)
}

/**
 * Форматирование названия платформы
 */
const formatSocialPlatform = (index) => {
    const platform = form.social_links[index].platform
    if (platform) {
        form.social_links[index].platform = platform.toLowerCase().trim()
    }
}

/**
 * Отправка формы профиля через Inertia
 */
const submit = () => {
    form.post('/profile/update', {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Профиль успешно обновлен')
        },
        onError: (errors) => {
            console.error('Ошибки сохранения профиля:', errors)
        }
    })
}

/**
 * Следим за обновлениями профиля из ответов сервера
 */
watch(() => usePage().props.profile, (newProfile) => {
    if (newProfile) {
        form.bio = newProfile.bio ?? ''
        form.birthdate = newProfile.birthdate ?? ''
        form.location = newProfile.location ?? ''
        form.phone = newProfile.phone ?? ''
        form.gender = newProfile.gender ?? null
        form.social_links = newProfile.social_links ?? []
        form.interests = newProfile.interests ?? []
    }
}, { deep: true })
</script>

<style scoped>
/* Карточки с информацией */
.info-card {
    @apply flex items-center gap-3 p-3.5 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-gray-200 transition-colors;
}

/* Группа формы */
.form-group {
    @apply space-y-2;
}

/* Label формы */
.form-label {
    @apply block text-sm font-semibold text-gray-700;
}

/* Input формы */
.form-input {
    @apply w-full px-4 py-2.5 border border-gray-300 rounded-xl
    bg-white text-gray-900 placeholder-gray-400 text-sm
    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
    transition-all duration-200
    hover:border-gray-400;
}

/* Ошибки формы */
.form-error {
    @apply text-red-600 text-xs mt-1.5;
}

.form-error::before {
    content: '⚠ ';
}

/* Анимации */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
