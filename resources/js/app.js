import { createApp } from 'vue';
import MenuBar from './components/MenuBar.vue';
import ListadoProyectos from './components/ListadoProyectos.vue';
const app = createApp({});
app.component('menu-bar', MenuBar);
app.component('listadoProyectos', ListadoProyectos);
app.mount('#app');
