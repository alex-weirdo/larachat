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

        user_id: false,

        _token: null,
        message: null,
        room_id: null
    },
    methods: {
        init : function () {
            var pusher = new Pusher('ba62cbea57f9bdb16fb4', {
                cluster: 'eu'
            });

            var channel = pusher.subscribe('my-channel');

            channel.bind('App\\Events\\MessageSent', function(data) {

                // notify работает всегда
                // this.notify();
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

                setTimeout(function(){
                    let history = document.getElementById('msg_history');
                    history.scrollTop = history.scrollHeight+50;
                }, 500);
            });

            this.getRooms();
        },
        notify : function () {},
        gotMessage : function () {},
        getRooms : function () {
            axios.get('/api/rooms/').then(response => {
                console.log('here', response.data);
                this.rooms = response.data;
                // sleep(500);
                this.loading = false;
            });
        },
        selectRoom : function (index, id) {
            this.message = '';
            this.rooms[this.selected].isActive = false;
            this.selected = index;
            this.rooms[this.selected].isActive = true;
            this.selectedRoomId = id;
            axios.get('/api/messages/' + id).then(response => (this.messages = response.data));
            axios.get('/api/rooms/' + id).then(response => (this.room = response.data));

            setTimeout(function(){
                let history = document.getElementById('msg_history');
                history.scrollTop = history.scrollHeight+50;
            }, 500);
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