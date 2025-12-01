import './bootstrap';
import { createApp } from 'vue';

// Импорт Bootstrap (если используете)
import 'bootstrap';

// Импорт компонентов Vue
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});

// Регистрация компонентов
app.component('example-component', ExampleComponent);

// Монтирование приложения
app.mount('#app');
