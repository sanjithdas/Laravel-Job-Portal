<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card mt-5" style="border:1px solid green">
                    <div class="card-header bg-primary d-flex specify-content-between">
                       <h1 class="text-white">Chat Room </h1>
                       <span class="badge badge-light inline" style="height:1rem;">{{this.logged_in_users}} </span>
                       <span class="float-right text-right text-white sm" style="width:17rem; margin-left:12rem">You are logged in as {{this.username}}</span>
                    </div>
                    <div class="card-body" >
                        <div class="badge badge-pill badge-primary" v-if="typing"> {{ this.typing}}</div>
                    <div class="chat-msg" style="border:1px solid green">
                      
                      <ul v-chat-scroll  class="list-group list-scroll"  >  
                        <li class="list-group-item mt-2" :class="msg.color" v-if="msg.talk" v-for= "msg in chat.messages" style="list-type:none; height:20px border:2px black;" v-bind:key="msg.index">
                           {{msg.talk}} <small class="badge badge-light badge-pill small text-right" style="float:right">{{msg.ctime}}</small>
                           <br>
                           <small class="badge float-right bg-p" :class='badgeClass'>{{msg.user}} says</small>
                        </li> 
                        
                       </ul>
                        
                    </div>

                       <input type="text"  placeholder="Type your message here..." class="form-control" v-model="message" @keyup.enter.stop="addMessage">
                        
                    </div>
                      <a href='' class="btn btn-danger btn-sm float-right" style="width:30%; margin-right:0px"  @click='deleteSession'>Delete Chat History</a>
                  
                </div>
            </div>
            <div class="col-3 mt-5 ml-0" style="border:0px solid green; margin-left:0px">
                <ul class="list-group chat-scroll">
                    
                    <li class="list-group-item list-group-item-action"  v-bind:class="[username==users?activeClass:' ']" v-for= "users in users_logged" v-bind:key="users" data-toggle="modal"  @click="openPrivateChat(users)">{{users}}</li>
                                   
                </ul>
            </div>
            
        </div>

        <div>
             
       <b-modal ref="my-modal" hide-footer>You are chatting with {{this.chattingWith}}
            <div>
                <textarea placeholder="Type your message here..." v-model="private_message" rows="4" cols="60"></textarea>
            </div>              
            <b-button class="mt-3 ml-2 btn btn-danger float-right btn-sm"    @click="hideModal">Close</b-button> &nbsp;&nbsp;
            <b-button class="mt-3  btn btn-success float-right btn-sm"   @click="addMessage">Send</b-button>
        </b-modal>
  </div>
       
    </div>

    
    
</template>

<script>
    export default {
         props:['username','color'],
         computed:{
             badgeClass(){
                 return 'badge-'+this.color
             }
         },
      
       
        data(){
           
            return{
                message:'',
                chat:{
                     messages: [],
                     privatemessage: []
                },
               
                chattime:'',
                typing:'',
                logged_in_users:0,
                users_logged : [],
                activeClass: 'active',
                isActive: false,
                chattingWith:'',
                private_message:'',
                
            }
            
        },
        watch:{
           
                message(){
               
                Echo.private('chat')
                    .whisper('typing', {
                        name:this.message
                    });
               
            }
        },
        methods:{

           hideModal() {
                this.$refs['my-modal'].hide()
            },
            addMessage: function(e){
                
                if(e.keyCode===13){
                  if(this.message.length!=0){ 
               
                   this.chat.messages.push({
                       talk:this.message,
                       ctime:this.getTime(),
                       user: 'You',
                       color: 'list-group-item-warning'
                      })
                     
                       this.sendMessage();
                       this.message=''
                  }      
                       
                }
                if (this.private_message.length>0){
                    
                    this.sendPrivateMessage();
                    this.$refs['my-modal'].hide();
                    this.private_message=''
                }
            },

            sendMessage: function(){
              
                axios.post('/chat/broadcast',{

                    message: this.message,
                    user: this.username,
                    color: this.color,
                    chat: this.chat.messages

                }) 
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
                
            },

            // Sending private messages 
            
                sendPrivateMessage: function(){
               //  alert(this.private_message);
                axios.post('/chat/private-message',{

                    message: this.private_message,
                    user: this.username,
                    color: this.color,
                    chattingWith: this.chattingWith
                   // chat: this.chat.messages

                }) 
                .then(response => {
                  //  console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
                
            },
            
            //#endregion

            
            getSessionMessages: function(){
                axios.post('/getSessionMessages', {

                }).then(response => {
                    
                     if (response.data != '') {
                        this.chat.messages.push(response.data);
                       // console.log(response);
                    }
                }).catch(error =>{
                    console.log(error);
                });


            },

            deleteSession: function(){
                axios.post('/deleteSession')
                .then(response=> this.$toaster.success('Chat history is deleted') );
            },

            getTime: function(){
            let time = new Date();
            return "Time: "+time.getHours() + ':'+ time.getMinutes() + ':'+ time.getSeconds();
        },

            openPrivateChat: function(user){

                this.chattingWith=user;
               
                this.$refs['my-modal'].show()
            }
            
        },
        
        mounted(){
          
           this.getSessionMessages();
         
            Echo.private('chat')
                .listen('ChatEvent', (e) => {
                 
                       this.chat.messages.push({
                       talk:e.message,
                       user:e.user.name,
                       ctime:this.getTime(),
                       color: 'list-group-item-primary'
                       });

                        axios.post('/saveToSession',{
                            chat: this.chat
                        }).then(response => {

                        }).catch(error =>{
                           console.log('error')
                        });
                })

            // PrivateChat Broadcasting

            Echo.private('chatprivate')
                .listen('PrivateChatEvent', (e) => {
                    console.log('Private'+e.chattingWith.name);
                    if (this.username==e.chattingWith.name){
                        this.chat.messages.push({
                        talk:e.message,
                        user:'Private message '+e.user.name,
                        ctime:this.getTime(),
                        color: 'list-group-item-primary'
                       });
                    }
                    
                })


            // #endregion    

            Echo.private('chat')
                .listenForWhisper('typing', (e) => {
                    if (e.name!=''){
                        this.typing ='typing...'
                    }
                    else{
                        this.typing =''
                    }
                })
            Echo.join('chat')
                .here((users) => {
                    this.logged_in_users=users.length;
                     users.map(user =>{
                          if (user.name!=''){
                            if (user.name!=this.username){
                                this.users_logged.push(user.name);
                            }
                          }   
                    });
                   
                   // 
                })
                .joining((user) => {

                   if (user.name!='')
                        this.users_logged.push(user.name);
                   this.logged_in_users += 1
                    this.$toaster.success(user.name+' is joined in the chat section.');
                     
                })
                .leaving((user) => {
                    this.logged_in_users -= 1
                    this.$toaster.warning(user.name+' is left in the chat section.');
                    let index=this.users_logged.indexOf(user.name)
                    this.users_logged.splice(index,1);
            });     
        }

    }
</script>
<style scoped>
ul.list-scroll {
    height: 200px;
    overflow-y: scroll;
    border: 1px solid #e6e6e6;
    list-style: none;
    padding: 1em;
}
ul.chat-scroll {
  
    overflow-y: scroll;
   
}
</style>
<style>
    .chat-msg{
      
        height:210px;
        border: 2px light brown;
    }
</style>
