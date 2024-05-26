<template>
  <div>
    <ul>
      <li v-for="proyecto in proyectos" :key="proyecto.IdProyecto">
        <img :src="obtenerURLImagen(proyecto.FotoProyecto)" alt="Foto del proyecto" style="width: 100px; height: 100px;">
        <div>
          <h3>{{ proyecto.NombreProyecto }}</h3>
          <p>{{ proyecto.Descripcion }}</p>
          <p>Ciclo: {{ proyecto.ciclo.NombreCiclo }}</p>
          <p>Curso: {{ obtenerCurso(proyecto) }}</p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        proyectos: {
        type: Array,
        required: true
        }
    },
  created() {
    this.obtenerProyectos();
  },
  methods: {
    async obtenerProyectos() {
      try {
        const response = await axios.get('/proyectos');
        this.proyectos = response.data;
      } catch (error) {
        console.error('Error al obtener los proyectos:', error);
      }
    },
    obtenerCurso(proyecto) {
      if (proyecto.proyectoAlumno && proyecto.proyectoAlumno.usuario && proyecto.proyectoAlumno.usuario.alumnoCiclo) {
        return proyecto.proyectoAlumno.usuario.alumnoCiclo.FechaCurso;
      }
      return 'No disponible';
    },
    obtenerURLImagen(longblob) {
      const arrayBufferView = new Uint8Array(longblob.data);
      const blob = new Blob([arrayBufferView], { type: 'image/jpeg' });
      return URL.createObjectURL(blob);
    }
  }
};
</script>
