
<template>
 <div>
  <input type="text"  placeholder="Search jobs..." v-model="search" v-on:keyup="searchJobs" class="form-control">
  <div class="card-footer" v-if="results.length">
    <ul class="list-group">
        <li class="list-group-item" v-bind:key="result.id" v-for="result in results">
            <a style="color:#000;" :href=" '/jobs/' + result.id +'/'+result.slug+'/'  ">{{result.title}}
                <br>
                <small class="badge badge-success">{{result.position}}</small>
            </a>
        </li>
    </ul>
  </div>
  
 </div>
</template>


<script>
 export default{
  data(){
    return{
        search:'',
        results:[],
    }
  },
  methods: {
   searchJobs(){
    
    this.results = [];
    if(this.search.length>1){
        
        axios.get('/jobs/vue/search',{params:{search:this.search}}).then(response=>{
            this.results = response.data;
        });
    }
    
  }
 }
}
</script>