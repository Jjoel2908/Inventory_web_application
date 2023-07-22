<template>
    <div id="app">
      <header>
        <!-- Aquí puedes colocar el encabezado de tu aplicación -->
      </header>
  
      <main>
        <!-- Aquí se mostrará el contenido de las rutas definidas por Vue Router -->
        <router-view></router-view>
      </main>
  
      <footer>
        <!-- Aquí puedes colocar el pie de página de tu aplicación -->
      </footer>
    </div>
  </template>
  
  <script>
  export default {
    name: 'App',
  }
  </script>
  
  <style>
  
  body {
    margin: 0;
    padding: 0;
  }
  </style>