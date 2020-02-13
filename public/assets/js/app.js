const room = (id, name, last_update, last_message, image, isActive) => ({id, name, last_update, last_message, image, isActive});
const message = (id, author, text, updated_at) => ({id, author, text, updated_at});
const rooms = ['', '', '', '', '', false];
const Bus = new Vue();
var app = new Vue({
    el: '#app',
    data: {
        rooms: [],
        room: { "data": { "type": "room", "id": "", "name": "", 'isActive': false } },
        selected: 0,
        selectedRoomIndex: 0,
        selectedRoomId: 0,
        roomsAjax: false,
        searchRooms: '',
        messages: [],
        loading: true,

        user_id: document.getElementById('userid').value,
        username: document.getElementById('username').innerHTML,

        _token: null,
        message: null,
        room_id: null,

        typingSkip: 1,
        typeSkipSetting: 5
    },
    methods: {
        init : function () {
            var pusher = new Pusher('ba62cbea57f9bdb16fb4', {
                cluster: 'eu'
            });

            var channel = pusher.subscribe('my-channel');

            $root = this;

            channel.bind('App\\Events\\MessageSent', function(data) {
                // notify работает всегда
                $root.notify();
                // todo: если data.room_id == app.room.data.id вызываем метод gotMail
                if (data.room_id != app.room.data.id) return false;
                // else this.gotMail();
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
            });
            $root.messagesScroll();
            $root.getChats();
        },
        notify : function () {
            this.messagesScroll();
            this.getChats();
        },
        gotMessage : function () {},
        getRooms : function () {
            axios.get('/api/rooms/').then(response => {
                this.rooms = response.data;
                // this.loading = false;
            });
        },
        getDialogs : function (user_id) {
            axios.get('/api/user/'+user_id+'/dialogs').then(response => {
                this.rooms = this.rooms.concat(response.data);
            });
        },
        getChats : function () {
            this.getRooms();
            // личные сообщения пока спрячем
            // this.getDialogs(this.user_id);

            this.loading = false;
        },
        selectRoom : function (index, id, scroll=true) {
            this.message = '';
            this.rooms[this.selected].isActive = false;
            this.selected = index;
            this.rooms[this.selected].isActive = true;
            this.selectedRoomId = id;
            axios.get('/api/messages/' + id).then(response => (this.messages = response.data));
            axios.get('/api/rooms/' + id).then(response => (this.room = response.data));

            if (scroll) this.messagesScroll();

            this.listenTyping(id);

            document.getElementById('write_msg').focus();
        },
        startLoading : function () {
            document.getElementById('loading').classList.add('start');
            this.user_id = document.getElementById('userid').value
        },
        chatMessageSend : function (event) {
            event.preventDefault();
            axios.post('/messages', {
                _token: this._token,
                message: this.message,
                room_id: this.room.data.id
            });
            this.message = '';
            this.getChats();
            this.messagesScroll();
        },
        delete_message : function (id) {
            axios.post('/api/resource/messages/'+id, {
                _token: this._token,
                _method: 'delete'
            }).then(()=>{
                this.selectRoom(this.selected, this.selectedRoomId, false);
            });
        },
        messagesScroll : function () {
            let waiting = setInterval(t => {
                let history = document.getElementById('msg_history');
                if(history) {
                    //console.dir(ul);
                    history.scrollTop = history.scrollHeight;
                }
            }, 5);
            setTimeout(t => {clearInterval(waiting)}, 1000);
        },
        listenTyping : function (room_id) {
            let pusher = new Pusher('ba62cbea57f9bdb16fb4', {
                cluster: 'eu'
            });
            let channel = pusher.subscribe('channel_' + room_id);
            $root = this;
            channel.bind('App\\Events\\MessageTyping', function(data) {
                let history = document.getElementById('msg_history');
                if (room_id == data.room_id && $root.username != data.user_name ) {
                    history.setAttribute('data-typing', data.user_name + ' печатает сообщение ... ');
                    history.classList.add('typing');
                }
                setTimeout(function(){
                    history.classList.remove('typing');
                }, 500);
            });
        },
        typing : function (name) {
            if (!(--this.typingSkip)) {
                axios.get('/channel/typing?user=' + name + '&room_id=' + this.room.data.id);
                this.typingSkip = this.typeSkipSetting;
            }
        }
    },
    computed: {
        filteredRooms() {
            return this.rooms.filter(room => {
                return room.name.indexOf(this.searchRooms) > -1
            });
        }
    },
    mounted() {
        Bus.$on('hovered', (message)=>{
            document.getElementById('rgbrtb').innerHTML = message;
        });
        this.init();
    }
});



setTimeout(function(){app.startLoading()}, 1);
function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
        currentDate = Date.now();
    } while (currentDate - date < milliseconds);
}


/**
 * я компонент
 */
Vue.component('my-custom', {
    template: '<h1 id="rgbrtb" @mouseover="hover">хуй</h1>',
    methods: {
        hover: ()=>{
            Bus.$emit('hovered', 'йух')
        }
    }
});




emojify.setConfig({img_dir : 'https://www.webfx.com/tools/emoji-cheat-sheet/graphics/emojis'});
setInterval(()=>{emojify.run();for (let i=0; i<document.getElementsByClassName('emoji').length; i++) {
    document.getElementsByClassName('emoji')[i].parentNode.style.background = 'none';
}}, 100);