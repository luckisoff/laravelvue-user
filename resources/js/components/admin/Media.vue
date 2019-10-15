<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Media Files</div>

                    <div class="card-body">
                        <form @submit.prevent="formSubmit" enctype="multipart/form-data">
                        <div class="form-group">
                            <Label for="name">Name:</Label>
                            <input type="text" class="form-control" name="name" v-model="name">
                        </div>

                        <div class="form-group">
                            <input type="file" id="file" name="file" v-on:change="onFileChange">
                        </div>

                        <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                    <h3>Media Files:</h3>
                    <hr>
                    <h4 v-if="media.length==0" class="text-center">No Files</h4>
                    <div v-else class="col-lg-2" v-for="(media) in media" :key="media.id" style='float:left'>
                        <div>
                            <img :src="media.url" :alt="media.name" style="width:100%;">

                            <a href="" onClick="return " @click.prevent="deleteFile(media.id)" class="btn btn-danger btn-sm" style="bottom: 28px;position: relative;right: 0px;">
                                <i class="fa fa-trash-alt"></i>
                            </a>

                            <a href="" onClick="return " @click.prevent="" class="btn btn-danger btn-sm" style="bottom: 28px;position: relative;right: -82px;">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
              name: '',
              file: '',
              myfiles:[],
              media:[],
            }
        },
        mounted(){
            console.log(window.location.hostname)
            this.medias();
            Echo.channel('myfiles')
                .listen('FileAdded',(e)=>{
                    this.media=e.myfiles;
                    this.myfiles=e.myfiles;
                })
        },
        methods: {
            onFileChange(e){
                this.file = e.target.files[0];
            },
            formSubmit(e) {

                nprogress.start()
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let media = new FormData();
                media.append('file', this.file);
                media.append('name',this.name);

                axios.post('/file', media, config)
                .then(response=>{
                    this.medias();
                    toast.fire({
                        'type':'success',
                        'position':'top-left',
                        'title':'Media Uploaded'
                    })
                    this.name='';
                })
                .catch(error=>{
                    console.log(error.response)
                    nprogress.done()
                     toast.fire({
                        'type':'error',
                        'title':'Upload Error'
                    })
                });
            },

            medias(){
                nprogress.start()
                axios.get('/file')
                    .then(response=>{
                        nprogress.done()
                        this.media=response.data.files
                    }).catch(error=>{
                        console.log(error.response)
                    })
            },
            deleteFile(id){
                confirm.fire({
                    title:'Are you sure?'
                }).then((result)=>{
                        if(result.value){
                            axios.get('/file/del/'+id)
                            .then(response=>{
                                toast.fire({
                                    'type':'success',
                                    'title':'Media deleted!'
                                })
                                this.medias()
                            }).catch(error=>{
                                console.log(error.response)
                            })
                        }
                    });

            },
        }
    }
</script>

