import { createApp } from 'vue';
import MenuBar from './components/MenuBar.vue';
const app = createApp({});
app.component('menu-bar', MenuBar);
app.mount('#app');
