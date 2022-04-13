<template>
  
    <div id="main">

      <div class="container mt-5">

        <h1>Lista Post</h1>

        <div class="row">
            <div class="col-4" v-for="post in postList" :key="post.id">

              <!-- CARD POST -->
              <div class="card mb-3" style="width: 18rem;">

                <div class="card-body">

                  <h5 class="card-title">{{post.title}}</h5>
                  <p class="card-text">{{post.content}}</p>
                  <a href="#" class="btn btn-primary">Leggi il post</a>

                </div>

              </div>


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

export default {

  name: 'Main',

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

  created(){

      this.getPostList();

  }

}
</script>

<style>

</style>