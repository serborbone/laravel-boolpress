<template>

    <div id="first-view">

      <Header></Header>
      <Main></Main>
      <Footer></Footer>
    
    </div>

</template>

<script>

import Main from '../components/Main.vue';
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';


export default {
  name: 'App',
  components: {
    Header,
    Main,
    Footer,
  }
}

</script>

<style>

</style>