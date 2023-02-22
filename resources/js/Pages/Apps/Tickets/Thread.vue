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
                                        <!-- <span class="font-weight-bold">Department: {{ data.division.name }} </span><br> -->
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
                                <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> [MHBD] SETTING REPORT HASIL PEMERIKSAAN PA</span>
                        </div>
                        <div class="card-body shadow">
                                <span class="font-weight-bold"><i class="fa fa-refresh"></i>Ticket Thread</span>      
                            </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                                <div class="row">
                                    <div class="d-flex docs-highlight">
                                        <div class="pt-0 w-82 docs-highlight">21/02/2023 10:19 PM</div>
                                        <div class="p-0 flex-shrink-2">Support Wyna Pusat</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <Editor id="file-picker"
                                            api-key="no-api-key"
                                            v-model="data.description"
                                    ></Editor>
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
                                        <input class="form-control" type="text" placeholder="Internal Note">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Note Details</label>
                                        <textarea class="form-control" type="text" rows="4" placeholder="Details Description"></textarea>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold">Status *</label>
                                            <select class="form-select">
                                                <option value>Open(Current)</option>
                                                <option>Resolved</option>
                                                <option>Closed</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold">Reassign Ticket *</label>
                                            <select class="form-select">
                                                <option value disabled>Choose One</option>
                                                <option>Tommy</option>
                                                <option>Abi</option>
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

import { Head, Link } from '@inertiajs/inertia-vue3';

import { reactive } from 'vue';

import { Inertia } from '@inertiajs/inertia';

import Editor from '@tinymce/tinymce-vue';
export default {

    layout: LayoutApp,

    components: {
        Head, Link, Editor
    },

    props: {
        data   : Array,
        // thread      : Object,
    },

    setup(props) {
        
    },
}
</script>

<style>

</style>