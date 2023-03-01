<template>
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold">Internal Note</span>
                        </div>
                        <div class="card-body">
                            <!-- <form @submit.prevent="submit"> -->
                            <div class="row">
                                <div class="mb-3">
                                        <label class="fw-bold">Internal Note *</label>
                                        <input class="form-control" type="text" v-model="form.title" placeholder="Internal Note">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Note Details</label>
                                        <Editor
                                        v-model="form.description"
                                        >
                                        </Editor>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">File Upload</label>
                                        <input type="file" id="upload-file" ref="uploadfiles" multiple class="form-control" @change="fieldChange">
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold">Status *</label>
                                            <select class="form-select">
                                                <option value="open">Open(Current)</option>
                                                <option value="resolved">Resolved</option>
                                                <option value="closed">Closed</option>
                                            </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold">Reassign Ticket *</label>
                                            <select v-model="form.assign_id" class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                            </select>
                                    </div>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary shadow-sm rounded-sm" type="submit" @click="uploadFile">SEND</button>            
                                </div>
                            </div>
                        <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue';

    import axios from 'axios';

export default {

    components: {
        Editor
    },

    data() {
        return {
            attachment: [],
            // users: [],
            form: new FormData,
           
        }
    },

    methods: {
        fieldChange(e) {

            let selectedFiles = e.target.files;

            if(!selectedFiles.length) {
                return false;
            }
            
            for(let i=0;i<selectedFiles.length;i++){
                    this.attachment.push(selectedFiles[i]);
                }

            console.log(this.attachment)

        },

        async getUsers(){
            await axios.get(`http://localhost:8000/api/users`).then(response => {
                this.users = response.data.data
                // console.log(this.users)
                })
                .catch(error => {
                    console.log(error.response.data)
                })
        },  

        uploadFile() {
            for(let i=0; i<this.attachment.length;i++){
                    this.form.append('image',this.attachment[i]);
                }
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                document.getElementById('upload-file').value=[];
                
                axios.post('/apps/master/tickets/thread',this.form,config).then(response=>{
                    //success
                    console.log(response);
                })
                    .catch(response=>{
                        //error
                    });
            }
        // submit(){
    
        //     for(let i=0; i<this.image.length;i++){
        //             this.form.append('image[]',this.image[i]);
        //         }
        //         // const config = { headers: { 'Content-Type': 'multipart/form-data' } };
        //         document.getElementById('upload-file').value=[];
    
        //         Inertia.post('/apps/master/tickets/thread', {
        //             helpdesk_id: form.helpdesk_id,
        //             title: form.title,
        //             description: form.description,
        //             // assign_id: form.assign_id,
        //             // attachment: form.attachment,  
        //             file_upload: form.file_upload,
        //             image: this.form
        //         }, {
        //             onSuccess: () => {
        //                 Swal.fire({
        //                     title: 'Success!',
        //                     text: 'Ticket saved successfully.',
        //                     icon: 'success',
        //                     showConfirmButton: false,
        //                     timer: 2000
        //                 });
        //             },
        //         });
        //     },
    },


    async mounted() {
        // console.log('Component mounted.')
        await this.getUsers();
        this.user = this.users;
        console.log(this.user)
    }
}
</script>

<style>

</style>