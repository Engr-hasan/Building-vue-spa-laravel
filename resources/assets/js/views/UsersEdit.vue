<template>
    <div>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="! loaded">Loading...</div>
        <form @submit.prevent="onSubmit($event)" v-else>
            <table id="userTable">
                <thead>message
                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <button style="float:right;"><router-link :to="{ name: 'users.index' }"><strong style="padding: 5px;">Go-Back-List</strong></router-link></button>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="user_name">Name</label>
                        </td>
                        <td>:</td>
                        <td>
                            <input id="user_name" v-model="user.name" required/>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="user_email">Email</label>
                        </td>
                        <td>:</td>
                        <td>
                            <input id="user_email" type="email" v-model="user.email" required/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <button type="submit" :disabled="saving">Update</button>
                            <button :disabled="saving" @click.prevent="onDelete($event);">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!--<div class="form-group">-->
                <!--<label for="user_name">Name</label>-->
                <!--<input id="user_name" v-model="user.name" />-->
            <!--</div>-->
            <!--<div class="form-group">-->
                <!--<label for="user_email">Email</label>-->
                <!--<input id="user_email" type="email" v-model="user.email" />-->
            <!--</div>-->
            <!--<div class="form-group">-->
                <!--<button type="submit" :disabled="saving">Update</button>-->
                <!--<button :disabled="saving" @click.prevent="onDelete($event);">Delete</button>-->
            <!--</div>-->
        </form>
    </div>
</template>
<script>
    import api from '../api/users';

    export default {
        data() {
            return {
                message: null,
                loaded: false,
                saving: false,
                user: {
                    id: null,
                    name: "",
                    email: ""
                }
            };
        },
        methods: {
            onSubmit(event) {
                this.saving = true;

                api.update(this.user.id, {
                    name: this.user.name,
                    email: this.user.email,
                }).then((response) => {
                    this.message = 'User updated Successfylly';
                    setTimeout(() => this.$router.push({ name: 'users.index' }), 1000);
                    this.user = response.data.data;
                }).catch(error => {
                    console.log(error)
                }).then(_ => this.saving = false);
            },
            onDelete() {
                alert('Are you sure to Delete?')
                this.saving = true;
                api.delete(this.user.id)
                    .then((response) => {
                        this.message = 'User deleted Successfully';
                        setTimeout(() => this.$router.push({ name: 'users.index' }), 1000);
                    });
            }
        },
        created() {
            // api.find(this.$route.params.id).then((response) => {
            //     this.loaded = true;
            //     this.user = response.data.data;
            // });

            api.find(this.$route.params.id).then((response) => {
                setTimeout(() => {
                    this.loaded = true;
                    this.user = response.data.data;
                }, 1000);
            });

            api.find(this.$route.params.id)
                .then((response) => {
                    this.loaded = true;
                    this.user = response.data.data;
                })
                .catch((err) => {
                    this.$router.push({ name: '404' });
                });
        }
    };
</script>
<style scoped>
    .form-group label {
        display: block;
    }
    .alert {
        background: lightgreen;
        color: black;
        padding: 1rem;
        margin-bottom: 1rem;
        width: 100%;
        border: 1px solid darkgreen;
        border-radius: 5px;
    }

    #userTable {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #userTable td, #userTable th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #userTable tr:nth-child(even){background-color: #f2f2f2;}

    #userTable tr:hover {background-color: #ddd;}

    #userTable th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>
