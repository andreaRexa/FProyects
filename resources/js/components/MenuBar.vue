<template>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <!-- Elementos a la izquierda -->
        <div class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <form action="/" method="GET" class="form-inline mx-auto">
              <button class='btn' name='btnHome' type='submit'><i class="fas fa-home"></i></button>
            </form>
            <form action="proyectos" method="GET" class="form-inline mx-auto">
              <button class='btn nav-link'name='btnProyectos' aria-haspopup='true' aria-expanded='false' type='submit'>
                Proyectos
              </button>
            </form>
              <li v-if="userRole === 2" class="nav-item dropdown d-inline-block">
                <button class="btn nav-link dropdown-toggle" id="alumnosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="toggleSubMenu('alumnos')">
                  Alumnos
                </button>
                <!-- Menú desplegable Alumnos -->
                <div class="dropdown-menu" aria-labelledby="alumnosDropdown" v-show="subMenus.alumnos">
                  <form action="subirproyectos" method="GET" class="form-inline mx-auto">  
                    <li class="nav-item"><button class="btn nav-link" name="btnSubirProyecto" type="submit" href="#">Subir proyecto</button></li>
                  </form>
                  <form action="proyectosAlumno" method="GET" class="form-inline mx-auto">  
                    <li class="nav-item"><button class="btn nav-link" name="btnMisProyectosAlumno" type="submit">Mis proyectos</button></li>
                  </form>
                </div>
              </li>
            <li v-if="userRole === 3" class="nav-item dropdown d-inline-block">
             <button class='btn nav-link dropdown-toggle' id='familiaDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' @click="toggleSubMenu('familia')">
                Familias
              </button>
              <div class="dropdown-menu" aria-labelledby="familiaDropdown" v-show="subMenus.familia">
                <form action="proyectoFamilia" method="GET" class="form-inline mx-auto">
                  <li class='nav-item'><button class='btn nav-link' name='btnMisProyectosFamilia' type='submit' href='#'>Mis proyectos</button></li>
                </form>
                <form action="gestionesAlumnos" method="GET" class="form-inline mx-auto">
                  <li class='nav-item'><button class='btn nav-link' name='btnGestAlumnos' type='submit' href='#'>Gestión de alumnos</button></li>
                </form>               
                <form action="gestionesModulos" method="GET" class="form-inline mx-auto">
                  <li class='nav-item'><button class='btn nav-link' name='btnGestModulos' type='submit' href='#'>Gestión de modulos</button></li>
                </form>
              </div>
            </li>
            <li class="nav-item dropdown d-inline-block" v-if="userRole === 4" >
              <button class='btn nav-link dropdown-toggle' id='administradoresDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' @click="toggleSubMenu('administradores')">
                Administradores
              </button>
              <div class="dropdown-menu" aria-labelledby="administradoresDropdown" v-show="subMenus.administradores">
                <form action="gestionesFamilia" method="GET" class="form-inline mx-auto">
                  <li class='nav-item'><button class='btn nav-link' name='btnGestFamilias' type='submit' href='#'>Gestión de familias</button></li>
                </form>
              <li class='nav-item'><button class='btn nav-link' name='btnGestUsuarios' type='submit' href='#'>Gestión de usuarios</button></li>
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
          <form action="/loginForm" method="GET" class="form-inline mx-auto" v-if="userRole === 0">
            <button class='btn' name='btnlogin' type='submit'><i class="fas fa-user"></i></button>
          </form>
  
          <form action="/MiPerfil" method="GET" class="form-inline mx-auto" v-if="userRole > 0">
              <button class='btn' name='btnMiPerfil' type='submit'><i class="fas fa-user"></i></button>
          </form>  
         
          <form action="/logout" method="GET" class="form-inline mx-auto" v-if="userRole > 0">
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