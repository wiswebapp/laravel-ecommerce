<template lang="pug">
    <div class="col-md-6">
        <div class="card card-default">
            <div class="card-body">
                <h4>User Data <small>[Latest top 10]</small></h4>
                <table class="table table-striped projects table-responsive" style="display: inline-table;">
                    <thead>
                        <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in userData" v-bind:key="user.id">
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <img alt="No profile" class="table-avatar" src="https://adminlte.io/themes/v3/dist/img/avatar.png">
                                </li>
                            </ul>
                        </td>
                        <td>{{user.lname}} {{user.fname}}</td>
                        <td>{{user.phone}}</td>
                        <td><span :class="user.status == 'Active' ? 'badge badge-success' : 'badge badge-danger'" >{{user.status}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            userData : [],
            user: {
                id: '',
                fname : '',
                lname : '',
                email : '',
                phone : '',
                status : '',
            },
            user_id : '',
            edit : false
        }
    },
    created() {
        this.fetchUserData();
    },
    methods: {
        fetchUserData(){
            fetch('getDashboardUser')
                .then(res => res.json())
                .then(res => {
                    this.userData = res.userData;
                })
        }
    }
}
</script>
