<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Messages</div>

                    <div class="card-body p-0">
                        <ul class="list unstyle" style="height:300px ; overflow-y:scroll " v-chat-scroll>
                            <li class="p-2" v-for="(message , index) in messages" :key="index">
                                <strong>{{message.user.name}}</strong>
                                {{message.message}}
                            </li>
                        </ul>
                    </div>
                    <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                     v-model="newMessage" type="text" 
                     name="message"
                     placeholder="Enter your message" 
                     class="form control">
                   
                </div>
                <span class="text-muted" v-if="activeUser"> {{activeUser.name}} is typing...</span>
                    <div>
                        <input class="form control" name="attachment" type="file" ref="file">
                        <button @click="sendMessage">Send Image</button>
                    </div>
                    <div>
                        <input class="form control" name="attachment" type="file" ref="file">
                        <button @click="sendMessage">Send Video</button>
                    </div>
                     <div>
                        <input class="form control" name="attachment" type="file" ref="file">
                        <button @click="sendMessage">Send Audio</button>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card header">Active Users</div>
                    <div class="card-bodey">
                        <ul>
                            <li class="py-2" v-for="(user,index) in users " :key="index">{{user.name}}</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {

       props:['user'],

       data(){
          return {
              messages : [],
              newMessage : '',
              users :[],
              activeUser :false,
              typingTimer: false,
          }  
       },
       created() {
         
         this.fetchMessages();
         Echo.join('chat')
         .here(user => {
             this.users = user;
         })
         .joining(user => {
             this.users.push(user);
         })
         .leaving(user => {
             this.users = this.users.filter( u=> u.id != user.id );
         })
         .listen('MessageSent' ,(event) => {
             this.messages.push(event.message); 
         })
         .listenForWhisper('typing' , user => {
             this.activeUser = user;
             if(this.typingTimer){
                 clearTimeout(this.typingTimer);
             }
             this.typingTimer = setTimeout(() => {
                 this.activeUser  = false;
             }, 3000);
         })
   

       },
       methods: {
           fetchMessages() {
               axios.get('messages').then(response => {
               this.messages = response.data;
           })
           },
           sendMessage() {
                 this.messages.push({
                    user: this.user,
                    message: this.newMessage,
                });

               axios.post('messages' , {message: this.newMessage});
               this.newMessage = '';

           },
           sendTypingEvent(){
               Echo.join('chat')
               .whisper('typing' ,this.user);
           }
       }
    }
</script>
