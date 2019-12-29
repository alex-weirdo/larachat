const room = (id, name, last_update, last_message, image, isActive) => ({id, name, last_update, last_message, image, isActive});
const message = (id, author, text, updated_at) => ({id, author, text, updated_at});
const rooms = ['', '', '', '', '', false];
var app = new Vue({
    el: '#app',
    data: {
        rooms: rooms,
        room: { "data": { "type": "room", "id": "", "name": "" } },
        // room: this.rooms[this.selected],
        selected: 0,
        selectedRoomIndex: 0,
        selectedRoomId: 0,
        roomsAjax: false,
        searchRooms: '',
        messages: []
    },
    methods: {
        selectRoom : function (index, id) {
            this.rooms[this.selected].isActive = false;
            this.selected = index;
            this.rooms[this.selected].isActive = true;
            this.selectedRoomId = id;
            axios.get('/api/messages/' + id).then(response => (this.messages = response.data));
            axios.get('/api/rooms/' + id).then(response => (this.room = response.data));
        }
    },
    computed: {
        filteredRooms() {
            return this.rooms.filter(room => {
                this.selectedRoomIndex = ( this.searchRooms ) ? 0 : this.selectedRoomIndex;
                this.selected = this.selectedRoomIndex;
                return room.name.indexOf(this.searchRooms) > -1
            });
        }
    },
    mounted() {
        axios.get('/api/rooms/').then(response => (this.rooms = response.data));
        console.log(this.rooms[0]);
    }
});