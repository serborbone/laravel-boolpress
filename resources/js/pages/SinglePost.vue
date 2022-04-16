<template>

    <div class="container">
      <div class="row">
        <div class="col-7 pt-5 m-auto">

            <div v-if="post">

              <img class="img-fluid" :src="post.cover">

              <h1>{{post.title}}</h1>

              <h5 v-if="post.category">Categoria: {{post.category.name}}</h5>

              <p class="mt-4 mb-4">{{post.content}}</p>

              <span>Tag:</span>
              <span v-for="tag in post.tags" :key="tag.id" class="badge bg-primary p-2 ml-2">{{tag.name}}</span>

            </div>
  

        </div>
      </div>
    </div>
      
</template>

<script>


export default {

  name: 'SinglePost',

  data() {
  
    return {
      post: null,
    }
  
  },
  
  mounted() {

    const slug = this.$route.params.slug;

    axios.get('/api/posts/' + slug).then(response => {
    
      if (response.data.success == false) {

          this.$router.push({name: 'not-found'});

      } else {
      
        this.post = response.data.result;
      
      }

    });

  }
}
</script>

<style>

</style>