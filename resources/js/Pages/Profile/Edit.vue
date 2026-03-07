<template>
    <AppLayout>
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="display-6 fw-bold text-white mb-0">
                        <i class="bi bi-pencil-square text-info me-2"></i>
                        Редактирование профиля
                    </h1>
                </div>
            </div>

            <div class="row g-4">
                <!-- Форма редактирования -->
                <div class="col-12 col-lg-8">
                    <form @submit.prevent="submit" class="card">
                        <div class="card-body p-4">
                            <!-- Сообщения об успехе -->
                            <div v-if="successMessage" class="alert alert-success mb-4" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ successMessage }}
                            </div>

                            <!-- Основная информация -->
                            <div class="mb-5">
                                <h5 class="text-white fw-bold mb-4 pb-3 border-bottom border-secondary">
                                    Основная информация
                                </h5>

                                <!-- Имя -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Полное имя</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        id="name"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.name }"
                                        placeholder="Ваше имя"
                                    />
                                    <div v-if="form.errors.name" class="invalid-feedback d-block">
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Никнейм -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Никнейм</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark text-secondary border-secondary">@</span>
                                        <input
                                            v-model="form.username"
                                            type="text"
                                            id="username"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.username }"
                                            placeholder="username"
                                        />
                                    </div>
                                    <div v-if="form.errors.username" class="invalid-feedback d-block">
                                        {{ form.errors.username }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email адрес</label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        id="email"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.email }"
                                        placeholder="your@email.com"
                                    />
                                    <div v-if="form.errors.email" class="invalid-feedback d-block">
                                        {{ form.errors.email }}
                                    </div>
                                </div>
                            </div>

                            <!-- Описание профиля -->
                            <div class="mb-5">
                                <h5 class="text-white fw-bold mb-4 pb-3 border-bottom border-secondary">
                                    Описание
                                </h5>

                                <!-- Bio -->
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Описание профиля</label>
                                    <textarea
                                        v-model="form.bio"
                                        id="bio"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.bio }"
                                        rows="4"
                                        placeholder="Расскажите о себе..."
                                    ></textarea>
                                    <small class="text-secondary d-block mt-2">
                                        {{ form.bio?.length || 0 }} / 500 символов
                                    </small>
                                    <div v-if="form.errors.bio" class="invalid-feedback d-block">
                                        {{ form.errors.bio }}
                                    </div>
                                </div>
                            </div>

                            <!-- Интересы -->
                            <div class="mb-5">
                                <h5 class="text-white fw-bold mb-4 pb-3 border-bottom border-secondary">
                                    Интересы
                                </h5>

                                <div class="mb-3">
                                    <label for="interests" class="form-label">Интересы (через запятую)</label>
                                    <input
                                        v-model="form.interests"
                                        type="text"
                                        id="interests"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.interests }"
                                        placeholder="Программирование, Дизайн, Путешествия"
                                    />
                                    <small class="text-secondary d-block mt-2">
                                        Введите интересы через запятую
                                    </small>
                                    <div v-if="form.errors.interests" class="invalid-feedback d-block">
                                        {{ form.errors.interests }}
                                    </div>
                                </div>

                                <!-- Предпросмотр интересов -->
                                <div v-if="form.interests" class="d-flex gap-2 flex-wrap">
                                    <span
                                        v-for="(interest, index) in form.interests.split(',')"
                                        :key="index"
                                        class="badge badge-secondary-custom"
                                    >
                                        {{ interest.trim() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Социальные сети -->
                            <div class="mb-5">
                                <h5 class="text-white fw-bold mb-4 pb-3 border-bottom border-secondary">
                                    Социальные сети
                                </h5>

                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <label for="twitter" class="form-label">
                                            <i class="bi bi-twitter text-info me-2"></i>
                                            Twitter
                                        </label>
                                        <input
                                            v-model="form.twitter"
                                            type="url"
                                            id="twitter"
                                            class="form-control"
                                            placeholder="https://twitter.com/..."
                                        />
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <label for="github" class="form-label">
                                            <i class="bi bi-github text-light me-2"></i>
                                            GitHub
                                        </label>
                                        <input
                                            v-model="form.github"
                                            type="url"
                                            id="github"
                                            class="form-control"
                                            placeholder="https://github.com/..."
                                        />
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <label for="linkedin" class="form-label">
                                            <i class="bi bi-linkedin text-primary me-2"></i>
                                            LinkedIn
                                        </label>
                                        <input
                                            v-model="form.linkedin"
                                            type="url"
                                            id="linkedin"
                                            class="form-control"
                                            placeholder="https://linkedin.com/in/..."
                                        />
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <label for="website" class="form-label">
                                            <i class="bi bi-globe text-warning me-2"></i>
                                            Сайт
                                        </label>
                                        <input
                                            v-model="form.website"
                                            type="url"
                                            id="website"
                                            class="form-control"
                                            placeholder="https://..."
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки действий -->
                            <div class="d-flex gap-2 pt-4 border-top border-secondary">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="form.processing"
                                >
                                    <span v-if="!form.processing">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Сохранить изменения
                                    </span>
                                    <span v-else>
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Сохранение...
                                    </span>
                                </button>

                                <Link
                                    :href="`/profile/${props.user?.username || props.user?.id}`"
                                    class="btn btn-outline-light"
                                >
                                    <i class="bi bi-x-circle me-2"></i>
                                    Отмена
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Аватар и другая информация -->
                <div class="col-12 col-lg-4">
                    <!-- Загрузка аватара -->
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <h5 class="card-title text-white mb-4">Фото профиля</h5>

                            <!-- Текущий аватар -->
                            <img
                                :src="form.avatar_preview || auth.user.avatar_url"
                                :alt="props.user?.name"
                                class="avatar avatar-lg mb-4"
                            />

                            <!-- Загрузка нового аватара -->
                            <div class="mb-3">
                                <input
                                    type="file"
                                    id="avatar"
                                    class="form-control d-none"
                                    accept="image/jpeg,image/png,image/webp"
                                    @change="onAvatarChange"
                                />
                                <label for="avatar" class="btn btn-secondary w-100">
                                    <i class="bi bi-image me-2"></i>
                                    Выбрать фото
                                </label>
                            </div>

                            <!-- Кнопка удаления аватара — показывается только если аватар есть и не выбран новый -->
                            <div v-if="hasExistingAvatar && !form.avatar_preview" class="mb-3">
                                <button
                                    type="button"
                                    class="btn btn-outline-danger w-100"
                                    :disabled="deleteAvatarProcessing"
                                    @click="confirmDeleteAvatar"
                                >
                                    <span v-if="!deleteAvatarProcessing">
                                        <i class="bi bi-trash me-2"></i>
                                        Удалить фото
                                    </span>
                                    <span v-else>
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Удаление...
                                    </span>
                                </button>
                            </div>

                            <!-- Если выбран новый аватар — показать кнопку отмены выбора -->
                            <div v-if="form.avatar_preview" class="mb-3">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary w-100"
                                    @click="cancelAvatarSelection"
                                >
                                    <i class="bi bi-x-circle me-2"></i>
                                    Отменить выбор
                                </button>
                            </div>

                            <p class="text-secondary small mb-0">
                                Максимум 5MB, PNG, JPG или WEBP
                            </p>

                            <!-- Ошибка валидации аватара -->
                            <div v-if="form.errors.avatar" class="invalid-feedback d-block mt-2">
                                {{ form.errors.avatar }}
                            </div>
                        </div>

                        <!-- Информация профиля -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-white mb-3">Статистика</h5>

                                <div class="row g-3 text-center">
                                    <div class="col-12">
                                        <small class="text-secondary d-block">Дата присоединения</small>
                                        <span class="text-white fw-bold">{{ formatDate(auth.user.created_at) }}</span>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-secondary d-block">Последнее обновление</small>
                                        <span class="text-white fw-bold">{{ formatDate(auth.user.updated_at) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm, Link, usePage, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    user: Object,
    profile: Object,
})

const page = usePage()
const auth = page.props.auth
const successMessage = ref('')
const deleteAvatarProcessing = ref(false)

// social_links хранится как массив [{platform, url}, ...]
// Преобразуем в удобный вид для формы
const getSocialLink = (platform) => {
    const links = props.profile?.social_links ?? []
    return links.find(l => l.platform === platform)?.url || ''
}

const form = useForm({
    name:           props.user?.name || '',
    email:          props.user?.email || '',
    username:       props.user?.username || '',
    bio:            props.profile?.bio || '',
    interests:      props.profile?.interests?.join(', ') || '',
    twitter:        getSocialLink('twitter'),
    github:         getSocialLink('github'),
    linkedin:       getSocialLink('linkedin'),
    website:        props.profile?.website || '',
    avatar:         null,
    avatar_preview: null,
})

// Есть ли сохранённый аватар на сервере
const hasExistingAvatar = computed(() => !!auth.user.avatar_url)

const onAvatarChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.avatar = file
        const reader = new FileReader()
        reader.onload = (e) => {
            form.avatar_preview = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

// Отменить выбор нового файла — вернуть текущий аватар
const cancelAvatarSelection = () => {
    form.avatar = null
    form.avatar_preview = null
    // Сбросить input[type=file] чтобы можно было выбрать тот же файл снова
    const input = document.getElementById('avatar')
    if (input) input.value = ''
}

// Подтверждение перед удалением
const confirmDeleteAvatar = () => {
    if (!confirm('Вы уверены, что хотите удалить фото профиля?')) return
    deleteAvatar()
}

// Отправить DELETE-запрос на сервер
const deleteAvatar = () => {
    deleteAvatarProcessing.value = true

    router.delete('/profile/avatar', {
        onSuccess: () => {
            successMessage.value = 'Фото профиля удалено!'
            setTimeout(() => { successMessage.value = '' }, 3000)
        },
        onFinish: () => {
            deleteAvatarProcessing.value = false
        },
    })
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const submit = () => {
    const interests = form.interests
        ? form.interests.split(',').map(i => i.trim()).filter(Boolean)
        : []

    const social_links = []
    if (form.twitter)  social_links.push({ platform: 'twitter',  url: form.twitter })
    if (form.github)   social_links.push({ platform: 'github',   url: form.github })
    if (form.linkedin) social_links.push({ platform: 'linkedin', url: form.linkedin })

    form.transform(data => ({
        ...data,
        interests,
        social_links,
    })).post('/profile', {
        onSuccess: () => {
            successMessage.value = 'Профиль успешно обновлен!'
            setTimeout(() => { successMessage.value = '' }, 3000)
        }
    })
}
</script>

<style scoped>
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.2em;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
}
</style>
