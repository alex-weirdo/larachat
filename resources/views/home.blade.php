@extends('layouts.app')
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"
      xmlns:v-bind="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet" />

<div class="container" id="app">
    <div class="header">
        <img src="https://ptetutorials.com/images/user-profile.png" alt="{{ Auth::user()->name }}">
        <div class="u_info">
            <input type="hidden" id="userid" value="{{ Auth::user()->id }}">
            <p>{{ Auth::user()->name }}</p>
            <a href="http://localhost:8000/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                Выйти
            </a>
        </div>
    </div>
    <div class="loading" id="loading" v-if="loading"></div>
    <template v-else>
    <h3 class=" text-center">@{{ room.data.name }}</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Recent</h4>
                    </div>
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <input type="text" class="search-bar" id="search" placeholder="Search" v-model="searchRooms">
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    <div class="chat_list" v-for="(room, index) of filteredRooms" v-on:click="selectRoom(index, room.id)" v-bind:class="{ active_chat: selectedRoomId==room.id }">
                        <div class="chat_people">
                            <div class="chat_img"> <img v-bind:src="{ src: room.image_src }.src" alt="room"> </div>
                            <div class="chat_ib">
                                <h5>@{{ room.name }} <span class="chat_date">@{{ room.updated_at }}</span></h5>
                                <p>@{{ room.last_message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history" id="msg_history">
                    <div class="" v-for="(message, index) of messages" v-bind:class="{ outgoing_msg: user_id == message.user_id, incoming_msg: user_id != message.user_id,  }">
                        <div class="incoming_msg_img" v-if="user_id != message.user_id"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                        <div class="" v-bind:class="{ sent_msg: user_id == message.user_id, received_msg: user_id != message.user_id  }">
                            <p v-if="user_id != message.user_id">@{{ message.user.name }}</p>
                            <div class="received_withd_msg" v-if="user_id != message.user_id">
                                <p>@{{ message.text }}</p>
                                <span class="time_date">@{{ message.created_at }}</span>
                            </div>

                            <p v-if="user_id == message.user_id">@{{ message.text }}</p>
                            <span class="time_date" v-if="user_id == message.user_id">@{{ message.created_at }}</span>
                        </div>
                            {{--<span class="time_date"> 11:01 AM    |    June 9</span> --}}
                    </div>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <form v-on:submit="chatMessageSend">
                            {{ csrf_field() }}
                            <input type="hidden" name="room_id" v-model="room_id">
                            <input type="text" class="write_msg" v-model="message" name="message" placeholder="Type a message" />
                            <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <p class="text-center top_spac">@{{ /*messages*/ }}</p>

    </div>
    </template></div>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
<script>
    var pusher = new Pusher('ba62cbea57f9bdb16fb4', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');

    channel.bind('App\\Events\\MessageSent', function(data) {
        if (data.room_id != app.room.data.id) return false;
        let today = new Date();
        let date = today.getFullYear()+'-'+(("0" + (today.getMonth() + 1)).slice(-2))+'-'+today.getDate();
        let time = ("0" + (today.getHours())).slice(-2) + ":" + ("0" + (today.getMinutes())).slice(-2) + ":" + ("0" + (today.getSeconds())).slice(-2);
        let dateTime = date+' '+time;
        app.messages.push({
            text: data.message,
            user_id: data.user_id,
            user: {
                id: data.user_id,
                name: data.user_name
            },
            created_at: dateTime
        });

        setTimeout(function(){
            let history = document.getElementById('msg_history');
            history.scrollTop = history.scrollHeight+50;
        }, 1000);
    });
</script>