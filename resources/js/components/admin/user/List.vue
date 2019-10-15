<template>
    <div>
         <section class="content">
            <div class="row" >
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">

                            <div  class="card-tools">
                                <router-link v-if="$auth.can('create user')" to="/new-user" style="color:#fff">
                                    <a href="#" class="btn btn-info btn-sm"><span class='fa fa-plus' ></span> New</a>
                                </router-link>
                                <a v-if="$auth.can('delete user')" href="#" @click.prevent="deleteSelected()" class="btn btn-info btn-sm"><span class='fa fa-cut' ></span> Del</a>
                                <a v-if="$auth.can('edit user')" href="#" class="btn btn-info btn-sm"><span class='fa fa-pen' ></span> Edit</a>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>

                                        <input type="checkbox" @click.prevent="selectAll" v-model="all_select">
                                        <span v-if="all_select==false">Check All</span>
                                        <span v-else>Uncheck All</span>
                                    </th>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Role</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(user,index) in getAllUsers" :key="user.id">
                                    <td><input type="checkbox" v-model="userItem" :value="user.id" ></td>
                                    <td>{{index+1}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.created_at}}</td>
                                    <td>
                                        <span v-for="(role) in user.roles" :key="role.id">{{role.name}}</span>
                                    </td>
                                    <td>
                                         <a v-if="user.email!=$auth.user.email&$auth.can('delete user')" href="" @click.prevent="deleteUser(user.id)">Delete</a>
                                    </td>
                                </tr>
                                </tbody>


                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
</template>
<script>
    export default {
        name: "List",
        data(){
            return{
                userItem:[],
                select:'',
                all_select:false
            }
        },
        mounted(){
            this.$store.dispatch("getAllUser")
        },
        computed:{
           getAllUsers(){
            return this.$store.getters.getAllUser
           }
        },
        methods:{
            deleteUser(id){
                confirm.fire({
                    title:'Are you sure?'
                }).then((result) => {
                    if (result.value) {
                            axios.get('/del-user/selected/'+id)
                            .then((response)=>{
                            this.$store.dispatch("getAllUser")
                            toast.fire({
                                type: 'success',
                                title: 'User deleted successfully'
                            })
                        })
                    }
                });

            },
            deleteSelected(){
                if(this.userItem.length>0){
                    console.log(this.userItem)
                    confirm.fire({
                        title:'Are you sure?'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('/del-user/selected/'+this.userItem)
                                .then((response)=>{
                                    this.userItem = []
                                    this.$store.dispatch("getAllUser")
                                    swal.fire({
                                        type: 'success',
                                        title: 'Users deleted successfully'
                                })

                            })
                        }
                    });
                }

            },
            selectAll(){
                if(this.all_select==false){
                    this.all_select = true
                    for(var user in this.getAllUsers){
                        this.userItem.push(this.getAllUsers[user].id)
                    }
                }else{
                    this.all_select = false
                    this.userItem = []
                }


            }
        }
    }
</script>

<style scoped>
</style>


