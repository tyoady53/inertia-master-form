<template>
    <Head>
        <title>FORMS - Master Reports</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold"><i class="fa fa-form"></i> Master Reports - {{ table_name.description }}</span>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div  class="mb-3" v-if="user_role.includes('staff')">
                                            <input type="hidden" name="user" v-model="user">
                                        </div>
                                        <div  class="mb-3" v-else>
                                            <label class="form-label fw-bold">Select User</label>
                                            <select class="form-control" v-model="user">
                                                <option :value="null" disabled selected>-- Users --</option>
                                                <option v-for="user in users" :key="user" :value="user.id">{{ user.name }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">START DATE</label>
                                            <input type="date" v-model="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">END DATE</label>
                                            <input type="date" v-model="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">*</label>
                                            <button type="button" class="btn btn-md btn-purple border-0 shadow w-100" @click="getFormData"><i class="fa fa-filter"></i> FILTER</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div v-if="table_data">
                                <hr>
                                <div class="export text-end mb-3">
                                    <a :href="`/apps/master/reports/${table}/export?user=${selected_user}&start_date=${start_date}&end_date=${end_date}`" target="_blank" class="btn btn-success btn-md border-0 shadow me-3"><i class="fa fa-file-excel"></i> EXCEL</a>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <th class="text-center" v-if="extend == '1'"  style="width:100px;"> #ID </th>
                                            <th class="text-center" v-for="header in headers" :key="header"> {{ header.field_description }}</th>
                                            <th class="text-center" v-if="status_report == '1'">Status</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="form in table_data" :key="form">
                                                <template v-if="table == 'master_customer_branches'">
                                                    <td>
                                                        {{ form.outlet_id }}
                                                    </td>
                                                    <td>
                                                        {{ form.customer_name }}
                                                    </td>
                                                    <td>
                                                        {{ form.customer_branch }}
                                                    </td>
                                                </template>
                                                <template v-else>
                                                    <td v-for="header in table_heads">
                                                        <div v-if="header.value=='index_id'" class="text-center">
                                                            {{ form.index_id }}
                                                        </div>
                                                        <div v-else>
                                                            <div v-if="header.type === 'Longtext'">
                                                                <div v-if="form[header.value].length > 100">
                                                                    <p v-html="form[header.value].substring(0,100)+ ' ...'"></p>
                                                                </div>
                                                                <div v-else>
                                                                    <p v-html="form[header.value]"></p>
                                                                </div>
                                                            </div>
                                                            <div v-else-if="header.type === 'File'">
                                                                <div v-if="form[header.value]">
                                                                    <a :href="`/storage/${form[header.value]}`" target="_blank" >{{ "..."+form[header.value].substring(form[header.value].length-15,form[header.value].length) }}</a>
                                                                </div>
                                                            </div>
                                                            <div v-else>
                                                                <p v-html="form[header.value]"></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
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

import { Inertia } from '@inertiajs/inertia';

import { ref } from 'vue';

import pagination from 'laravel-vue-pagination/src/Bootstrap5Pagination'

import Swal from 'sweetalert2';

import axios from 'axios';

export default {    
    layout: LayoutApp,

    components: {
        Head, 
        Link,
        pagination,
    },

    props:{
        table: String,
        users: Array,
        selected: Array,
        table_name: String,
        headers: Array,
        forms:Object,
        csrfToken: String,
        data: Array,
        user_role:String,
        user_id:String,
        selected_user:String,
        status_report: String,
        extend: String,
    },

    data: () => ({
        table_heads : [],
        table_heads_use : [],
        table_content : [],
        table_data : [],
    }),

    created: function(){
        this.TableHeader();
        this.fillTableHeadUse();
        this.getFormData()
    },

    methods: {
        getFormData() {
            var usr_id = '';
            if(this.start_date && !this.end_date){
                this.fillFIlter('Fill End Date')
            }
            else if(this.end_date && !this.start_date){
                this.fillFIlter('Fill Start Date')
            } else {
                if(this.user_role.includes('staff')){
                    usr_id = this.user_id
                } else {
                    usr_id = this.user
                }
                console.log(usr_id)
                var UrlOrigin = window.location.origin;
                axios.get(UrlOrigin+`/api/`+this.table+`/generate_report/`+usr_id+'/?'
                    + 'start_date=' + this.start_date
                    + '&end_date=' + this.end_date
                    ).then(response => {
                    this.table_data = response.data.data.forms;
                }).catch(error => {
                    console.log(error)
                }) ;
            }
        },

        TableHeader(){
            console.log(this.table_name)
            if(this.table_name.extend == '1'){
                this.table_heads.push({
                    value : "index_id",name : "#ID",type: "Text"
                });
            }
            for(let i = 0 ; i < this.headers.length ; i++) {
                let structures = this.headers[i];
                let value = structures.field_name;
                let name = structures.field_description;
                let type = structures.input_type;
                this.table_heads.push({value,name,type});
                if(structures.input_type.split('#')[0] == 'Parent'){
                    parent = structures.input_type.split('#')[1]
                }
            }
            if(this.table_name.status == '1'){
                this.table_heads.push({
                    value : "status_report",name : "Status",type: "Text"
                });
            }
            return this.table_heads
        },

        fillTableHeadUse() {
            for(var i = 0; i < this.table_heads.length; i++){
                let structure = this.table_heads[i];
                var label = structure.name;
                var field = structure.value;
                this.table_heads_use.push({label,field});
            }
        },
    },

    watch:{
        paginate: function(value){
            this.getFormData();
        },
        search: function(value){
            this.getFormData();
        },
    },

    setup(props) {
        const fillFIlter = (message) => {
            Swal.fire({
                toast: true,
                title: 'Info',
                text: message,
                icon: 'info',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        }

        const user = ref('' || (new URL(document.location)).searchParams.get('user'));
        const start_date = ref('' || (new URL(document.location)).searchParams.get('start_date'));
        const end_date = ref(''|| (new URL(document.location)).searchParams.get('end_date'));
        const url = props.table;

        const filter = () => {
            Inertia.get(`/apps/master/reports/${url}/filter`, {
                user : user.value,
                start_date: start_date.value,
                end_date: end_date.value,
            });
        }

        const reset = () => {
            Inertia.get(`/apps/master/reports/${url}/show`, {

            });
        }

        return {
            start_date,
            end_date,
            user,
            fillFIlter,
            filter,
            reset
        }
    }

}

</script>