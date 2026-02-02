<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex items-center justify-center px-4 py-8">
        <!-- Декоративные элементы фона -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="w-full max-w-md mx-auto relative z-10">
            <!-- Логотип и заголовок -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl shadow-lg mb-4 transform hover:scale-105 transition-transform duration-300">
                    <svg style="width: 2.5rem; height: 2.5rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Создать аккаунт</h1>
                <p class="text-gray-600">Присоединяйтесь к нашему сообществу</p>
            </div>

            <!-- Карточка формы -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8 transform hover:shadow-2xl transition-shadow duration-300">

                <!-- Общая ошибка -->
                <div v-if="hasErrors" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-shake">
                    <div class="flex items-center">
                        <svg style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;" class="text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-700 text-sm font-medium">Пожалуйста, исправьте ошибки в форме</p>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Имя -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Имя
                        </label>
                        <div class="relative">
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Иван Иванов"
                                :class="['form-input', { 'border-red-500 focus:ring-red-500': errors.name }]"
                                @input="clearError('name')"
                            />
                            <div v-if="form.name && !errors.name" class="absolute right-3 top-3.5">
                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p v-if="errors.name" class="form-error">{{ errors.name }}</p>
                    </div>

                    <!-- Никнейм -->
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                            Никнейм
                        </label>
                        <div class="relative">
                            <input
                                id="username"
                                v-model="form.username"
                                type="text"
                                placeholder="ivanov_ivan"
                                :class="['form-input', { 'border-red-500 focus:ring-red-500': errors.username }]"
                                @input="clearError('username')"
                            />
                            <div v-if="form.username && !errors.username" class="absolute right-3 top-3.5">
                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p v-if="errors.username" class="form-error">{{ errors.username }}</p>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            Email
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="example@mail.com"
                                :class="['form-input', { 'border-red-500 focus:ring-red-500': errors.email }]"
                                @input="clearError('email')"
                            />
                            <div v-if="form.email && !errors.email" class="absolute right-3 top-3.5">
                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p v-if="errors.email" class="form-error">{{ errors.email }}</p>
                    </div>

                    <!-- Пароль -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Пароль
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                placeholder="Минимум 6 символов"
                                :class="['form-input pr-10', { 'border-red-500 focus:ring-red-500': errors.password }]"
                                @input="clearError('password')"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700 transition-colors"
                            >
                                <svg v-if="!showPassword" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg v-else style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p v-if="errors.password" class="form-error">{{ errors.password }}</p>
                    </div>

                    <!-- Подтверждение пароля -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Подтверждение пароля
                        </label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                :type="showPasswordConfirm ? 'text' : 'password'"
                                placeholder="Повторите пароль"
                                :class="['form-input pr-10', { 'border-red-500 focus:ring-red-500': errors.password_confirmation }]"
                            />
                            <button
                                type="button"
                                @click="showPasswordConfirm = !showPasswordConfirm"
                                class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700 transition-colors"
                            >
                                <svg v-if="!showPasswordConfirm" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg v-else style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p v-if="errors.password_confirmation" class="form-error">{{ errors.password_confirmation }}</p>
                    </div>

                    <!-- Кнопка отправки -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            :disabled="processing || !isFormValid"
                            :title="!isFormValid ? 'Заполните все обязательные поля' : 'Зарегистрироваться'"
                            :class="[
                                'w-full py-3.5 px-4 text-white font-semibold rounded-xl shadow-lg',
                                'focus:outline-none focus:ring-4 transition-all duration-200',
                                'flex items-center justify-center',
                                isFormValid && !processing
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] focus:ring-purple-500/50'
                                    : 'bg-gradient-to-r from-gray-400 to-gray-500 cursor-not-allowed opacity-80'
                            ]"
                        >
                            <svg v-if="processing" style="width: 1.25rem; height: 1.25rem; margin-left: -0.25rem; margin-right: 0.75rem;" class="animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg v-else-if="isFormValid" style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <svg v-else style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            {{ processing ? 'Регистрация...' : (isFormValid ? 'Зарегистрироваться' : 'Заполните форму') }}
                        </button>
                    </div>

                </form>

                <!-- Ссылка на вход -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Уже есть аккаунт?
                        <Link href="/login" class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline transition-colors ml-1">
                            Войти
                        </Link>
                    </p>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const processing = ref(false);
const showPassword = ref(false);
const showPasswordConfirm = ref(false);

// Ошибки только с сервера
const errors = computed(() => form.errors);
const hasErrors = computed(() => Object.keys(errors.value).length > 0);

// Минимальная проверка: все обязательные поля заполнены
const isFormValid = computed(() => {
    return form.name.trim() !== '' &&
        form.username.trim() !== '' &&
        form.email.trim() !== '' &&
        form.password !== '' &&
        form.password_confirmation !== '';
});

const clearError = (field) => {
    if (errors.value[field]) {
        form.clearErrors(field);
    }
};

const submit = () => {
    if (processing.value || !isFormValid.value) return;

    processing.value = true;

    form.post('/register', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.log('Registration errors from server:', errors);
        },
        onFinish: () => {
            processing.value = false;
        }
    });
};
</script>

<style scoped>
.form-group {
    @apply space-y-1.5;
}

.form-label {
    @apply block text-sm font-semibold text-gray-700;
}

.form-input {
    @apply w-full px-4 py-3 border border-gray-300 rounded-xl
    bg-white text-gray-900 placeholder-gray-400
    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
    transition-all duration-200
    hover:border-gray-400;
}

.form-error {
    @apply text-red-600 text-xs mt-1 flex items-center;
}

.form-error::before {
    content: '⚠';
    @apply mr-1;
}

/* Анимации */
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-5px);
    }
    20%, 40%, 60%, 80% {
        transform: translateX(5px);
    }
}

.animate-shake {
    animation: shake 0.5s;
}
</style>
