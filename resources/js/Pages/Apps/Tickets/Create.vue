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
                                            <div class="mb-3" v-if="users.getUser">
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

                                    {{ form.topic_id }}

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="fw-bold">SLA PLAN</label>
                                                <select v-model="form.sla_id" class="form-select" @change="getSla">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="sla in sla_plans" :key="sla" :value="sla.id">{{ sla.sla_name }} - ({{ sla.sla_hour }} Hours)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">DATE</label><br>
                                                <input class="form-control" :value="slas.data" readonly>
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
                                                <select v-model="form.customer_id" class="form-select" @change="getBranch">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="customer in master_customers" :key="customer" :value="customer.id">{{ customer.customer_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="fw-bold">Branch *</label>
                                                <select v-model="form.branch_id" class="form-select">
                                                    <option disabled value> Choose One</option>
                                                    <option v-for="branch in filteredChain" :key="branch.id" :value="branch.id">{{ branch.customer_branch }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- tag interfacing -->
                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Outlet ID</label>
                                        <input v-model="form.outlet_id" class="form-control" type="text" placeholder="Issue">
                                    </div>

                                    <div class="mb-3" v-if="filter == 1">
                                        <label class="fw-bold">Section ID</label>
                                        <input class="form-control" type="text" placeholder="Issue">
                                    </div>
                                    
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

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Outlet ID</label>
                                        <input v-model="form.outlet_id" class="form-control" type="text" placeholder="Outlet ID">
                                    </div>

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Section ID</label>
                                        <input class="form-control" type="text" placeholder="Section ID">
                                    </div>

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Analyzer Name</label>
                                        <input v-model="form.analyzer_name" class="form-control" type="text" placeholder="Analyzer Name">
                                    </div>

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Analyzer ID</label>
                                        <input class="form-control" type="text" placeholder="Analyzer ID">
                                    </div>

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">HID</label>
                                        <input v-model="form.hid" class="form-control" type="text" placeholder="HID">
                                    </div>

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Cable Length</label>
                                        <input v-model="form.cable_length" class="form-control" type="text" placeholder="Cable Length">
                                    </div>

                                    <div class="mb-3" v-if="filter == 2">
                                        <label class="fw-bold">Additional com</label>
                                        <input v-model="form.additional_com" class="form-control" type="text" placeholder="Additional Com">
                                    </div>

                                    <!-- Reg Key -->
                                    <div class="mb-3" v-if="filter == 4">
                                        <label class="fw-bold">Outlet ID</label>
                                        <input v-model="form.outlet_id" type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 4">
                                        <label class="fw-bold">Outlet Name</label>
                                        <input v-model="form.outlet_name" type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 4">
                                        <label class="fw-bold">Reason For Request</label>
                                        <textarea v-model="form.reason_reg" class="form-control" type="text" rows="4" placeholder="Details Description"></textarea>
                                    </div>

                                    <!-- Report And Data -->
                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Request Type</label>
                                        <select class="form-control">
                                            <option value="New">New</option>
                                            <option value="Edit">Edit</option>
                                        </select>
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Report ID</label>
                                        <input v-model="form.report_id" type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Report Name</label>
                                        <textarea v-model="form.report_name" type="text" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">PKG</label>
                                        <textarea type="text" v-model="form.pkg" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Report Type</label>
                                        <input v-model="form.report_type" type="text" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Report Date</label>
                                        <input type="text" v-model="form.report_date" class="form-control">
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Purpose</label>
                                        <textarea type="text" v-model="form.purpose" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Data Displayed</label>
                                        <textarea type="text" v-model="form.data_display" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3" v-if="filter == 5">
                                        <label class="fw-bold">Lis Menu Tag</label>
                                            <select class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="menu in lis_menu_app" :key="menu">{{ menu.app_name }}</option>
                                            </select>
                                    </div>

                                    <!-- CIS APP -->
                                    <div class="mb-3" v-if="filter == 6">
                                        <label class="fw-bold">Lis Menu Tag</label>
                                            <select class="form-select">
                                                <option disabled value> Choose One</option>
                                                <option v-for="menu in cis_menu_app" :key="menu">{{ menu.app_name }}</option>
                                            </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Summary *</label>
                                        <input v-model="form.title" class="form-control" type="text" rows="4" placeholder="Issue">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">File Upload</label>
                                        <input type="file"  @input="form.file_upload = $event.target.files[0]" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Issue Details</label>
                                        <Editor id="file-picker"
                                        api-key="no-api-key"
                                            v-model="form.description"
                                            :init="{
                                                menubar: false,
                                                plugins: 'image code emoticons preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars',
                                                image_title: true,
                                                automatic_uploads: false, 
                                                images_upload_url: '/api/upload-image',
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

    import { onMounted, reactive, ref } from 'vue';

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
            topics: Array,
            sla_plans: Array,
            tag_modules: Array,
            lis_menu_app: Array,
            cis_menu_app: Array,
            master_customers: Array,
            master_customer_branches: Array,
        },

        data: () => ({
            filter: '',
            postFormData: new FormData(),
            selectedChainIds: -1,
            selectedSubChainIds: -1,
        }),

        methods: {
            changeTopics: function(value) {
                value = value.target.value;
                this.filter = value;
            },

            getBranch() {
                this.form.branch_id = -1;
                if(!this.form.customer_id) {
                    this.form.customer_id = -1;
                }
            },
        },

        computed: {
            filteredChain() {
                let filteredsubChains = [];
                for(let i = 0 ; i < this.master_customer_branches.length ; i++) {
                    let structures = this.master_customer_branches[i];
                    if(structures.customer_id == this.form.customer_id) {
                        filteredsubChains.push(structures);
                    }
                }
                return filteredsubChains;
            },
        },

        setup(props) {

            var UrlOrigin = window.location.origin;

            const departments = ref({})

            const users = ref({
                getUser: false,
            })

            const customers = ref({})

            // const branchs = ref({
            //     getBranch: false,
            // })

            const slas = ref({
                getSla: false,
            })

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
                description: '',
                outlet_id: '',
                out_name: '',
                section_id: '',
                analyzer_id: '',
                analyzer_name: '',
                hid: '',
                cable_length: '',
                additional_com: '',
                reason_reg: '',
                tag_module_id: '',
                cis_menu_id: '',
                lis_menu_app: '',
                reg_report_type: '',
                report_id: '',
                report_name: '',
                pkg: '',
                report_type: '',
                report_date: '',
                purpose: '',
                file_upload: '',
                data_display: '',
                image: ''
            });

            onMounted(() => {

            axios.get(UrlOrigin+`/api/deparments`).then(response => {
                departments.value = response.data.data
                })
                .catch(error => {
                    console.log(error.response.data)
                })
                
            }) 

            function getSla() {
                axios.post(`http://localhost:8000/api/sla`, {
                    id: form.sla_id,
                }).then(response => {
                    slas.value = response.data
                }).then(() => {
                    this.slas.getSla = true
                })
                .catch(error => {
                    console.log(error.response.data)
                })
            }

            // function getBranch() {
            //     axios.post(UrlOrigin+`/api/branch`, {
            //         id: form.customer_id,
            //     }).then(response => {
            //         branchs.value = response.data.data
            //     }).then(() => {
            //         this.branchs.getBranch = true
            //     })
            //     .catch(error => {
            //         console.log(error.response.data)
            //     })
            // }

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

            const onFileChange = () => {
                    const files = this.files;
                    const formData = new formData();

                    files.forEach((file) => {
                        formData.append("selectedFiles", file);
                    });

                // Array.from(imageData).forEach(image => {
                //     if(!image.type.match('image.*')) {

                //         setImages([]);

                //         Swal.error({
                //                 title: 'Gambar Tidak Sesuai Format!',
                //                 text: 'Fail.',
                //                 icon: 'error',
                //                 showConfirmButton: false,
                //                 timer: 2000
                //             });

                //             return
                //     }else{
                //         setImages([...e.target.files]);
                //     }
                // });
            }
            
            const submit = () => {
                Inertia.post('/apps/master/tickets/store', {
                ticket_source:  form.ticket_source,
                department_id:  form.department_id,
                assign_id:      form.assign_id,
                topic_id:       form.topic_id,
                sla_id: form.sla_id,
                priority: form.priority,
                customer_id: form.customer_id,
                branch_id: form.branch_id,
                title: form.title,
                description: form.description,
                outlet_id: form.outlet_id,
                out_name: form.out_name,
                section_id: form.section_id,
                analyzer_id: form.analyzer_id,
                analyzer_name: form.analyzer_name,
                hid: form.hid,
                cable_length: form.cable_length,
                additional_com: form.additional_com,
                reason_reg: form.reason_reg,
                tag_module_id: form.tag_module_id,
                cis_menu_id: form.cis_menu_id,
                lis_menu_app: form.lis_menu_app,
                reg_report_type: form.reg_report_type,
                report_id: form.report_id,
                report_name: form.report_name,
                pkg: form.pkg,
                report_type: form.report_type,
                report_date: form.report_date,
                purpose: form.purpose,
                file_upload: form.file_upload,
                data_display: form.data_display,
                image: form.image
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
            slas,
            customers,
            // branchs,
            // getBranch,
            getUser,
            onFileChange,
            getSla,
            submit
        }
        }
        
    }
</script>

<style>

</style>