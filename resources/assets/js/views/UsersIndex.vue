<template>
    <div class="users">
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>

        <div v-if="message" class="alert">{{ message }}</div>

        <div>
            <button style="float:right;"><router-link :to="{ name: 'users.create' }"><strong style="padding: 5px;">Add New User</strong></router-link></button>
        </div>

        <!--<ul v-if="users">-->
            <!--<li v-for="{ id, name, email } in users">-->
                <!--<strong>Name:</strong> {{ name }},-->
                <!--<strong>Email:</strong> {{ email }}-->
            <!--</li>-->
        <!--</ul>-->

        <!--<ul v-if="users">-->
            <!--<li v-for="{ id, name, email } in users">-->
                <!--<strong>Name:</strong> {{ name }},-->
                <!--<strong>Email:</strong> {{ email }} |-->
                <!--<router-link :to="{ name: 'users.edit', params: { id } }">Edit</router-link>-->
            <!--</li>-->
        <!--</ul>-->

        <table v-if="users" id="userTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="{ id, name, email } in users">
                    <td>
                        {{ name }}
                    </td>
                    <td>
                        {{ email }}
                    </td>
                    <td>
                        <button><router-link :to="{ name: 'users.edit', params: { id } }">Edit</router-link></button>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <strong>10 data show every single page.Click previous and next page and looking your data.</strong>
                    </td>
                    <td>
                        <div class="pagination">
                            <button :disabled="! prevPage" @click.prevent="goToPrev">Previous</button>
                            {{ paginatonCount }}
                            <button :disabled="! nextPage" @click.prevent="goToNext">Next</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import axios from 'axios';

    const getUsers = (page, callback) => {
        const params = { page };

        axios
            .get('/api/users', { params })
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    export default {
        data() {
            return {
                users: null,
                meta: null,
                message: false,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
            };
        },
        computed: {
            nextPage() {
                if (! this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            prevPage() {
                if (! this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        beforeRouteEnter (to, from, next) {
            getUsers(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        // when route changes and this component is already rendered,
        // the logic will be slightly different.
        beforeRouteUpdate (to, from, next) {
            this.users = this.links = this.meta = null
            getUsers(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },
        methods: {
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'users.index',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            setData(err, { data: users, links, meta }) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.users = users;
                    this.links = links;
                    this.meta = meta;
                }
            },

            // fetchData() {
            //     this.error = this.users = null;
            //     this.loading = true;
            //     axios
            //         .get('/api/users')
            //         .then(response => {
            //             this.loading = false;
            //             this.users = response.data;
            //         }).catch(error => {
            //         this.loading = false;
            //         this.error = error.response.data.message || error.message;
            //     });
            // }

            // fetchData() {
            //     this.error = this.users = null;
            //     this.loading = true;
            //     axios
            //         .get('/api/users')
            //         .then(response => {
            //             this.loading = false;
            //             this.users = response.data;
            //         });
            // }

            // fetchData() {
            //     this.error = this.users = null;
            //     this.loading = true;
            //     axios
            //         .get('/api/users')
            //         .then(response => {
            //             console.log(response);
            //         });
            // }
        }
    }
</script>

<style scoped>
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