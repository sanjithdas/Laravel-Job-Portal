<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="border:1px solid green">
                    <div class="card-header bg-success d-flex specify-content-between">
                       <h1 class="">Chat Room </h1>
                       <span class="" >You are logged in as {{this.username}}</span>
                    </div>
                    <div class="card-body" >
                    <div class="chat-msg" style="border:1px solid green">
                      
                      <ul v-chat-scroll  class="list-group" v-if="chat.messages.length>2" >  
                        <li class="list-group-item mt-2" :class="className(msg.color)" v-if="msg.talk || msg.talk" v-for= "msg in chat.messages" style="list-type:none; height:20px border:2px black;" v-bind:key="msg.index">
                           {{msg.talk}} <span class="alert-light text-right" style="float:right">{{msg.ctime}}</span>
                           <br>
                           <small class="badge float-right" :class='badgeClass'>{{msg.user}} says</small>
                        </li> 
                        
                       </ul>
                        
                    </div>

                       <input type="text" placeholder="Type your message here..." class="form-control" v-model="chat.message" @keyup.enter.stop="addMessage">
                        
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
         props:['username','color'],
         computed:{
             className(colr){
                return 'list-group-item-'+this.colr;
             },
             badgeClass(){
                 return 'badge-'+this.color
             }
         },
        mounted() {
            console.log('Component mounted.')
        },
       
        data(){
           
            return{
                chat:{
                message:'',
                messages: [{talk:''}, {ctime:''}, {user:''}, {color: ''}],
                hours_min:'',
                times: [], 
                users:[]
                },
                chattime:''
            }
            
        },
        methods:{
            addMessage: function(e){
               
                if(e.keyCode===13){
                   this.chattime = new Date();
                   this.hours_min = "Time: " +this.chattime.getHours()+ ':'+ this.chattime.getMinutes() 
                   this.chat.messages.push({
                       talk:this.chat.message,
                       ctime:this.hours_min,
                       user: 'You',
                       color: 'warning'
                      })
                       this.broadCastMessage();
                       this.chat.message=''
                       
                }
            },

            broadCastMessage: function(){
               // alert(this.chat.message);
                axios.post('/chat/broadcast',{

                    message: this.chat.message,
                    user: this.username,
                    color: 'primary'

                })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
                
            }
            
        },
        mounted(){
           
            Echo.private('chat')
                .listen('ChatEvent', (e) => {
                  //  alert(e.color);
                       this.chat.messages.push({
                       talk:e.message,
                       user:e.user.name,
                       color: e.color
                       })
                      //this.color:e.color;

                });
        }

    }
</script>
<style scoped>
ul {
    height: 200px;
    overflow-y: scroll;
    border: 1px solid #e6e6e6;
    list-style: none;
    padding: 1em;
}
</style>
<style>
    .chat-msg{
      
        height:210px;
        border: 2px light brown;
    }
</style>
