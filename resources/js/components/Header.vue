<template>

  <div id="header">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

      <a class="navbar-brand" href="#">Boolpress</a>

      <ul class="navbar-nav mr-auto flex-row">

        <li class="nav-item active">
          <router-link class="nav-link" :to="{name: 'home'}">Home</router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" :to="{name: 'about'}">About us</router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" :to="{name: 'contact'}">Contatti</router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" :to="{name: 'posts'}">Post</router-link>
        </li>

      </ul>

    </nav>

  </div>

</template>

<script>
export default {
  name: 'Header',
}
</script>

<style>

</style>