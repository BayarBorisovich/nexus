<template>
    <AppLayout>
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="display-6 fw-bold text-white mb-0">
                            <i class="bi bi-person-circle text-info me-2"></i>
                            Профиль пользователя
                        </h1>
                        <div class="d-flex gap-2">
                            <Link
                                v-if="canEdit"
                                :href="`/profile/edit`"
                                class="btn btn-secondary"
                            >
                                <i class="bi bi-pencil"></i>
                                <span class="d-none d-sm-inline">Редактировать</span>
                            </Link>
                            <button
                                v-if="canDelete"
                                @click="deleteUser"
                                class="btn btn-danger"
                                :disabled="form.processing"
                            >
                                <i class="bi bi-trash"></i>
                                <span class="d-none d-sm-inline">Удалить</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Основная информация -->
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Аватар -->
                            <div class="mb-4">
                                <img
                                    :src="props.user.avatar_url"
                                    :alt="props.user.name"
                                    class="avatar avatar-xl"
                                />
                            </div>

                            <!-- Имя -->
                            <h2 class="fs-4 fw-bold text-white mb-2">{{ props.user.name }}</h2>

                            <!-- Никнейм -->
                            <p class="text-secondary mb-4">@{{ props.user.username }}</p>

                            <!-- Статус -->
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <span class="badge badge-success-custom">
                                    <i class="bi bi-check-circle"></i>
                                    Активен
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Информация профиля -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title text-white mb-3">Информация</h5>

                            <div class="row g-3">
                                <div class="col-12">
                                    <small class="text-secondary d-block">Email</small>
                                    <span class="text-white">{{ props.user.email }}</span>
                                </div>
                                <div class="col-12">
                                    <small class="text-secondary d-block">Дата присоединения</small>
                                    <span class="text-white">{{ formatDate(props.profile?.created_at) }}</span>
                                </div>
                                <div v-if="props.profile?.location" class="col-12">
                                    <small class="text-secondary d-block">Местоположение</small>
                                    <span class="text-white">{{ props.profile.location }}</span>
                                </div>
                                <div v-if="props.profile?.website" class="col-12">
                                    <small class="text-secondary d-block">Сайт</small>
                                    <a :href="props.profile.website" target="_blank" rel="noopener" class="text-info">
                                        {{ props.profile.website }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Дополнительная информация -->
                <div class="col-12 col-lg-8">
                    <!-- Описание профиля -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-white mb-3">Описание профиля</h5>
                            <p v-if="props.profile?.bio" class="text-secondary mb-0">{{ props.profile.bio }}</p>
                            <p v-else class="text-secondary mb-0">
                                <em>Описание не указано</em>
                            </p>
                        </div>
                    </div>

                    <!-- Интересы -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-white mb-3">
                                <i class="bi bi-star-fill text-warning me-2"></i>
                                Интересы
                            </h5>
                            <div v-if="props.profile?.interests && props.profile.interests.length > 0" class="d-flex gap-2 flex-wrap">
                                <span
                                    v-for="interest in props.profile.interests"
                                    :key="interest"
                                    class="badge badge-secondary-custom"
                                >
                                    {{ interest }}
                                </span>
                            </div>
                            <p v-else class="text-secondary mb-0">
                                <em>Интересы не указаны</em>
                            </p>
                        </div>
                    </div>

                    <!-- Социальные сети -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-white mb-3">
                                <i class="bi bi-share text-info me-2"></i>
                                Социальные сети
                            </h5>
                            <!-- social_links — массив объектов [{platform, url}] -->
                            <div v-if="props.profile?.social_links && props.profile.social_links.length > 0" class="row g-3">
                                <div
                                    v-for="link in props.profile.social_links"
                                    :key="link.platform"
                                    class="col-12 col-sm-6"
                                >
                                    <a
                                        :href="link.url"
                                        target="_blank"
                                        rel="noopener"
                                        class="btn btn-outline-light w-100 text-capitalize"
                                    >
                                        <i :class="`bi bi-${getSocialIcon(link.platform)} me-2`"></i>
                                        <span>{{ link.platform }}</span>
                                    </a>
                                </div>
                            </div>
                            <p v-else class="text-secondary mb-0">
                                <em>Социальные сети не добавлены</em>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { usePage, useForm, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    user: Object,
    profile: Object,
    isOwnProfile: Boolean,
})

const page = usePage()

const canEdit = computed(() => props.isOwnProfile)
const canDelete = computed(() => props.isOwnProfile)

const form = useForm({})

const formatDate = (date) => {
    if (!date) return 'Не указано'
    const d = new Date(date)
    if (isNaN(d)) return 'Не указано'
    return d.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const getSocialIcon = (platform) => {
    const icons = {
        twitter: 'twitter-x',
        github: 'github',
        linkedin: 'linkedin',
        instagram: 'instagram',
        facebook: 'facebook',
        youtube: 'youtube',
        telegram: 'telegram',
    }
    return icons[platform] || 'link-45deg'
}

const deleteUser = () => {
    if (confirm('Вы уверены? Это действие невозможно отменить.')) {
        router.delete(`/profile/${props.user.id}`)
    }
}
</script>

<style scoped>
.min-vh-100 {
    min-height: 100vh;
}
</style>
