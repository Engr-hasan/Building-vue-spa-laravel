<template>
    <div>
        <h1 style="text-align: center;">Vue Router App(Learning Purpose)</h1>

        <div class="topnav">
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'hello' }">About</router-link>
            <router-link :to="{ name: 'users.index' }">All Users</router-link>
        </div>
        <br/>

        <div class="container">
            <router-view></router-view>
        </div>

        <br/>
        <div class="topnav" style="padding-top:14px;padding-bottom:14px;text-align: center;">
            <strong style="color:white;">&copy; All Right Reserved</strong>
        </div>
    </div>
</template>
<script>
    export default {}
</script>

<style scoped>
    .topnav {
        overflow: hidden;
        background-color: #333;
        width: 100%;
    }

    .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #4CAF50;
        color: black;
    }

    .topnav a.active {
        background-color: #4CAF50;
        color: white;
    }
</style>