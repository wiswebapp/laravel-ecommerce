<template lang="pug">
    <div class="col-md-4" v-if="userData.length">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Users</h3>
            </div>
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    <li v-for="user in userData">
                        <img src="https://randomuser.me/api/portraits/lego/3.jpg" alt="User Image">
                        <a class="users-list-name" href="#">{{user.fname}} {{user.lname}}</a>
                        <span class="users-list-date">{{user.registered_on}}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="javascript:" @click="redirectUser" class="btn btn-sm btn-default">View All <em class=" fa fa-arrow-circle-right"></em></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            userData : [],
        }
    },
    created() {
        this.fetchUserData();
    },
    methods: {
        redirectUser() {
            window.location.href = "user"
        },
        fetchUserData(){
            fetch('vue/getDashboardUser')
                .then(res => res.json())
                .then(res => {
                    this.userData = res
                })
        }
    }
}
</script>
