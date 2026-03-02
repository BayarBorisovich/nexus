<template>
    <div class="min-vh-100 d-flex flex-column">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg sticky-top" style="background: #ffffff; border-bottom: 1px solid #e2e6f0; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div class="container-lg">
                <!-- Logo -->
                <Link href="/" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none">
                    <div class="rounded-2 d-flex align-items-center justify-content-center p-1" style="background: linear-gradient(135deg, #4f6ef7, #7c3aed); width: 34px; height: 34px;">
                        <i class="bi bi-lightning-fill text-white" style="font-size: 1rem;"></i>
                    </div>
                    <span class="fw-bold gradient-text fs-5">Nexus</span>
                </Link>

                <!-- Toggler for mobile -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list" style="color: #1a1f36; font-size: 1.4rem;"></i>
                </button>

                <!-- Nav Items -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-nav ms-auto align-items-center gap-1">
                        <!-- Главная -->
                        <Link
                            href="/"
                            class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 fw-medium"
                            style="color: #1a1f36;"
                            active-class="nav-link-active"
                        >
                            <i class="bi bi-house-fill" style="color: #4f6ef7;"></i>
                            <span>Главная</span>
                        </Link>

                        <!-- Профиль -->
                        <Link
                            :href="`/profile/${auth.user.id}`"
                            class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 fw-medium"
                            style="color: #1a1f36;"
                        >
                            <i class="bi bi-person-circle" style="color: #4f6ef7;"></i>
                            <span>Профиль</span>
                        </Link>

                        <!-- Разделитель -->
                        <div style="width: 1px; height: 28px; background: #e2e6f0;" class="mx-1 d-none d-lg-block"></div>

                        <!-- User dropdown -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-2 py-1 rounded-3" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #1a1f36;">
                                <img
                                    :src="auth.user.avatar_url"
                                    :alt="auth.user.name"
                                    style="width: 34px; height: 34px; border: 2px solid #4f6ef7; border-radius: 50%; object-fit: cover;"
                                />
                                <span class="d-none d-sm-inline fw-medium">{{ auth.user.name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <Link :href="`/profile/${auth.user.id}`" class="dropdown-item d-flex align-items-center gap-2">
                                        <i class="bi bi-person" style="color: #4f6ef7;"></i>Мой профиль
                                    </Link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form @submit.prevent="logout" class="d-inline w-100">
                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                            <i class="bi bi-box-arrow-right text-danger"></i>Выход
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <!-- Выход мобильный -->
                        <form @submit.prevent="logout" class="d-lg-none mt-2 w-100">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-box-arrow-right me-1"></i>Выход
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-grow-1 py-4 py-md-5">
            <div class="container-lg">
                <slot />
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-5 border-top" style="background: #ffffff; border-color: #e2e6f0 !important;">
            <div class="container-lg py-4 py-md-5">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <h5 class="gradient-text mb-3">Nexus</h5>
                        <p style="color: #6b7280;">Современная социальная сеть для общения и обмена идеями.</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="fw-semibold mb-3" style="color: #1a1f36;">Навигация</h6>
                        <ul class="list-unstyled small">
                            <li><Link href="/" class="text-decoration-none" style="color: #6b7280;">Главная</Link></li>
                            <li><Link :href="`/profile/${auth.user.id}`" class="text-decoration-none" style="color: #6b7280;">Мой профиль</Link></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="fw-semibold mb-3" style="color: #1a1f36;">Контакты</h6>
                        <p style="color: #6b7280;">support@nexus.local</p>
                    </div>
                </div>
                <div class="border-top pt-4" style="border-color: #e2e6f0 !important;">
                    <p class="text-center small mb-0" style="color: #6b7280;">&copy; 2024 Nexus. Все права защищены.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { Link, router } from '@inertiajs/vue3'

const page = usePage()
const auth = page.props.auth

const logout = () => {
    router.post('/logout')
}
</script>

<style scoped>
a {
    transition: all 0.3s ease;
}

i {
    transition: all 0.3s ease;
}

.min-vh-100 {
    min-height: 100vh;
}

.rounded {
    border-radius: 0.5rem;
}

@media (max-width: 576px) {
    .container-lg {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
