const room = (id, name, last_update, last_message, image, isActive) => ({id, name, last_update, last_message, image, isActive});
const message = (id, author, text, updated_at) => ({id, author, text, updated_at});
const rooms = ['', '', '', '', '', false];
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

        user_id: false
    },
    methods: {
        selectRoom : function (index, id) {
            this.rooms[this.selected].isActive = false;
            this.selected = index;
            this.rooms[this.selected].isActive = true;
            this.selectedRoomId = id;
            axios.get('/api/messages/' + id).then(response => (this.messages = response.data));
            axios.get('/api/rooms/' + id).then(response => (this.room = response.data));
        },
        startLoading : function () {
            document.getElementById('loading').classList.add('start');
            this.user_id = document.getElementById('userid').value
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
        axios.get('/api/rooms/').then(response => {
            console.log('here', response.data);
            this.rooms = response.data;
            // sleep(500);
            this.loading = false;
        });
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