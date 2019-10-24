<template>
    <div>
        <div v-if="message" class="alert">{{ message }}</div>
        <h2 style="text-align: center;">Create a User</h2>

        <form @submit.prevent="onSubmit($event)">
            <table id="userTable">
                <thead>
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
                        <td>
                            <label for="user_password">Password</label>
                        </td>
                        <td>:</td>
                        <td>
                            <input id="user_password" type="password" v-model="user.password" required/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <button type="submit" :disabled="saving">
                                {{ saving ? 'Creating...' : 'Create' }}
                            </button>
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
                <!--<label for="user_password">Password</label>-->
                <!--<input id="user_password" type="password" v-model="user.password" />-->
            <!--</div>-->
            <!--<div class="form-group">-->
                <!--<button type="submit" :disabled="saving">-->
                    <!--{{ saving ? 'Creating...' : 'Create' }}-->
                <!--</button>-->
            <!--</div>-->
        </form>
    </div>
</template>
<script>
    import api from '../api/users';

    export default {
        data() {
            return {
                saving: false,
                message: false,
                user: {
                    name: '',
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            onSubmit($event) {
                this.saving = true
                this.message = false
                api.create(this.user)
                    .then((response) => {
                        this.message = 'User created Successfylly';
                        setTimeout(() => this.$router.push({ name: 'users.index', params: { id: response.data.data.id } }), 1000);
                    })
                    .catch((e) => {
                        this.message = e.response.data.message || 'There was an issue creating the user.';
                    })
                    .then(() => this.saving = false)
            }
        }
    }
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