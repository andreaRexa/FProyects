<template>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <!-- Elementos a la izquierda -->
        <div class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <form action="/FProyects" method="GET" class="form-inline mx-auto">
              <button class='btn' name='btnHome' type='submit'><i class="fas fa-home"></i></button>
            </form>
              <button class='btn nav-link' id='Proyectos' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                Proyecto
              </button>
              <li v-if="userRole === 2" class="nav-item dropdown d-inline-block">
                <button class="btn nav-link dropdown-toggle" id="alumnosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="toggleSubMenu('alumnos')">
                  Alumnos
                </button>
                <!-- Menú desplegable Alumnos -->
                <div class="dropdown-menu" aria-labelledby="alumnosDropdown" v-show="subMenus.alumnos">
                  <li class="nav-item"><button class="btn nav-link" name="btnNuevoProd" type="submit" href="#">Subir Proyecto</button></li>
                  <li class="nav-item"><button class="btn nav-link" name="btnNuevoProd" type="submit" href="#">Mis Proyectos</button></li>
                </div>
              </li>
            <li v-if="userRole === 3" class="nav-item dropdown d-inline-block">
             <button class='btn nav-link dropdown-toggle' id='familiaDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' @click="toggleSubMenu('familia')">
                Familia
              </button>
              <div class="dropdown-menu" aria-labelledby="familiaDropdown" v-show="subMenus.familia">
                <li class='nav-item'><button class='btn nav-link' name='btnNuevoProd' type='submit' href='#'>Proyecto Familia</button></li>
                <li class='nav-item'><button class='btn nav-link' name='btnNuevoProd' type='submit' href='#'>Gestión de Alumnos</button></li>
                <li class='nav-item'><button class='btn nav-link' name='btnNuevoProd' type='submit' href='#'>Gestión de Ciclos</button></li>
              </div>
            </li>
            <li class="nav-item dropdown d-inline-block" v-if="userRole === 4" >
              <button class='btn nav-link dropdown-toggle' id='administradoresDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' @click="toggleSubMenu('administradores')">
                Administradores
              </button>
              <div class="dropdown-menu" aria-labelledby="administradoresDropdown" v-show="subMenus.administradores">
                <li class='nav-item'><button class='btn nav-link' name='btnNuevoProd' type='submit' href='#'>Gestión de Familia</button></li>
                <li class='nav-item'><button class='btn nav-link' name='btnNuevoProd' type='submit' href='#'>Gestión de Usuarios</button></li>
              </div>
            </li>
          </ul>
        </div>
        
        <!-- Elementos en el centro -->
        <div class="d-flex justify-content-center align-items-center">
          <!-- Aquí puedes colocar la imagen -->
          <img src="/storage/imagenes/logo.png" alt="Foto" style="width: 600px; height: 50px;"> 
          <!-- Barra de búsqueda -->
          <input type="text" class="form-control mx-2" placeholder="Buscar">
        </div>
        
        <!-- Elementos a la derecha -->
        <div class="d-flex"> 
          <form action="/FProyects/loginForm" method="GET" class="form-inline mx-auto" v-if="userRole === 0">
            <button class='btn' name='btnlogin' type='submit'><i class="fas fa-user"></i></button>
          </form>
  
          <form action="/FProyects/MiPerfil" method="GET" class="form-inline mx-auto" v-if="userRole > 0">
              <button class='btn' name='btnMiPerfil' type='submit'><i class="fas fa-user"></i></button>
          </form>  
         
          <form action="/FProyects/logout" method="GET" class="form-inline mx-auto" v-if="userRole > 0">
            <button class='btn' name='btnLogOut' type='submit'><i class="fas fa-power-off"></i></button>
          </form>
          </div>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    props: ['userRole'],
    
    data() {
      return {
        subMenus: {
          proyecto: false,
          alumnos: false,
          familia: false,
          administradores: false,
          usuario: false
         
        },
        
      };
    },
  
    methods: {
      
      toggleSubMenu(menu) {
        this.subMenus[menu] = !this.subMenus[menu];
      }
  
    }
  };
  </script>
  
  <style scoped>
  .navbar {
    background-color: #02A7F0;
  }
  
  .nav-link {
    color: #fff !important;
  }
  
  .dropdown-menu {
    background-color: #343a40 !important;
    border: none !important;
  }
  
  .dropdown-item {
    color: #fff !important;
  }
  
  .dropdown-item:hover {
    background-color: #495057 !important;
  }
  </style>