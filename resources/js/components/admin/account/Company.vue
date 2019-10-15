<template>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Company Details:
                    </div>

                    <div class="card-body">
                        <h3>{{this.company.name}}</h3>
                        <h4>{{this.company.address}}</h4>
                        <h4>{{this.company.phones}}</h4>
                        <h4>{{this.company.type}}</h4>
                    <hr>
                    </div>

                    <div class="card-body">
                        <h4>Transactions Details :</h4>
                        <hr>

                                <form role="form" v-on:submit.prevent="addInvoice" method="POST" class="form-inline">
                                    <table class="table table-bordered table-hover table-sm">
                                    <tr>
                                        <th>
                                    <div class="form-group">
                                        <input type="text" class="form-control-sm form-width" id="description" placeholder="Enter Description" v-model="form.description" name="description" :class="{ 'is-invalid': form.errors.has('description') }">
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    </th>
                                    <th>

                                    <div class="form-group">
                                        <input type="number" class="form-control-sm form-width" id="credit" placeholder="Enter Credit Amount" v-model="form.credit" name="credit" :class="{ 'is-invalid': form.errors.has('credit') }">
                                        <has-error :form="form" field="credit"></has-error>
                                    </div>
                                    </th>
                                    <th>

                                    <div class="form-group">
                                        <input type="number" class="form-control-sm form-width" id="debit" placeholder="Enter Debit Amount" v-model="form.debit" name="debit" :class="{ 'is-invalid': form.errors.has('debit') }">
                                        <has-error :form="form" field="debit"></has-error>
                                    </div>
                                    </th>
                                    <th>

                                    <div class="form-group">
                                        <input type="date" class="form-control-sm form-width" id="duedate" v-model="form.duedate" name="duedate" :class="{ 'is-invalid': form.errors.has('debit') }">
                                        <has-error :form="form" field="debit"></has-error>
                                    </div>
                                    </th>
                                    <th>

                                    <button type="submit" @cleck.prevent class="btn btn-primary btn-sm form-width">Create</button>
                                    </th>
                                    </tr>
                                    </table>
                            </form>

                    <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="7">
                                            <input @keyup="search()" class="form-control" placeholder="Enter search text" type="text" id="searchtext" v-model="searchtext">
                                        </td>
                                    </tr>
                                <tr>
                                    <th>Sl</th>
                                    <th>Invoice No.</th>
                                    <th>Description</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>


                                <tr v-for="(invoice,index) in invoices" :key="invoice.id">
                                    <td>{{index+1}}</td>
                                    <td>{{'00'+invoice.id}}</td>
                                    <td>{{invoice.description}}</td>
                                    <td>{{'Rs. '+invoice.credit}}</td>
                                    <td>{{'Rs. '+invoice.debit}}</td>
                                    <td>{{invoice.duedate}}</td>
                                    <td>
                                        <a  href="" onClick="return " @click.prevent = "deleteInvoice(invoice.id)" class="btn btn-danger btn-sm"><i class='fa fa-trash-alt'></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3">Grand Total</th>
                                    <th>{{'Credits Rs. '+totalCredit}}</th>
                                    <th>{{'Debits Rs. '+totalDebit}}</th>
                                    <th colspan="2">{{'Balance Rs. '+balance}}</th>

                                </tr>
                                <tr>
                                    <td colspan="7">

                                        <ul class="pagination">
                                            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click.prevent="getInvoices(pagination.prev_page_url)">Previous</a></li>
                                            <li class="page-item disabled"><a class="page-link" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                                            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click.prevent="getInvoices(pagination.next_page_url)">Next</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                </tbody>


                            </table>


                    </div>
                </div>
            </div>

        </div>
</template>

<script>
    export default {
        name:'invoices',
        props:['cmp'],
        data(){
            return {
                searchtext:null,
                company:[],
                invoices:[],
                totalCredit:0,
                totalDebit:0,
                balance:0,
                pagination:[],
                form:new Form({
                    description:'',
                    credit:null,
                    debit:null,
                    duedate:null,
                    company_id:null
                }),

            }
        },

         mounted(){
            if(this.cmp){
                this.company=this.cmp;
                this.getInvoices();
            }


        },
        methods:{
            getInvoices(page_url=''){
                page_url=page_url || '/invoice/'+this.company.id
                nprogress.start()
                axios.get(page_url)
                    .then(response=>{
                        nprogress.done()
                        this.invoices=response.data.invoices.data;
                        this.totalCredit=response.data.totalCredit;
                        this.totalDebit=response.data.totalDebit;
                        if(this.company.type=='Vendor'){
                            this.balance=this.totalDebit-this.totalCredit;
                        }else{
                            this.balance=this.totalCredit-this.totalDebit;
                        }

                        this.makePagination(response.data.invoices);
                    }).catch(error=>{
                        toast({
                            type:'error',
                            title:'Something is wrong!'
                    })
                })
            },

            makePagination(invoices){
                if(invoices==''){
                    $('.pagination').hide();
                }else{
                    $('.pagination').show();
                }
                let pagination={
                    current_page:invoices.current_page,
                    last_page:invoices.last_page,
                    next_page_url:invoices.next_page_url,
                    prev_page_url:invoices.prev_page_url
                }
                this.pagination=pagination;
            },
            addInvoice(){
                axios.post('/invoice',{
                    description:this.form.description,
                    credit:this.form.credit,
                    debit:this.form.debit,
                    duedate:this.form.duedate,
                    company_id:this.company.id
                }).then(response=>{
                    this.resetForm();
                    this.getInvoices();
                })
                .catch(error=>{
                    toast.fire({
                        type:'error',
                        title:error.response.data.message
                    })
                })
            },
            deleteInvoice(id){
                axios.get('/invoice/del/'+id)
                .then((response)=>{
                    this.getInvoices();
                    toast.fire({
                        type:'success',
                        title:'A record deleted!'
                    })

                }).catch((error)=>{console.log(error.response)})
            },
            resetForm(){
                this.form.description='';
                this.form.debit=null;
                this.form.credit=null;
                this.form.duedate=null;
                this.form.company_id=null;
            },
            search(){
                nprogress.start()
                if(this.searchtext==''){
                    this.getInvoices();
                }else{
                    axios.get('/search/'+this.company.id+'/'+this.searchtext)
                    .then(response=>{
                        nprogress.done()
                        this.invoices=response.data.invoices;
                        this.makePagination([]);
                    }).catch(error=>{
                        console.log(error.response)
                    })
                }

            }
        }

    }
</script>
