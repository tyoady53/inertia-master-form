<template>
    <Head> Create - Master Form</Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-ticket-alt"></i> ADD NEW TICKET</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Ticket Source *</label>
                                                <select v-model="form.ticket_source" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option value="phone">Phone</option>
                                                    <option value="email">Email</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Department</label>
                                                <select v-model="form.department_id" class="form-select" @change="getUser">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Assign To</label>
                                                <select v-model="form.assign_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Help Topic *</label>
                                            <select class="form-select" v-model="form.topic_id" @change="changeTopics">
                                                <option disabled value> Choose One</option>
                                                <option v-for="topic in topics" :key="topic" :value="topic.id">{{ topic.topic_name }}</option>
                                            </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="fw-bold">SLA PLAN</label>
                                                <select v-model="form.sla_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="sla in sla_plans" :key="sla" :value="sla.id">{{ sla.sla_name }} - ({{ sla.sla_hour }} Hours)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">DATE</label>
                                                <input class="form-control" type="time" placeholder="Date" disabled> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Priority *</label>
                                                <select v-model="form.priority" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option>Low</option>
                                                    <option>Normal</option>
                                                    <option>High</option>
                                                    <option>Emergency</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Customer *</label>
                                                <select v-model="form.customer_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option value="1">Diagnos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Branch *</label>
                                                <select v-model="form.branch_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option value="1">Margonda</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Outlet ID</label>
                                        <input v-model="form.outlet_id" class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Section ID</label>
                                        <input class="form-control" type="text" placeholder="Issue">
                                    </div>
<<<<<<< HEAD
=======
                                    
                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Analyzer Name</label>
                                        <input v-model="form.analyzer_name" class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Analyzer ID</label>
                                        <input class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">HID</label>
                                        <input v-model="form.hid" class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Cable Length</label>
                                        <input v-model="form.cable_length" class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Additional com</label>
                                        <input v-model="form.additional_com" class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <!-- LIS CIS MODULES -->
                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Tag Module *</label>
                                            <select v-model="form.tag_module_id" class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="module in tag_modules" :key="module" :value="module.id">{{ module.module_name }}</option>
                                            </select>
                                    </div>

                                    <!-- Reg Key -->
                                    <div class="mb-3" v-if="filter == 3">
                                        <label class="fw-bold">Outlet ID</label>
                                        <input type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 3">
                                        <label class="fw-bold">Outlet Name</label>
                                        <input type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 3">
                                        <label class="fw-bold">Reason For Request</label>
                                        <textarea class="form-control" type="text" rows="4" placeholder="Details Description"></textarea>
                                    </div>

                                    <!-- Report And Data -->
                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Request Type</label>
                                        <option>New</option>
                                        <option>Edit</option>
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Report ID</label>
                                        <input type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Report Name</label>
                                        <textarea type="text" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">PKG</label>
                                        <textarea type="text" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Report Type</label>
                                        <input type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Report Date</label>
                                        <input type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Purpose</label>
                                        <textarea type="text" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Data Displayed</label>
                                        <textarea type="text" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="report">
                                        <label class="fw-bold">Lis Menu Tag</label>
                                            <select class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="menu in lis_menu_app" :key="menu">{{ menu.app_name }}</option>
                                            </select>
                                    </div>

                                    <!-- CIS APP -->
                                    <div class="mb-3" v-if="cis">
                                        <label class="fw-bold">Lis Menu Tag</label>
                                            <select class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="menu in cis_menu_app" :key="menu">{{ menu.app_name }}</option>
                                            </select>
                                    </div>
>>>>>>> 01ca7719d39399009f8afb7a06f8d06527025a78

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Summary *</label>
                                        <input v-model="form.title" class="form-control" type="text" rows="4" placeholder="Issue">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Details</label>
                                        <Editor id="file-picker"
                                            api-key="no-api-key"
                                            v-model="form.description"
                                            :init="{
                                                menubar: false,
                                                plugins: 'lists link image code emoticons print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars',
                                                image_title: true,
                                                automatic_upload: true,
                                                paste_data_images: true, 
                                                toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code | emoticons |',
                                            }">
                                            </Editor>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit">CREATE</button>
                                            <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">RESET</button>
                                        </div>
                                    </div>
                                </form>

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

    import { onMounted, reactive, ref, watch } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    import Editor from '@tinymce/tinymce-vue';

    import Swal from 'sweetalert2';

    import axios from 'axios';

    export default {
        layout: LayoutApp,

        components: {
            Head,
            Link,
            Editor
        },

        props:{
            // departments: Array,
            topics: Array,
            // users: Array,
            sla_plans: Array,
            tag_modules: Array,
            lis_menu_app: Array,
            cis_menu_app: Array
        },

        data: () => ({
            filter: '',
        }),

        methods: {
            changeTopics: function(value) {
                value = value.target.value;
                this.filter = value;
                // console.log(value)
                // if(this.topic_id) {
                //     // console.log(topic_id)
                //     // this.filter == topic_id
                // }else{
                //     this.filter = false;
                // }
            },
        },

        setup(props) {

            const departments = ref({})

            const users = ref({
                getUser: false,
            })

            // const filter = ref({
            //     filter: ''
            // })

            const form = reactive({
                ticket_source:  '',
                department_id:  '',
                assign_id:      '',
                topic_id:       '',
                sla_id: '',
                priority: '',
                customer_id: '',
                branch_id: '',
                title: '',
                description: ''
            });

            onMounted(() => {

            axios.get(UrlOrigin+`/api/deparments`).then(response => {
                departments.value = response.data.data
                })
                .catch(error => {
                    console.log(error.response.data)
                })

            })

            function getUser() {
                axios.post(UrlOrigin+`/api/user`,{
                    id: form.department_id,
                }).then(response => {
                    users.value = response.data.data
                }).then(() => {
                    this.users.getUser = true
                })
                .catch(error => {
                    console.log(error.response.data)
                })
            }

            // function changeTopics() {
            //     if(this.topic_id) {
            //         this.filterTopic = this.topic_id
            //     }else{
            //         this.filterTopic = false
            //     }
            // }
            
            const submit = () => {
                Inertia.post('/apps/master/tickets/store', {
                    ticket_source:  form.ticket_source,
                    department_id:  form.department_id,
                    assign_id:      form.assign_id,
                    topic_id:       form.topic_id,
                    sla_id:         form.sla_id,
                    priority:       form.priority,
                    customer_id:    form.customer_id,
                    branch_id:      form.branch_id,
                    title:          form.title,
                    description:    form.description,
                    outlet_id: form.outlet_id,
                    analyzer_name: form.analyzer_name,
                    hid: form.hid,
                    cable_length: form.cable_length,
                    additional_com: form.additional_com
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
            return {
            form,
            departments,
            users,
            getUser,
            submit
        }
        }
        
    }
</script>

<style>

</style>