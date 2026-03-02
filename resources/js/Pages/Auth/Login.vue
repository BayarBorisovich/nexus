<template>
    <div class="min-vh-100 d-flex align-items-center justify-content-center px-3" style="position: relative; overflow: hidden;">
        <!-- Декоративный фон -->
        <div style="position: absolute; inset: 0; overflow: hidden; pointer-events: none;">
            <div style="position: absolute; top: -128px; right: -128px; width: 256px; height: 256px; background: rgba(79, 110, 247, 0.08); border-radius: 50%; filter: blur(64px);"></div>
            <div style="position: absolute; bottom: -128px; left: -128px; width: 256px; height: 256px; background: rgba(124, 58, 237, 0.08); border-radius: 50%; filter: blur(64px);"></div>
        </div>

        <div style="width: 100%; max-width: 28rem; position: relative; z-index: 10;">
            <!-- Логотип и заголовок -->
            <div class="text-center mb-5">
                <Link href="/" class="d-inline-flex align-items-center gap-2 justify-content-center mb-3 text-decoration-none">
                    <div class="rounded-2 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #4f6ef7, #7c3aed); box-shadow: 0 4px 16px rgba(79, 110, 247, 0.35); width: 48px; height: 48px;">
                        <i class="bi bi-lightning-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                </Link>
                <h1 class="h2 fw-bold mb-2" style="color: #1a1f36;">Вход</h1>
                <p style="color: #6b7280;">Добро пожаловать в Nexus</p>
            </div>

            <!-- Карточка формы -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <!-- Ошибка -->
                    <div v-if="hasErrors" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Неверный email или пароль
                        <button type="button" class="btn-close" @click="hasErrors = false" aria-label="Close"></button>
                    </div>

                    <form @submit.prevent="submit">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email адрес</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope" style="color: #4f6ef7;"></i>
                                </span>
                                <input
                                    v-model="form.email"
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    placeholder="your@email.com"
                                    autocomplete="username"
                                    @input="clearError('email')"
                                />
                                <span v-if="form.email && !errors.email" class="input-group-text" style="color: #10b981;">
                                    <i class="bi bi-check-circle"></i>
                                </span>
                            </div>
                            <small v-if="errors.email" class="d-block text-danger mt-1">{{ errors.email }}</small>
                        </div>

                        <!-- Пароль -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock" style="color: #4f6ef7;"></i>
                                </span>
                                <input
                                    v-model="form.password"
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    class="form-control"
                                    placeholder="Ваш пароль"
                                    autocomplete="current-password"
                                    @input="clearError('password')"
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="btn btn-outline-secondary"
                                    style="border-color: #e2e6f0; background: #f8f9fc; color: #6b7280;"
                                >
                                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                </button>
                            </div>
                            <small v-if="errors.password" class="d-block text-danger mt-1">{{ errors.password }}</small>
                        </div>

                        <!-- Запомнить меня -->
                        <div class="mb-3 form-check">
                            <input v-model="form.remember" type="checkbox" id="remember" class="form-check-input" />
                            <label class="form-check-label" for="remember" style="color: #1a1f36;">Запомнить меня</label>
                        </div>

                        <!-- Кнопка входа -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2"
                        >
                            <i v-if="form.processing" class="bi bi-hourglass-split spinner"></i>
                            <i v-else class="bi bi-box-arrow-in-right"></i>
                            {{ form.processing ? 'Вход...' : 'Войти' }}
                        </button>
                    </form>

                    <!-- Восстановление пароля -->
                    <div class="mt-4 pt-4 border-top">
                        <a href="#" class="text-primary text-decoration-none small d-flex align-items-center gap-2">
                            <i class="bi bi-question-circle"></i>
                            Забыли пароль?
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ссылка на регистрацию -->
            <div class="text-center">
                <p class="small" style="color: #6b7280;">
                    Нет аккаунта?
                    <Link href="/register" class="text-primary text-decoration-none fw-semibold">Зарегистрироваться</Link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const showPassword = ref(false)
const errors = ref({})
const hasErrors = computed(() => Object.keys(errors.value).length > 0)

const clearError = (field) => {
    delete errors.value[field]
}

const submit = () => {
    errors.value = {}
    form.post('/login', {
        onSuccess: () => console.log('Успешный вход'),
        onError: (errorsResponse) => { errors.value = errorsResponse }
    })
}
</script>

<style scoped>
.input-group-text {
    background: #f8f9fc !important;
    border: 1px solid #e2e6f0 !important;
    color: #6b7280 !important;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
.alert { animation: shake 0.5s; }

.spinner { animation: spin 1s linear infinite; }
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
