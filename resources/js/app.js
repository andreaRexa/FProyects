import { createApp } from 'vue';
import MenuBar from './components/MenuBar.vue';
import ListadoProyectos from './components/ListadoProyectos.vue';

// Crear la primera aplicación Vue
const app = createApp({});
app.component('menu-bar', MenuBar);
app.mount('#app');

// Crear la segunda aplicación Vue
const app2 = createApp({});
app2.component('listadoProyectos', ListadoProyectos);
app2.mount('#app2');
