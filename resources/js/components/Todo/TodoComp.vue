<template>
    <div class="todo-app">
        <!-- div to recieve input as task -->
        <div class="add-todo text-left border border-success">
            <input
                type="text"
                name="input-todo"
                class="col-9 pt-2"
                placeholder="What needs to be done?"
                v-model="newTodo"
                @keyup.enter="addTodo()"
            />
            <button
                @click="addTodo()"
                class="btn btn-success float-right col-3"
            >
                Add
            </button>
        </div>
        <!-- view the task as table and control it  -->
        <div class="view text-left" v-if="todos.length > 0">
            <div class="view-table">
                <table
                    class="table table-success table-hover table-bordered shadow-lg m-0"
                >
                    <thead class="table-info">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="(todo, index) in todos" :key="todo.todo_id">
                        <tr>
                            <td class="table-info">{{ index + 1 }}</td>
                            <td>
                                <div>
                                    <p class="todo-view">
                                        {{ todo.todo_name }}
                                    </p>
                                </div>
                            </td>
                            <td
                                class="btn-secondary"
                                :class="{ completed: todo.todo_completed }"
                            >
                                <span class="" v-if="todo.todo_completed"
                                    >Ok, Completed</span
                                >
                                <span class="" v-else
                                    >Sorry, Not Completed</span
                                >
                            </td>
                            <td>
                                <div class="row">
                                    <button
                                        type="button"
                                        class="btn btn-secondary p-1 col-lg-6 col-sm-7 m-lg-2 m-sm-3"
                                        :class="{
                                            btnCompleted: !todo.todo_completed
                                        }"
                                        @click="completed(todo)"
                                    >
                                        <span
                                            class=""
                                            v-if="!todo.todo_completed"
                                            >Completed</span
                                        >
                                        <span class="" v-else
                                            >Un Completed</span
                                        >
                                    </button>
                                    <button
                                        @click="deleteTodo(todo.todo_id)"
                                        class="btn btn-danger col-lg-2 col-sm-7 m-lg-1 m-sm-3"
                                    >
                                        <font-awesome-icon icon="trash-alt" />
                                    </button>
                                    <!-- Trigger the modal with a button -->
                                    <button
                                        type="button"
                                        class="btn btn-info col-lg-2 col-sm-7 m-lg-1 m-sm-3"
                                        data-toggle="modal"
                                        data-target="#myModal"
                                        @click="editTodo = todo"
                                    >
                                        <font-awesome-icon icon="edit" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal to edit Todo name -->
        <div id="myModal" class="modal fade mt-5 p-5" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Todo Name</h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                        >
                            &times;
                        </button>
                    </div>
                    <div class="modal-body container">
                        <div class="" v-if="editTodo != null">
                            <input
                                type="text"
                                name="edit-name"
                                class="form-control"
                                placeholder="Enter New Todo Name"
                                v-model="editTodo.todo_name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="editingTodo(editTodo)"
                        >
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
var storage = {
    fetchTodos: function() {
        var todos = [];
        function get() {
            return axios
                .get("/api/todo")
                .then(res => {
                    return res.data;
                })
                .catch(err => {
                    console.log(err);
                });
        }
        const todo = get();
        todo.then(dt => {
            if (dt.length) {
                var i = 0;
                todos.push(dt[i++]);
                for (; i < dt.length; i++) {
                    todos.push(dt[i]);
                }
            } else todos = [];
        });
        return todos;
    }
};

export default {
    name: "TodoComp",
    data: function() {
        return {
            newTodo: "",
            todos: storage.fetchTodos(),
            editTodo: null
        };
    },
    methods: {
        addTodo() {
            var value = this.newTodo && this.newTodo.trim();
            if (!value) {
                return;
            }
            this.newTodo = "";
            var id = 1;
            if (this.todos.length) {
                id = this.todos[this.todos.length - 1].todo_id + 1;
            }
            const todo = {
                todo_id: id,
                todo_name: value,
                todo_completed: false
            };
            this.todos.push(todo);
            axios
                .post("api/todo", todo)
                .then(todo => {
                    console.log(todo);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        deleteTodo(id) {
            axios
                .delete(`api/todo/${id}`)
                .then(todo => {
                    console.log(todo);
                })
                .catch(err => {
                    console.log(err);
                });
            const indexOfTodo = this.todos.findIndex(
                todo => todo.todo_id == id
            );
            this.todos.splice(indexOfTodo, 1);
        },
        editingTodo: function(todo) {
            // Edit in api
            axios
                .put(`api/todo/${todo.todo_id}`, {
                    todo_name: this.editTodo.todo_name,
                    todo_completed: todo.todo_completed
                })
                .then(todo => {
                    console.log(todo);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        completed: function(todo) {
            const indexOfTodo = this.todos.findIndex(
                tod => tod.todo_id == todo.todo_id
            );
            this.todos[indexOfTodo].todo_completed = !this.todos[indexOfTodo]
                .todo_completed;
            axios
                .put(`api/todo/${todo.todo_id}`, this.todos[indexOfTodo])
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
<style lang="scss" scoped>
.todo-app {
    width: 100%;
    .add-todo {
        height: 50px;
        input,
        button {
            font-size: 150%;
            outline: none;
            border: none;
        }
    }
    .view {
        width: 100%;
        float: left;
        button {
            outline: none;
            border: none;
            margin: 0;
            font-size: 110%;
            vertical-align: baseline;
            font-family: inherit;
            font-weight: inherit;
            color: #fff;
            &:focus {
                outline: none;
                border: none;
            }
        }
        .view-table {
            height: 400px;
            overflow: scroll;
            //p to show todo name
            .todo-view {
                width: 70%;
            }
        }
    }
   }
.completed {
    background-color: #38c172;
    font-weight: bold;
}
.btnCompleted {
    background: #38c172;
    &:hover {
        background: #0e7a3b;
    }
}
</style>
