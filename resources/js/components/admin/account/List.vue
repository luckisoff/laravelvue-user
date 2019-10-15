<template>
    <div>
         <section class="content">
            <div class="row justify-content-around" >
                <div class="col-12 ">
                    <h3>Companies :</h3>
                    <div class="card">
                        <div class="card-header">
                            <a href="#"  class="btn btn-primary btn-sm" @click.prevent="formReset()" data-toggle="modal" data-target="#modal">
                                <i class="fa fa-pen"></i>
                            </a>
                        </div>

                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Company</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" v-on:submit.prevent="addCompany()" method="POST">

                                    <div class="form-group">
                                        <label for="Name" class="col-form-label">Company Name:</label>
                                        <input type="text" placeholder="Enter Company Name*" class="form-control" id="name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="Owner" class="col-form-label">Company Owner:</label>
                                        <input type="text" placeholder="Enter Company Owner Name" class="form-control" id="owner" v-model="form.owner" name="owner" :class="{ 'is-invalid': form.errors.has('owner') }">
                                        <has-error :form="form" field="owner"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="Address" class="col-form-label">Company Address:</label>
                                        <input type="text" placeholder="Enter Company Address" class="form-control" id="address" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }">
                                        <has-error :form="form" field="address"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="Phones" class="col-form-label">Company Phones:</label>
                                        <input type="text" class="form-control" placeholder="Enter Company Phones" id="phones" v-model="form.phones" name="phones" :class="{ 'is-invalid': form.errors.has('phones') }">
                                        <has-error :form="form" field="phones"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="Type" class="col-form-label">Company Type:</label>
                                        <select name="type" id="type" v-model="form.type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                            <option value="">Select</option>
                                            <option value="Client">Client</option>
                                            <option value="Vendor">Vendor</option>
                                        </select>
                                        <has-error :form="form" field="type"></has-error>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><span v-if="this.edit">Save</span><span v-else>Create</span></button>
                                    </div>
                                </form>
                            </div>

                            </div>
                        </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Phone</th>
                                    <th>Balance</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(company,index) in getAllCompanies.companies" :key="company.id">
                                    <td>{{index+1}}</td>
                                    <td>{{company.name}}</td>
                                    <td>{{company.type}}</td>
                                    <td>
                                        <span v-if="company.phones">{{company.phones}}</span>
                                        <span v-else>None</span>
                                    </td>
                                    <td>{{'Rs. '+getAllCompanies.balance[company.id]}}</td>
                                    <td>
                                        <a  href="" onClick="return " @click.prevent = "deleteCompany(company.id)" class="btn btn-danger btn-sm"><i class='fa fa-trash-alt'></i></a>
                                        <a  href="" onClick="return "  @click.prevent = "editCompany(company)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal"><i class='fa fa-edit'></i></a>
                                        <router-link :to="{name:'company',params:{cmp:company}}" class="btn btn-primary btn-sm">
                                                <i class='fa fa-eye'></i>
                                        </router-link>
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
        name: "modal",
        data(){
            return {
                form: new Form({
                    name:'',
                    owner:'',
                    type:'',
                    address:'',
                    phones:''
                }),
                edit:false,
                companyItem:[],

            }
        },

         mounted(){
            this.$store.dispatch("getAllCompanies")
        },
        computed:{
           getAllCompanies(){
            return this.$store.getters.getAllCompanies
           }
        },

        methods:{
            addCompany(){
                if(!this.edit){
                //savenew
                 this.form.post('/company/create')
                    .then((response)=>{
                        $('#modal').modal('hide');
                        this.$store.dispatch('getAllCompanies')
                        this.formReset();
                        toast.fire({
                            type: 'success',
                            title: 'Company Added successfully'
                        })

                    })
                    .catch((error)=>{})
                //savenew end
                }else{
                    //edit
                    this.form.post('/company/edit')
                    .then((response)=>{
                        $('#modal').modal('hide');
                        this.$store.dispatch('getAllCompanies')
                        this.formReset();
                        toast.fire({
                            type: 'success',
                            title: 'Edit successfully'
                        })
                    })
                    .catch((error)=>{console.log(error.response)})
                    //editend
                }

                },

            editCompany(company){
                this.edit=true
                this.form.id=company.id;
                this.form.name=company.name;
                this.form.owner=company.owner;
                this.form.address=company.address;
                this.form.phones=company.phones;
                this.form.type=company.type;
            },

            deleteCompany(id){

                confirm.fire({
                    title:'Are you sure?'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/company/del/'+id)
                            .then(response=>{
                                this.$store.dispatch('getAllCompanies')
                                toast.fire({
                                    type:'success',
                                    title:'A Company has been deleted!'
                                })
                            }).catch(error=>{
                                toast({
                                    type:'error',
                                    title:'Error!'
                                })
                        })
                    }
                });
            },
            formReset(){
                this.edit=false;
                this.form.name='';
                this.form.owner='';
                this.form.phones='';
                this.form.address='';
                this.form.type='';
            }
        }
    }
</script>

<style scoped>
</style>


