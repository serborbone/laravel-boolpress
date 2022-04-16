<template>
  
    <div id="main">

      <div class="container mt-5">

        <h1>Lista Post</h1>

        <div class="row">
            <div class="col-4" v-for="post in postList" :key="post.id">

              <!-- CARD POST -->
              <Post
                :title='post.title'
                :content='post.content'
                :slug='post.slug'
                :img='post.cover'
              >
              </Post>


            </div>

            

        </div>
        <nav>
            <ul class="pagination">
                <li class="page-item" :class=" (currentPage == 1)? 'disabled':'' ">
                  <span class="page-link" @click="getPostList(currentPage - 1)" >Previous</span>
                </li>
                
              <li class="page-item" :class=" (currentPage == lastPage)? 'disabled':'' ">
                <span class="page-link" @click="getPostList(currentPage + 1)" >Next</span>
              </li>
            </ul>
        </nav>  

      </div>
    </div>

</template>

<script>

import Post from '../components/Post.vue';

export default {

  name: 'Posts',
  components: {
    Post,
  }, 

  data() {

    return {

      postList: [],
      currentPage: 1,
      lastPage: 0,

    }

  },

  methods: {
  
    getPostList(pageNumber) {
    
      axios
      .get('/api/posts', {

        'params': {
          'page': pageNumber,
        }

      })
      .then((response) => {
          
          this.currentPage = response.data.results.current_page;
      
          this.postList = response.data.results.data;

          this.lastPage = response.data.results.last_page;
      
      });
    
    }
  },

  created() {

      this.getPostList(1);

  }

}
</script>

<style>

</style>
