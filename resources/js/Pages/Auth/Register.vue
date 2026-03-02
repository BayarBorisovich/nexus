<template>
    <div class="min-vh-100 d-flex align-items-center justify-content-center px-3" style="position: relative; overflow: hidden;">
        <!-- Декоративный фон -->
        <div style="position: absolute; inset: 0; overflow: hidden; pointer-events: none;">
            <div style="position: absolute; top: -128px; right: -128px; width: 256px; height: 256px; background: rgba(124, 58, 237, 0.08); border-radius: 50%; filter: blur(64px);"></div>
            <div style="position: absolute; bottom: -128px; left: -128px; width: 256px; height: 256px; background: rgba(236, 72, 153, 0.08); border-radius: 50%; filter: blur(64px);"></div>
        </div>

        <div style="width: 100%; max-width: 28rem; position: relative; z-index: 10; padding: 2rem 0;">
            <!-- Логотип и заголовок -->
            <div class="text-center mb-4">
                <Link href="/" class="d-inline-flex align-items-center gap-2 justify-content-center mb-3 text-decoration-none">
                    <div class="rounded-2 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #4f6ef7, #7c3aed); box-shadow: 0 4px 16px rgba(79, 110, 247, 0.35); width: 48px; height: 48px;">
                        <i class="bi bi-lightning-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                </Link>
                <h1 class="h2 fw-bold mb-2" style="color: #1a1f36;">Регистрация</h1>
                <p style="color: #6b7280;">Присоединитесь к нашему сообществу</p>
            </div>

            <!-- Карточка формы -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <!-- Ошибки -->
                    <div v-if="Object.keys(form.errors).length > 0" class="mb-3">
                        <div v-for="(message, field) in form.errors" :key="field" class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ message }}
                            <button type="button" class="btn-close" @click="delete form.errors[field]" aria-label="Close"></button>
                        </div>
                    </div>

                    <form @submit.prevent="submit">
                        <!-- Имя -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Полное имя</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person" style="color: #4f6ef7;"></i>
                                </span>
                                <input v-model="form.name" id="name" type="text" class="form-control" placeholder="Иван Петров" />
                            </div>
                        </div>

                        <!-- Никнейм -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Никнейм</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-at" style="color: #4f6ef7;"></i>
                                </span>
                                <input v-model="form.username" id="username" type="text" class="form-control" placeholder="ivan_petrov" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email адрес</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope" style="color: #4f6ef7;"></i>
                                </span>
                                <input v-model="form.email" id="email" type="email" class="form-control" placeholder="your@email.com" />
                            </div>
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
                                    placeholder="Минимум 8 символов"
                                />
                                <button type="button" @click="showPassword = !showPassword" class="btn btn-outline-secondary" style="border-color: #e2e6f0; background: #f8f9fc; color: #6b7280;">
                                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                </button>
                            </div>
                            <small class="d-block mt-1" style="color: #6b7280;">Минимум 8 символов, букв и цифр</small>
                        </div>

                        <!-- Подтверждение пароля -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock" style="color: #4f6ef7;"></i>
                                </span>
                                <input
                                    v-model="form.password_confirmation"
                                    id="password_confirmation"
                                    :type="showConfirmPassword ? 'text' : 'password'"
                                    class="form-control"
                                    placeholder="Повторите пароль"
                                />
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="btn btn-outline-secondary" style="border-color: #e2e6f0; background: #f8f9fc; color: #6b7280;">
                                    <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Согласие -->
                        <div class="mb-3 form-check">
                            <input v-model="form.agree" type="checkbox" id="agree" class="form-check-input" />
                            <label class="form-check-label" for="agree" style="color: #1a1f36;">
                                Я согласен(а) с
                                <a href="#" class="text-primary text-decoration-none">условиями использования</a>
                            </label>
                        </div>

                        <!-- Кнопка регистрации -->
                        <button type="submit" :disabled="form.processing" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                            <i v-if="form.processing" class="bi bi-hourglass-split spinner"></i>
                            <i v-else class="bi bi-person-plus"></i>
                            {{ form.processing ? 'Регистрация...' : 'Зарегистрироваться' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ссылка на вход -->
            <div class="text-center">
                <p class="small" style="color: #6b7280;">
                    Уже есть аккаунт?
                    <Link href="/login" class="text-primary text-decoration-none fw-semibold">Войти</Link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    agree: false,
})

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const submit = () => {
    form.post('/register', {
        onSuccess: () => console.log('Успешная регистрация'),
        onError: () => console.error('Ошибка регистрации')
    })
}
</script>

<style scoped>
.input-group-text {
    background: #f8f9fc !important;
    border: 1px solid #e2e6f0 !important;
    color: #6b7280 !important;
}

.spinner { animation: spin 1s linear infinite; }
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
