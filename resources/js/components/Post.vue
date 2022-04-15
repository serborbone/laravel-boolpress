<template>

    <div class="card mb-3" style="width: 18rem;">

      <div class="card-body">

        <h5 class="card-title">{{ title}}</h5>
        <p class="card-text">{{ truncateText(content) }}</p>

        <router-link class="btn btn-primary" :to="{name: 'single-post', params: {slug: slug}}">Leggi il post</router-link>

      </div>

    </div>

</template>

<script>

export default {

  name: 'Post',
  props: ['title', 'content', 'slug'],

  methods: {

    truncateText(text) {
      if(text.length > 50) {

        return text.substring(0, 50) + '...';
      } else {

        return text;
      }
    }

  }

}

</script>

<style>

</style>