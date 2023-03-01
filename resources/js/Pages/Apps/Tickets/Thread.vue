<template>
    <Head> Threads - Master Form </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> Threads</span>
                        </div>
                        <div class="card-body">
                            <span class="font-weight-bold"><i class="fa fa-refresh"></i>Ticket #{{ data.thread_id }}</span>
                            <div class="card-body">
                                <div class="row shadow mt-2 p-2">
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">Status: {{ data.status }} </span><br>
                                        <span class="font-weight-bold">Priority: {{ data.priority }} </span><br>
                                        <span class="font-weight-bold">Department: {{ data.division.name }} </span><br>
                                        <span class="font-weight-bold">Create Date: {{ data.duedate }} </span><br>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">User: {{ data.user.name }} </span><br>
                                        <span class="font-weight-bold">Email: {{ data.user.email }}</span><br>
                                        <span class="font-weight-bold">Phone: {{ data.user.handphone }}</span><br>
                                        <span class="font-weight-bold">Source: {{ data.ticket_source }} </span><br>
                                    </div>
                                </div>
                                
                                <div class="row shadow mt-2 p-2">
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">Assigned To: {{ data.assign.name }} </span><br>
                                        <span class="font-weight-bold">SLA Plan: {{ data.sla.sla_name }} </span><br>
                                        <span class="font-weight-bold">Due Date: {{ data.duedate }}</span><br>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">Help Topic: {{ data.topic.topic_name }} </span><br>
                                        <span class="font-weight-bold">Last Message: Masih On Proses</span><br>
                                        <span class="font-weight-bold">Last Response: Masih On Proses</span><br>
                                    </div>
                                </div>

                                <div class="row shadow mt-2 p-2">
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">Outlet ID: {{ data.outlet_id }} </span><br>
                                        <span class="font-weight-bold">Analyzer Name: {{ data.analyzer_name }}</span><br>
                                        <span class="font-weight-bold">Analyzer ID: {{ data.analyzer_hid }} </span><br>
                                        <span class="font-weight-bold">HID: {{ data.hid }}</span><br>
                                    </div>
                                </div>

                                <div v-if="data.topic.id == 3" class="row shadow mt-2 p-2">
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">Tag Module: </span><br>
                                    </div>
                                </div>
        
                                <div v-if="data.topic.id == 4" class="row shadow mt-2 p-2">
                                    <div class="col-md-6">
                                        <span class="font-weight-bold">Request Type: </span><br>
                                        <span class="font-weight-bold">Setting Report: </span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> {{ data.title }}</span>
                        </div>
                        <div class="card-body shadow">
                                <span class="font-weight-bold"><i class="fa fa-refresh"></i>Ticket Thread</span>      
                        </div>
                        <div class="card-body shadow">
                                <div v-html="data.description"></div>
                            <div class="alert alert-secondary m-1 p-2">
                                <a :href="`/storage/helpdesk/${data.file_upload}`" target="_blank" >{{ data.file_upload }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-for="thread in threads" :key="thread" class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                                <div class="row">
                                    <div class="d-flex docs-highlight">
                                        <div class="pt-0 w-82 docs-highlight">{{ thread.title }}</div>
                                        <div class="p-0 flex-shrink-2">{{ thread.user.name }}</div>
                                    </div>
                                    <div class="d-flex docs-highlight">
                                        <div class="p-0 flex-shrink-2">{{ thread.created_at }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                  <div v-html="thread.description" />
                                    <div v-for="file in thread.files" :key="file" class="alert alert-secondary m-1 p-2">
                                        <a :href="`/storage/helpdesk/${file.image}`" target="_blank">{{ file.image }}</a>
                                    </div>
                                </div>
                                
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold">Internal Note</span>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submit">
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
                                        <input type="file" id="uploadfiles" ref="uploadfiles" multiple class="form-control" @change="fieldChange">
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold">Reassign Ticket *</label>
                                            <select v-model="form.assign_id" class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SEND</button>            
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

import LayoutApp from '../../../Layouts/App.vue';

import { Head, Link} from '@inertiajs/inertia-vue3';

import { reactive, ref } from 'vue';

import { Inertia } from '@inertiajs/inertia';

import Swal from 'sweetalert2';

import Editor from '@tinymce/tinymce-vue';

export default {

    layout: LayoutApp,

    components: {
        Head, Link, Editor
    },

    props: {
        data : Object,
        users : Array,
        threads: Array,
        files: Array
    },

    setup(props) {

        const form = reactive({
            helpdesk_id: props.data.thread_id,
            title: '',
            description: '',
            assign_id: '',
            file_upload: [],
            uploadfiles: []
        })

        const fieldChange = (e) => {

            let selectedFiles = e.target.files;
            
            console.log(selectedFiles)

            if(!selectedFiles.length) {
                return false;
            }

            for(let i=0;i<selectedFiles.length;i++){
                    form.uploadfiles.push(selectedFiles[i]);
                }

            console.log(form.uploadfiles)

        }

        const submit = () => {
                Inertia.post('/apps/master/tickets/thread', {
                    helpdesk_id: form.helpdesk_id,
                    title: form.title,
                    description: form.description,
                    assign_id: form.assign_id,
                    file_upload: form.file_upload,
                    image: form.uploadfiles
                }, {
                    onSuccess: () => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Ticket saved successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }

            return{
                submit,
                fieldChange,
                form
            }
    },
}
</script>

<style>

</style>