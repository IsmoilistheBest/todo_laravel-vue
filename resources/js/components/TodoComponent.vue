<template>
    <div class="w-25">
        <form @submit.prevent="saveTodo">
            <div class="input-group mb-3 w-100">
                <input v-model="form.title" type="text" class="form-control form-control-lg"
                placeholder="Enter your plan here..." aria-label="Recipient's username"
                aria-describedby="button-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit" id="button-addon2">Add</button>
                </div>
            </div>
             <!-- <span class="text-danger pt-3 pb-3" style="font-size:20px;"
                v-if="form.errors.has('error')" v-text="form.errors.get('error')"
             >
             </span> -->
        </form>

        <div class="w-100 todo">

            <div class="w-100 d-flex align-items-center p-3 bg-white border-bottom"
            v-for="todo in todos" :key="todo.id">
                <span class="mr-2">
                    <svg v-on:click="toggleTodo(todo)" v-if="todo.completed == false"
                        xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle"
                        width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107"
                        fill="none" stroke-linecap="round" stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                    <svg v-if="todo.completed == true" v-on:click="toggleTodo(todo)"
                        xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check"
                        width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4CAF50" fill="none"
                        stroke-linecap="round" stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <circle cx="12" cy="12" r="9" />
                        <path d="M9 12l2 2l4 -4" />
                    </svg>
                </span>

                <div class="overtext w-50 font-weight-bolder">
                    <div v-if="edit == false || edit != todo.id"
                        v-bind:class="[{ 'text-muted ' : todo.completed }, { 'text-del' : todo.completed } ]"
                    >
                        {{ todo.title }}
                        <!-- Modal for description -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="description_id == todo.id"
                        >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ todo.title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea  v-model="form.description"  class="textarea-custom"
                                            v-if="!todo.description" placeholder="Enter description here..." type="text"
                                        >
                                        </textarea>
                                        <textarea  v-model="todo.description"  class="textarea-custom"
                                            v-if="todo.description" placeholder="Enter description here..." type="text"
                                        >
                                        </textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" data-dismiss="modal" @click="addDescription(todo)" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of modal -->
                    <!-- Modal for show-->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" v-if="show_id == todo.id"
                    >
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Your Todo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-title__text">{{ todo.title }}</div>
                            <div class="modal-description">
                                <span class="modal-description__text">
                                    Description:
                                </span>
                                {{ todo.description }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                    <input v-if="edit == todo.id" v-model="todo.title" type="text">
                </div>
                <div class="ml-auto mr-2 d-flex align-items-center">

                    <span>
                        <svg class="svg-custom" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" focusable="false" width="1.4em" height="1em"
                            style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 1792 1280" data-toggle="modal"
                            data-target="#exampleModalCenter" v-on:click="show_id = todo.id"
                        >
                        <path d="M1664 704q-152-236-381-353q61 104 61 225q0 185-131.5 316.5T896 1024T579.5 892.5T448 576q0-121
                            61-225q-229 117-381 353q133 205 333.5 326.5T896 1152t434.5-121.5T1664 704zM944 320q0-20-14-34t-34-14q-125
                            0-214.5 89.5T592 576q0 20 14 34t34 14t34-14t14-34q0-86 61-147t147-61q20 0 34-14t14-34zm848 384q0 34-20
                            69q-140 230-376.5 368.5T896 1280t-499.5-139T20 773Q0 738 0 704t20-69q140-229 376.5-368T896 128t499.5
                            139T1772 635q20 35 20 69z" fill="#626262"/>
                        </svg>
                        <svg alt="Add description" data-toggle="modal" data-target="#exampleModal"
                            class="svg-circleplus" viewBox="0 0 100 100" v-on:click="description_id = todo.id"
                        >
                        <circle cx="50" cy="50" r="45" fill="none" stroke-width="7.5"></circle>
                        <line x1="32.5" y1="50" x2="67.5" y2="50" stroke-width="5"></line>
                        <line x1="50" y1="32.5" x2="50" y2="67.5" stroke-width="5"></line>
                        </svg>

                        <svg v-on:click="edit = todo.id"  v-if="edit != todo.id"
                            xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                            width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107"
                            fill="none" stroke-linecap="round" stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                            <line x1="16" y1="5" x2="19" y2="8" />
                        </svg>
                        <svg v-if="edit == todo.id" v-on:click="updateTodo(todo)"
                            xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checkbox"
                            width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4CAF50"
                            fill="none" stroke-linecap="round" stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <polyline points="9 11 12 14 20 6" />
                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                        </svg>
                    </span>
                    <span>
                        <svg v-on:click="deleteTodo(todo)"
                            xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash ml-1"
                            width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF5722"
                            fill="none" stroke-linecap="round" stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <line x1="4" y1="7" x2="20" y2="7" />
                            <line x1="10" y1="11" x2="10" y2="17" />
                            <line x1="14" y1="11" x2="14" y2="17" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                todos: '',
                edit: false,
                status: '',
                show_id: false,
                description_id: false,
                form: new Form({
                    title: '',
                    description: ''

                }),
            }
        },
        methods: {
            deleteTodo(e){
                let data = new FormData;
                let answer;
                data.append('_method', 'DELETE');
                console.log(e);
                answer = confirm("Are you sure for deleting " + e.title);
                console.log(answer);
                if (answer == true){
                    axios.post('/api/todo/' + e.id, data).then((res) =>{
                        this.todos = res.data;
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            },
            addDescription(e){
                console.log(e);
                let data = new FormData;
                data.append('_method', 'PATCH');
                data.append('description', this.form.description);
                console.log(data);
                axios.post('/api/todo/' + e.id, data)
                .then( res => {
                    this.getTodos();
                })

            },
            updateTodo(e){
                this.edit = false;
                // e.completed = +e.completed;
                // console.log(e.completed);
                let data = new FormData();
                data.append('_method', 'PATCH');
                data.append('title', e.title);
                // data.append('completed', e.completed);
                axios.post('/api/todo/' + e.id, data)
                .then( response => {
                    this.status = response.data.msg;
                    console.log(this.status);
                    if (response.data.status == 'error'){
                        alert(this.status);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
            },
            getTodos(){
                axios.get('/api/todo').then((res) =>{
                    this.todos = res.data;
                }).catch((error) =>{
                    console.log(error)
                })
            },
            toggleTodo(e){
                e.completed = !e.completed;
                let data = new FormData();
                data.append('_method', 'PATCH');
                if(e.completed == true){
                    console.log(e.completed);
                    data.append('completed', 1);
                    // data.append('title', e.title);
                    axios.post('/api/todo/' + e.id, data)
                }
                if(e.completed == false){
                    console.log(e.completed);
                    data.append('completed', 0);
                    // data.append('title', e.title);
                    axios.post('/api/todo/' + e.id, data)
                }

            },
            saveTodo(){
                let data = new FormData();
                console.log(this.todos.length);
                data.append('title', this.form.title);
                axios.post('/api/todo', data)
                .then( (response) => {
                    console.log('Stored in database');
                    this.status = response.data.msg;
                    console.log(this.status);
                    if (response.data.status == 'error'){
                        alert(this.status);
                    }
                    this.form.reset();
                    this.getTodos();
                    // location.reload();
                })
                .catch( error => {
                    // console.log(error);
                    console.log("ERROR\n");
                    let status = error.response.data.msg;
                    console.log(status);
                    // this.displayNotificationError(err);
                });
            }
        },
        mounted() {
            this.getTodos()
        }
    }
</script>
