<template>
    <div class="min-vh-100" style="position: relative; overflow: hidden;">
        <!-- Декоративный фон -->
        <div style="position: absolute; inset: 0; overflow: hidden; pointer-events: none;">
            <div style="position: absolute; top: -128px; right: -128px; width: 256px; height: 256px; background: rgba(79, 110, 247, 0.08); border-radius: 50%; filter: blur(64px);"></div>
            <div style="position: absolute; bottom: -128px; left: -128px; width: 256px; height: 256px; background: rgba(124, 58, 237, 0.08); border-radius: 50%; filter: blur(64px);"></div>
        </div>

        <!-- Главное содержимое -->
        <div style="position: relative; z-index: 10; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
            <div style="width: 100%; max-width: 40rem;">
                <!-- Иконка успеха -->
                <div class="text-center mb-4 animate-slide-in">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);">
                        <i class="bi bi-check text-white" style="font-size: 1.6rem;"></i>
                    </div>
                </div>

                <!-- Приветствие -->
                <div class="text-center mb-4 animate-slide-in">
                    <h1 class="h1 mb-3" style="color: #1a1f36;">
                        Добро пожаловать,
                        <span class="gradient-text">{{ user.name }}</span>! 🎉
                    </h1>
                    <p class="h5" style="color: #6b7280;">Вы успешно вошли в Nexus</p>
                </div>

                <!-- Информация профиля -->
                <div class="card mb-4 animate-slide-in">
                    <div class="card-body">
                        <!-- Никнейм -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-3" style="background: #f8f9fc; border: 1px solid #e2e6f0;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle" style="color: #4f6ef7;"></i>
                                <span style="color: #6b7280;">Никнейм:</span>
                            </div>
                            <span class="fw-semibold" style="color: #1a1f36;">@{{ user.username }}</span>
                        </div>

                        <!-- Email -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-3" style="background: #f8f9fc; border: 1px solid #e2e6f0;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-envelope" style="color: #4f6ef7;"></i>
                                <span style="color: #6b7280;">Email:</span>
                            </div>
                            <span class="fw-semibold" style="color: #1a1f36;">{{ user.email }}</span>
                        </div>

                        <!-- Статус -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: #f8f9fc; border: 1px solid #e2e6f0;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle text-success"></i>
                                <span style="color: #6b7280;">Статус:</span>
                            </div>
                            <span class="badge bg-success">Активен ✓</span>
                        </div>
                    </div>
                </div>

                <!-- Следующие шаги -->
                <div class="card mb-4 animate-slide-in" style="border-left: 4px solid #4f6ef7 !important;">
                    <div class="card-body">
                        <h2 class="h4 mb-3 d-flex align-items-center gap-2" style="color: #1a1f36;">
                            <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                            Что дальше?
                        </h2>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex gap-2 p-2 rounded-3 mb-2 step-item">
                                <i class="bi bi-check-circle flex-shrink-0" style="color: #4f6ef7;"></i>
                                <span style="color: #6b7280;">Заполните информацию в профиле — расскажите о себе, добавьте интересы</span>
                            </li>
                            <li class="d-flex gap-2 p-2 rounded-3 mb-2 step-item">
                                <i class="bi bi-check-circle flex-shrink-0" style="color: #7c3aed;"></i>
                                <span style="color: #6b7280;">Добавьте красивое фото профиля — первое впечатление важно</span>
                            </li>
                            <li class="d-flex gap-2 p-2 rounded-3 mb-2 step-item">
                                <i class="bi bi-check-circle flex-shrink-0" style="color: #10b981;"></i>
                                <span style="color: #6b7280;">Свяжите свои социальные сети — расширьте свой профиль</span>
                            </li>
                            <li class="d-flex gap-2 p-2 rounded-3 step-item">
                                <i class="bi bi-check-circle flex-shrink-0" style="color: #ec4899;"></i>
                                <span style="color: #6b7280;">Начните взаимодействовать с сообществом — найдите единомышленников</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="row g-2 mb-4 animate-slide-in">
                    <div class="col-12 col-sm-6">
                        <Link
                            :href="`/profile/${user.id}`"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2"
                        >
                            <i class="bi bi-person"></i>
                            <span>Мой профиль</span>
                        </Link>
                    </div>
                    <div class="col-12 col-sm-6">
                        <button
                            @click="logout"
                            class="btn w-100 d-flex align-items-center justify-content-center gap-2"
                            style="background: white; border: 1px solid #e2e6f0; color: #1a1f36;"
                        >
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Выход</span>
                        </button>
                    </div>
                </div>

                <!-- Доп. текст -->
                <div class="text-center small" style="color: #6b7280;">
                    <p class="mb-1">Спасибо за регистрацию в Nexus!</p>
                    <p class="mb-0">Если у вас есть вопросы, посетите нашу справку или свяжитесь с поддержкой</p>
                </div>
            </div>
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
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slide-in { animation: slideUp 0.5s ease-out forwards; }
.animate-slide-in:nth-child(2) { animation-delay: 0.1s; }
.animate-slide-in:nth-child(3) { animation-delay: 0.2s; }
.animate-slide-in:nth-child(4) { animation-delay: 0.3s; }
.animate-slide-in:nth-child(5) { animation-delay: 0.4s; }

.step-item:hover {
    background: #f0f2f7 !important;
}
</style>
